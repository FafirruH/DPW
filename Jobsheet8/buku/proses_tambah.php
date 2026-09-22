<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tglMasuk  = $_POST['tgl_masuk'] ?? '';
$isbn      = trim($_POST['isbn'] ?? '');
$harga     = $_POST['harga'] ?? 0;
$stok      = $_POST['stok'] ?? 0;
$kategori  = trim($_POST['kategori'] ?? '');

$errors = [];
if ($judul === '') {
    $errors[] = "Nama barang wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Produsen / Merek wajib diisi.";
}
if ($tglMasuk === '') {
    $errors[] = "Tanggal barang masuk wajib diisi.";
}
if (!is_numeric($harga) || $harga < 0) {
    $errors[] = "Harga barang tidak boleh negatif.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}
if ($kategori === '') {
    $errors[] = "Kategori barang wajib dipilih.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
    "INSERT INTO barang (judul, pengarang, tahun, isbn, harga, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :harga, :stok, :kategori)
     RETURNING id"
);
    $stmt->execute([
        'judul'     => $judul,
        'pengarang' => $pengarang,
        'tahun'     => $tglMasuk,
        'isbn'      => $isbn,
        'harga'     => (float) $harga,
        'stok'      => (int) $stok,
        'kategori'  => $kategori,
    ]);

    $totalPengeluaran = (float) $harga * (int) $stok;
    if ($totalPengeluaran > 0) {
        $stmtTrx = $pdo->prepare(
            "INSERT INTO transaksi (jenis, nominal, keterangan, tanggal)
             VALUES ('keluar', :nominal, :keterangan, :tanggal)"
        );
        $stmtTrx->execute([
            'nominal'    => $totalPengeluaran,
            'keterangan' => "Pembelian/Stok Masuk: " . $judul . " (" . $stok . " pcs)",
            'tanggal'    => $tglMasuk
        ]);
    }

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang masuk berhasil disimpan & pengeluaran telah dicatat.'];

} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data: ' . $e->getMessage()];
}

header('Location: list.php');
exit;