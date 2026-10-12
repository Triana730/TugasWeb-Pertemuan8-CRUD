CREATE DATABASE IF NOT EXISTS inventaris_db CHARACTER SET utf8mb4;
USE inventaris_db;

CREATE TABLE kategori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telepon VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(150) NOT NULL,
  harga DECIMAL(12,2) NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  kategori_id INT NOT NULL,
  supplier_id INT NOT NULL,
  FOREIGN KEY (kategori_id) REFERENCES kategori(id),
  FOREIGN KEY (supplier_id) REFERENCES supplier(id)
) ENGINE=InnoDB;

INSERT INTO kategori (nama) VALUES
('Elektronik'),('Alat Tulis'),('Perabot'),('Makanan'),('Minuman');

INSERT INTO supplier (nama, telepon) VALUES
('PT Maju Jaya','061111111'),('CV Sinar Terang','061222222'),
('UD Berkah','061333333'),('PT Nusantara','061444444'),('CV Sentosa','061555555');

INSERT INTO produk (nama, harga, stok, kategori_id, supplier_id) VALUES
('Mouse Wireless', 85000, 20, 1, 1),
('Pulpen Gel', 3500, 200, 2, 2),
('Kursi Kantor', 650000, 8, 3, 3),
('Biskuit Kaleng', 45000, 40, 4, 4),
('Air Mineral 600ml', 4000, 150, 5, 5);
