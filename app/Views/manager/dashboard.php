<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>Selamat Datang, <?= session()->get('nama_lengkap'); ?> (Manager Keuangan)</h2>
    <a href="/logout" style="color: red;">[Logout]</a>
    <hr>

    <h3>Daftar Persetujuan Petty Cash</h3>
    
    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><b><?= session()->getFlashdata('success'); ?></b></p>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Karyawan</th>
            <th>Keterangan</th>
            <th>Nominal</th>
            <th>Status Saat Ini</th>
            <th>Aksi (Keputusan Manager)</th>
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
                    <span style="color: orange;">Belum dicek Admin</span>
                <?php elseif($row['status'] == 'diperiksa'): ?>
                    <span style="color: blue; font-weight: bold;">Butuh Persetujuan Anda</span>
                <?php elseif($row['status'] == 'disetujui'): ?>
                    <span style="color: green; font-weight: bold;">Telah Disetujui</span>
                <?php else: ?>
                    <span style="color: red; font-weight: bold;">Ditolak</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($row['status'] == 'diperiksa'): ?>
                    <a href="/manager/pengajuan/update/<?= $row['id_pengajuan']; ?>/disetujui" onclick="return confirm('ACC pengajuan dana ini?');">
                        <button style="background-color: green; color: white;">Setujui</button>
                    </a>
                    <a href="/manager/pengajuan/update/<?= $row['id_pengajuan']; ?>/ditolak" onclick="return confirm('Tolak pengajuan ini?');">
                        <button style="background-color: red; color: white;">Tolak</button>
                    </a>
                <?php elseif($row['status'] == 'pending'): ?>
                    <i>Menunggu Admin</i>
                <?php else: ?>
                    <i>Selesai</i>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if(empty($pengajuan)): ?>
            <tr>
                <td colspan="7" align="center">Belum ada data pengajuan.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>