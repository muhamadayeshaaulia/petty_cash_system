<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200 border border-slate-100 p-8 lg:p-12">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Form Pengajuan Dana</h2>
            <p class="text-slate-400 text-sm">Masukkan detail keperluan operasional Anda secara akurat.</p>
        </div>

        <form action="/karyawan/pengajuan/store" method="POST" class="space-y-6 text-slate-800">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-800">
                <div class="space-y-1 text-slate-800">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-1">Tanggal</label>
                    <input type="date" name="tanggal_pengajuan" required class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 outline-none transition-all font-medium text-slate-800">
                </div>
                <div class="space-y-1 text-slate-800">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" required placeholder="0" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 outline-none transition-all font-black text-slate-800">
                </div>
            </div>
            <div class="space-y-1 text-slate-800">
                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Keperluan</label>
                <textarea name="keterangan" rows="4" required placeholder="Detail keperluan..." class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 outline-none transition-all text-slate-800"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-500/30 transition-all active:scale-[0.98]">
                Kirim Pengajuan Sekarang
            </button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>