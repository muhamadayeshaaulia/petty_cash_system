<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 6px 12px; border: none; cursor: pointer; color: white; text-decoration: none; display: inline-block; margin: 2px; border-radius: 4px; font-size: 14px; }
        .btn-green { background-color: #28a745; }
        .btn-red { background-color: #dc3545; }
        .alert-success { color: green; font-weight: bold; margin-bottom: 15px; padding: 10px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; }
        .alert-error { color: red; font-weight: bold; margin-bottom: 15px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; }
    </style>
</head>
<body>

    <h2>Selamat Datang, <?= session()->get('nama_lengkap'); ?> (Manager Keuangan)</h2>
    <a href="/logout" style="color: red; text-decoration: none; font-weight: bold;">[Logout]</a>
    <hr style="margin-bottom: 20px;">

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <h3>💳 Permintaan Isi Saldo (Top-Up) dari Admin</h3>
    <table>
        <tr style="background-color: #e3f2fd;">
            <th>Tanggal</th>
            <th>Diajukan Oleh</th>
            <th>Nominal Top-Up</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        
        <?php if(!empty($data_topup)): ?>
            <?php foreach($data_topup as $row): ?>
            <tr>
                <td><?= $row['tanggal_pengajuan']; ?></td>
                <td><b><?= $row['nama_lengkap']; ?></b></td>
                <td style="color: #0056b3; font-weight: bold;">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                <td>
                    <?php if($row['status'] == 'pending'): ?>
                        <span style="color: orange; font-weight: bold;">Menunggu ACC</span>
                    <?php elseif($row['status'] == 'disetujui'): ?>
                        <span style="color: green; font-weight: bold;">✅ Disetujui</span>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold;">❌ Ditolak</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($row['status'] == 'pending'): ?>
                        <a href="/manager/topup/acc/<?= $row['id_topup']; ?>" onclick="return confirm('ACC pencairan dana ini ke Saldo Admin?');" class="btn btn-green">✅ ACC</a>
                        <a href="/manager/topup/tolak/<?= $row['id_topup']; ?>" onclick="return confirm('Tolak permintaan isi saldo ini?');" class="btn btn-red">❌ Tolak</a>
                    <?php else: ?>
                        <i>Selesai</i>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" align="center"><i>Belum ada permintaan pengisian saldo dari Admin.</i></td></tr>
        <?php endif; ?>
    </table>


    <h3>📝 Daftar Persetujuan Petty Cash (Karyawan)</h3>
    <table>
        <tr>
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
                <?php elseif($row['status'] == 'dicairkan'): ?>
                    <span style="color: gray; font-weight: bold;">✅ Sudah Dicairkan Admin</span>
                <?php else: ?>
                    <span style="color: red; font-weight: bold;">Ditolak</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($row['status'] == 'diperiksa'): ?>
                    <a href="/manager/pengajuan/update/<?= $row['id_pengajuan']; ?>/disetujui" onclick="return confirm('ACC pengajuan dana ini?');" class="btn btn-green">Setujui</a>
                    <a href="/manager/pengajuan/update/<?= $row['id_pengajuan']; ?>/ditolak" onclick="return confirm('Tolak pengajuan ini?');" class="btn btn-red">Tolak</a>
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
                <td colspan="7" align="center"><i>Belum ada data pengajuan karyawan.</i></td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>