<?php
require 'config/Database.php';
require 'helpers.php';

$db = Database::getInstance()->getConnection();
$kategori = $db->query("SELECT id, nama FROM kategori ORDER BY nama")->fetchAll();
$supplier = $db->query("SELECT id, nama FROM supplier ORDER BY nama")->fetchAll();

$produk = ['nama'=>'', 'harga'=>'', 'stok'=>'', 'kategori_id'=>'', 'supplier_id'=>''];
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
                "INSERT INTO produk (nama, harga, stok, kategori_id, supplier_id)
                 VALUES (:nama, :harga, :stok, :kid, :sid)"
            );
            $stmt->execute([
                ':nama'  => $produk['nama'],
                ':harga' => $produk['harga'],
                ':stok'  => $produk['stok'],
                ':kid'   => $produk['kategori_id'],
                ':sid'   => $produk['supplier_id'],
            ]);
            setFlash('success', 'Produk berhasil ditambahkan.');
        } catch (PDOException $ex) {
            setFlash('error', 'Gagal menambahkan produk.');
        }
        header('Location: index.php');
        exit;
    }
}

$judul = 'Tambah Produk';
include '_form.php';
