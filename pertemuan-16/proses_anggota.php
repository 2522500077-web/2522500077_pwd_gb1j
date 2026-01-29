<?php
session_start();
require __DIR__ . './koneksi.php';
require_once __DIR__ . '/fungsi.php';

#cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#anggota');
}

#ambil dan bersihkan nilai dari form
$noang  = bersihkan($_POST['txtNoAng']  ?? '');
$nama = bersihkan($_POST['txtNmAng'] ?? '');
$jabatan = bersihkan($_POST['txtJabAng'] ?? '');
$tanggal = bersihkan($_POST['txtTglJadi'] ?? '');
$skill = bersihkan($_POST['txtSkill'] ?? '');
$gaji = bersihkan($_POST['txtGaji'] ?? '');
$nowa = bersihkan($_POST['txtNoWA'] ?? '');
$batalion = bersihkan($_POST['txBatalion'] ?? '');
$bb = bersihkan($_POST['txtBB'] ?? '');
$tb = bersihkan($_POST['txtTB'] ?? '');

#Validasi sederhana
$errors = []; #ini array untuk menampung semua error yang ada

if ($noang === '') {
  $errors[] = 'Nomor Anggota wajib diisi.';
}
if ($nama === '') {
  $errors[] = 'Nama Anggota wajib diisi.';
}
if ($jabatan === '') {
  $errors[] = 'Jabatan Anggota wajib diisi.';
}
if ($tanggal === '') {
  $errors[] = 'Tanggal Jadi Anggota wajib diisi.';
}
if ($skill === '') {
  $errors[] = 'Kemampuan Anggota wajib diisi.';
}
if ($gaji === '') {
  $errors[] = 'Gaji Anggota wajib diisi.';
}
if ($nowa === '') {
  $errors[] = 'Nomor WA wajib diisi.';
}
if ($batalion === '') {
  $errors[] = 'Batalion Anggota wajib diisi.';
}
if ($bb === '') {
  $errors[] = 'Berat Badan wajib diisi.';
}
if ($tb === '') {
  $errors[] = 'Tinggi Badan wajib diisi.';
}

/*
kondisi di bawah ini hanya dikerjakan jika ada error, 
simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
*/
if (!empty($errors)) {
  $_SESSION['old'] = [
"noang" => $noang,
  "nama" => $nama,
  "jabatan" => $jabatan,
  "tanggal" => $tanggal,
  "skill" => $skill,
  "gaji" => $gaji,
  "nowa" => $nowa,
  "batalion" => $batalion,
  "bb" => $bb,
  "tb" => $tb
];

  $_SESSION['flash_error'] = implode('<br>', $errors);
  redirect_ke('index.php#anggota');
}

#menyiapkan query INSERT dengan prepared statement
$sql = "INSERT INTO tbl_anggota (nomorrafa, namarafa, jabatan, kemampuanrafa, gajirafa, warafa, batalionrafa, beratrafa, tinggirafa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  #jika gagal prepare, kirim pesan error ke pengguna (tanpa detail sensitif)
  $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#anggota');
}
#bind parameter dan eksekusi (s = string)
mysqli_stmt_bind_param($stmt, "ssssssss", $noang, $nama, $jabatan, $skill, $gaji, $nowa, $batalion, $bb, $tb);

if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value, beri pesan sukses
  unset($_SESSION['old']);
  $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
  redirect_ke('index.php#anggota'); #pola PRG: kembali ke form / halaman home
} else { #jika gagal, simpan kembali old value dan tampilkan error umum
  $_SESSION['old'] = [
    "noang" => $noang,
    "nama" => $nama,
    "jabatan" => $jabatan,
    "tanggal" => $tanggal,
    "skill" => $skill,
    "gaji" => $gaji,
    "nowa" => $nowa,
    "batalion" => $batalion,
    "bb" => $bb,
    "tb" => $tb 
  ];
  $_SESSION['flash_error'] = 'Data gagal disimpan. Silakan coba lagi.';
  redirect_ke('index.php#anggota');
}
#tutup statement
mysqli_stmt_close($stmt);