<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>Selamat Datang, <?= session()->get('nama_lengkap'); ?> (Karyawan)</h2>
    <a href="/logout" style="color: red;">[Logout]</a>
    <hr>

    <h3>Riwayat Pengajuan Petty Cash Anda</h3>
    
    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><b><?= session()->getFlashdata('success'); ?></b></p>
    <?php endif; ?>

    <a href="/karyawan/pengajuan/create"><button style="margin-bottom: 15px;">+ Buat Pengajuan Baru</button></a>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Nominal</th>
            <th>Status</th>
        </tr>
        
        <?php $no = 1; foreach($pengajuan as $row): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['tanggal_pengajuan']; ?></td>
            <td><?= $row['keterangan']; ?></td>
            <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
            <td>
                <?php if($row['status'] == 'pending'): ?>
                    <span style="color: orange; font-weight: bold;">Menunggu Admin</span>
                <?php elseif($row['status'] == 'diperiksa'): ?>
                    <span style="color: blue; font-weight: bold;">Diperiksa Manager</span>
                <?php elseif($row['status'] == 'disetujui'): ?>
                    <span style="color: green; font-weight: bold;">Disetujui</span>
                <?php else: ?>
                    <span style="color: red; font-weight: bold;">Ditolak</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if(empty($pengajuan)): ?>
            <tr>
                <td colspan="5" align="center">Belum ada data pengajuan.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>