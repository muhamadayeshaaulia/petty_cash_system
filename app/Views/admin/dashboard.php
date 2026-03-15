<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .box-saldo { background-color: #e3f2fd; padding: 20px; border-radius: 8px; border: 1px solid #90caf9; margin-bottom: 20px; }
        .alert-success { color: green; font-weight: bold; margin-bottom: 15px; }
        .alert-error { color: red; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Selamat Datang, <?= session()->get('nama_lengkap'); ?> (Admin Keuangan)</h2>
    <a href="/logout" style="color: red;">[Logout]</a>
    <hr>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="box-saldo">
        <h3 style="margin-top: 0;">💳 Informasi Saldo Petty Cash</h3>
        <h1 style="color: #1565c0; margin: 10px 0;">Rp <?= number_format($total_saldo, 0, ',', '.'); ?></h1>
        <p>Sisa Kuota Pengisian Saldo Bulan Ini: <b>Rp <?= number_format($sisa_kuota, 0, ',', '.'); ?></b></p>
        
        <hr style="border: 0.5px solid #90caf9;">
        
        <h4>Ajukan Pengisian Saldo ke Manager</h4>
        <form action="/admin/topup/ajukan" method="post">
            <input type="number" name="nominal" min="1000" max="<?= $sisa_kuota; ?>" placeholder="Masukkan Nominal..." required style="padding: 8px; width: 200px;">
            <button type="submit" style="padding: 8px 15px; background-color: #0d47a1; color: white; border: none; cursor: pointer;">Ajukan Top-Up</button>
        </form>
    </div>

    <h3>Daftar Pengajuan Karyawan</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Karyawan</th>
            <th>Keterangan</th>
            <th>Nominal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        
        <?php $no = 1; foreach($pengajuan as $row): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['tanggal_pengajuan']; ?></td>
            <td><b><?= $row['nama_lengkap']; ?></b></td>
            <td><?= $row['keterangan']; ?></td>
            <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
            <td>
                <?php if($row['status'] == 'pending'): ?>
                    <span style="color: orange;">Baru (Belum Dicek)</span>
                <?php elseif($row['status'] == 'diperiksa'): ?>
                    <span style="color: blue;">Menunggu ACC Manager</span>
                <?php elseif($row['status'] == 'disetujui'): ?>
                    <span style="color: green; font-weight: bold;">Di-ACC Manager (Siap Cair)</span>
                <?php elseif($row['status'] == 'dicairkan'): ?>
                    <span style="color: gray; font-weight: bold;">✅ Sudah Dicairkan</span>
                <?php else: ?>
                    <span style="color: red; font-weight: bold;">Ditolak</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($row['status'] == 'pending'): ?>
                    <a href="/admin/pengajuan/teruskan/<?= $row['id_pengajuan']; ?>" onclick="return confirm('Teruskan ke Manager?');">
                        <button style="background-color: blue; color: white; padding: 5px;">Teruskan ke Manager</button>
                    </a>
                <?php elseif($row['status'] == 'disetujui'): ?>
                    <a href="/admin/pengajuan/cairkan/<?= $row['id_pengajuan']; ?>" onclick="return confirm('Cairkan dana ini? Saldo utama akan berkurang.');">
                        <button style="background-color: green; color: white; padding: 5px;">💸 Cairkan Dana</button>
                    </a>
                <?php else: ?>
                    <i>-</i>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if(empty($pengajuan)): ?>
            <tr><td colspan="7" align="center">Belum ada data pengajuan.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>