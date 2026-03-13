<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>Form Pengajuan Petty Cash Baru</h2>
    <a href="/karyawan/dashboard">Kembali ke Dashboard</a>
    <hr>

    <form action="/karyawan/pengajuan/store" method="POST">
        <?= csrf_field() ?>
        
        <p>
            <label>Tanggal Pengajuan:</label><br>
            <input type="date" name="tanggal_pengajuan" required>
        </p>
        <p>
            <label>Keperluan / Keterangan:</label><br>
            <textarea name="keterangan" rows="4" cols="50" required placeholder="Contoh: Beli alat tulis kantor (ATK)..."></textarea>
        </p>
        <p>
            <label>Nominal (Rp):</label><br>
            <input type="number" name="nominal" required placeholder="Contoh: 150000">
        </p>
        <button type="submit">Kirim Pengajuan</button>
    </form>

</body>
</html>