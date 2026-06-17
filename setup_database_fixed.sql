-- Setup tabel untuk Sistem Presensi Siswa (versi yang udah diperbaiki)
-- TIDAK perlu CREATE DATABASE / USE, soalnya database udah dibuat lewat panel InfinityFree
-- Import file ini lewat phpMyAdmin > tab Import (pastikan database if0_42206208_webrplazizah aktif di sidebar kiri)

DROP TABLE IF EXISTS presensi;
DROP TABLE IF EXISTS siswa;

CREATE TABLE siswa (
    nis VARCHAR(20) NOT NULL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    password VARCHAR(50) NOT NULL
);

CREATE TABLE presensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20),
    tanggal DATE,
    jam_masuk TIME,
    status VARCHAR(20)
);

INSERT INTO siswa (nis, nama, kelas, password) VALUES
('123456', 'Ahmad Rizky', 'XII IPA 1', '123456'),
('789012', 'Siti Nurhaliza', 'XII IPS 2', '789012');
