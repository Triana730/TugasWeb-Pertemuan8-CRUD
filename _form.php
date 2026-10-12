<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul) ?></title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <h1><?= e($judul) ?></h1>

  <?php foreach ($errors as $err): ?>
    <div class="alert error"><?= e($err) ?></div>
  <?php endforeach; ?>

  <form method="post">
    <label>Nama Produk</label>
    <input type="text" name="nama" value="<?= e($produk['nama']) ?>" required>

    <label>Harga</label>
    <input type="number" name="harga" step="0.01" min="0" value="<?= e($produk['harga']) ?>" required>

    <label>Stok</label>
    <input type="number" name="stok" min="0" value="<?= e($produk['stok']) ?>" required>

    <label>Kategori</label>
    <select name="kategori_id" required>
      <option value="">-- Pilih Kategori --</option>
      <?php foreach ($kategori as $k): ?>
        <option value="<?= (int)$k['id'] ?>"
          <?= $produk['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
          <?= e($k['nama']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Supplier</label>
    <select name="supplier_id" required>
      <option value="">-- Pilih Supplier --</option>
      <?php foreach ($supplier as $s): ?>
        <option value="<?= (int)$s['id'] ?>"
          <?= $produk['supplier_id'] == $s['id'] ? 'selected' : '' ?>>
          <?= e($s['nama']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button type="submit" class="btn">Simpan</button>
    <a href="index.php">Batal</a>
  </form>
</div>
</body>
</html>
