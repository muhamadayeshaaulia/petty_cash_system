<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        #sidebar { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease-in-out; }
        #main-content { transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-text { white-space: nowrap; transition: opacity 0.2s; }
        .is-minimized .sidebar-text { opacity: 0; display: none; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-20 hidden backdrop-blur-sm" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-64 bg-slate-900 text-slate-300 z-30 -translate-x-full lg:translate-x-0 flex flex-col border-r border-slate-800 overflow-hidden">
        <div class="h-20 flex items-center px-6 mb-2">
            <div class="flex items-center gap-3 min-w-max">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl uppercase">S</div>
                <div class="sidebar-text">
                    <h2 class="text-white font-bold text-lg leading-none tracking-tight">SARILING</h2>
                    <span class="text-[10px] text-slate-500 uppercase tracking-[0.2em]">Petty Cash</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-2">
            <?php $dashActive = url_is('karyawan/dashboard') || url_is('karyawan'); ?>
            <a href="/karyawan/dashboard" 
            class="flex items-center justify-start h-12 px-3 rounded-2xl transition-all group overflow-hidden 
            <?= $dashActive ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/20 font-bold' : 'hover:bg-slate-800 text-slate-400' ?>">
                <div class="w-10 flex-shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span class="sidebar-text ml-3">Dashboard</span>
            </a>

            <?php $createActive = url_is('karyawan/pengajuan/create'); ?>
            <a href="/karyawan/pengajuan/create" 
            class="flex items-center justify-start h-12 px-3 rounded-2xl transition-all group overflow-hidden 
            <?= $createActive ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/20 font-bold' : 'hover:bg-slate-800 text-slate-400' ?>">
                <div class="w-10 flex-shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="sidebar-text ml-3">Buat Pengajuan</span>
            </a>
        </nav>
        <div class="p-3 border-t border-slate-800">
            <a href="/logout" onclick="return confirm('Keluar?')" class="flex items-center justify-start h-12 px-3 text-red-400 hover:bg-red-500/10 rounded-2xl transition-all font-semibold overflow-hidden">
                <div class="w-10 flex-shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                </div>
                <span class="sidebar-text ml-3 font-medium">Logout</span>
            </a>
        </div>
    </aside>

    <main id="main-content" class="flex-1 flex flex-col min-w-0 lg:ml-64 transition-all">
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-10 text-slate-800">
            <button onclick="toggleSidebar()" class="p-2 hover:bg-slate-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <div class="flex items-center gap-3 font-bold uppercase tracking-tight text-sm italic">
                <?= session()->get('nama_lengkap'); ?>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <?= $this->renderSection('content'); ?>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const mainContent = document.getElementById('main-content');
        let isMinimized = false;

        function toggleSidebar() {
            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            } else {
                if (!isMinimized) {
                    sidebar.style.width = '80px';
                    mainContent.style.marginLeft = '80px';
                    sidebar.querySelectorAll('nav a, div a').forEach(el => {
                        el.classList.remove('justify-start'); el.classList.add('justify-center');
                        el.classList.remove('px-3'); el.classList.add('px-0');
                    });
                    sidebar.classList.add('is-minimized');
                    isMinimized = true;
                } else {
                    sidebar.style.width = '256px';
                    mainContent.style.marginLeft = '256px';
                    sidebar.querySelectorAll('nav a, div a').forEach(el => {
                        el.classList.add('justify-start'); el.classList.remove('justify-center');
                        el.classList.add('px-3'); el.classList.remove('px-0');
                    });
                    sidebar.classList.remove('is-minimized');
                    isMinimized = false;
                }
            }
        }
    </script>
</body>
</html>