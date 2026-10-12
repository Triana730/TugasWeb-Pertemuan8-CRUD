<?php
require 'config/Database.php';
require 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = (int)($_POST['id'] ?? 0);

    try {
        $stmt = $db->prepare("DELETE FROM produk WHERE id = :id");
        $stmt->execute([':id' => $id]);
        setFlash('success', 'Produk berhasil dihapus.');
    } catch (PDOException $ex) {
        setFlash('error', 'Gagal menghapus produk.');
    }
}
header('Location: index.php');
exit;
