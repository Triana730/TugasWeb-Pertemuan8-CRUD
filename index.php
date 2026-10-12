<?php
require 'config/Database.php';
require 'helpers.php';

$db = Database::getInstance()->getConnection();

$sql = "SELECT p.id, p.nama, p.harga, p.stok,
               k.nama AS kategori, s.nama AS supplier
        FROM produk p
        JOIN kategori k ON p.kategori_id = k.id
        JOIN supplier s ON p.supplier_id = s.id
        ORDER BY p.id DESC";
$daftar = $db->query($sql)->fetchAll();
$flash  = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventaris</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <h1>Daftar Produk</h1>

  <?php if ($flash): ?>
    <div class="alert <?= e($flash['tipe']) ?>"><?= e($flash['pesan']) ?></div>
  <?php endif; ?>

  <a href="create.php" class="btn">+ Tambah Produk</a>

  <table>
    <tr>
      <th>No</th><th>Nama</th><th>Kategori</th><th>Supplier</th>
      <th>Harga</th><th>Stok</th><th>Aksi</th>
    </tr>
    <?php foreach ($daftar as $i => $row): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= e($row['nama']) ?></td>
      <td><?= e($row['kategori']) ?></td>
      <td><?= e($row['supplier']) ?></td>
      <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
      <td><?= e($row['stok']) ?></td>
      <td>
        <a href="edit.php?id=<?= (int)$row['id'] ?>">Edit</a>
        <form action="delete.php" method="post" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus produk ini?')">
          <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
          <button type="submit" class="btn-hapus">Hapus</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
