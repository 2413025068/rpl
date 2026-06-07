CREATE DATABASE presensi_db;

USE presensi_db;

CREATE TABLE presensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20),
    tanggal DATE,
    jam_masuk TIME,
    status VARCHAR(20)
);

INSERT INTO siswa (nis, nama, kelas, password)
VALUES
('123456', 'Ahmad Rizky', 'XII IPA 1', '123456'),
('789012', 'Siti Nurhaliza', 'XII IPS 2', '789012');
