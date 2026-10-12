<?php
require 'config/Database.php';
require 'helpers.php';

$db = Database::getInstance()->getConnection();
$id = (int)($_GET['id'] ?? 0);

$stmt = $db->prepare("SELECT * FROM produk WHERE id = :id");
$stmt->execute([':id' => $id]);
$produk = $stmt->fetch();

if (!$produk) {
    setFlash('error', 'Produk tidak ditemukan.');
    header('Location: index.php');
    exit;
}

$kategori = $db->query("SELECT id, nama FROM kategori ORDER BY nama")->fetchAll();
$supplier = $db->query("SELECT id, nama FROM supplier ORDER BY nama")->fetchAll();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk = [
        'nama'        => trim($_POST['nama'] ?? ''),
        'harga'       => $_POST['harga'] ?? '',
        'stok'        => $_POST['stok'] ?? '',
        'kategori_id' => $_POST['kategori_id'] ?? '',
        'supplier_id' => $_POST['supplier_id'] ?? '',
    ];

    if ($produk['nama'] === '') $errors[] = 'Nama produk wajib diisi.';
    if (!is_numeric($produk['harga']) || $produk['harga'] < 0) $errors[] = 'Harga tidak valid.';
    if (filter_var($produk['stok'], FILTER_VALIDATE_INT) === false || $produk['stok'] < 0) $errors[] = 'Stok tidak valid.';
    if ($produk['kategori_id'] === '' || $produk['supplier_id'] === '') $errors[] = 'Kategori dan supplier wajib dipilih.';

    if (!$errors) {
        try {
            $stmt = $db->prepare(
                "UPDATE produk SET nama=:nama, harga=:harga, stok=:stok,
                 kategori_id=:kid, supplier_id=:sid WHERE id=:id"
            );
            $stmt->execute([
                ':nama'  => $produk['nama'],
                ':harga' => $produk['harga'],
                ':stok'  => $produk['stok'],
                ':kid'   => $produk['kategori_id'],
                ':sid'   => $produk['supplier_id'],
                ':id'    => $id,
            ]);
            setFlash('success', 'Produk berhasil diperbarui.');
        } catch (PDOException $ex) {
            setFlash('error', 'Gagal memperbarui produk.');
        }
        header('Location: index.php');
        exit;
    }
}

$judul = 'Edit Produk';
include '_form.php';
