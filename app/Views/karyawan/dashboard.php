<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="space-y-6">
    <div class="bg-gradient-to-br from-slate-800 via-slate-900 to-black rounded-[2rem] p-8 lg:p-10 text-white relative overflow-hidden shadow-2xl shadow-slate-400">
        <h2 class="text-3xl lg:text-4xl font-black mb-2 text-white italic">Halo, <?= explode(' ', session()->get('nama_lengkap'))[0]; ?>! 👋</h2>
        <p class="text-slate-400 text-lg">Pantau status pengajuan dana Petty Cash Anda di sini.</p>
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-600 rounded-full blur-[80px] opacity-40"></div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200 border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-black text-xl text-slate-800">Riwayat Pengajuan</h3>
            <a href="/karyawan/pengajuan/create" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-blue-500/20 text-sm hover:scale-105 transition-transform">+ Ajukan Baru</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-800">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Nominal</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $no = 1; foreach($pengajuan as $row): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-medium text-slate-400"><?= $no++; ?></td>
                        <td class="px-6 py-4 text-xs font-bold"><?= date('d/m/Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                        <td class="px-6 py-4 text-sm font-black text-right">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-black border border-blue-100 uppercase"><?= $row['status']; ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>