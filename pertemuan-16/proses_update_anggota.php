<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #cek method form, hanya izinkan POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read_anggota.php');
  }

  #validasi cid wajib angka dan > 0
  $cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$cid) {
    $_SESSION['flash_error'] = 'CID Tidak Valid.';
    redirect_ke('edit_anggota.php?cid='. (int)$cid);
  }

  #ambil dan bersihkan (sanitasi) nilai dari form
  $noang  = bersihkan($_POST['txtNoAng']  ?? '');
  $nama = bersihkan($_POST['txtNmAng'] ?? '');
  $jabatan = bersihkan($_POST['txtJabAng'] ?? '');
  $tgljadi = bersihkan($_POST['txtTglJadi'] ?? '');
  $skill = bersihkan($_POST['txtSkill'] ?? '');
  $gaji = bersihkan($_POST['txtGaji'] ?? '');
  $nowa = bersihkan($_POST['txtNoWa'] ?? '');
  $batalion = bersihkan($_POST['txBatalion'] ?? '');
  $bb = bersihkan($_POST['txtBB'] ?? '');
  $tb = bersihkan($_POST['txtTB'] ?? '');

  #Validasi sederhana
  $errors = []; #ini array untuk menampung semua error yang ada

  if ($noang === '') {
    $errors[] = 'No Anggota wajib diisi.';
  }

    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if ($jabatan === '') {
        $errors[] = 'Jabatan wajib diisi.';
    }
    if ($tgljadi === '') {
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
    $_SESSION['oldanggota'] = [
      'noang'  => $noang,
      'nama'   => $nama,
      'jabatan' => $jabatan,
      'tgljadi' => $tgljadi,
      'skill'  => $skill,
      'gaji'   => $gaji,
      'nowa'   => $nowa,
      'batalion' => $batalion,
      'bb'     => $bb,
      'tb'     => $tb
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit_anggota.php?cid='. (int)$cid);
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE cid = ?)
  */
  $stmt = mysqli_prepare($conn, "UPDATE tbl_anggota 
                                SET nomorrafa = ?, namarafa = ?, jabatan = ? , tanggalrafa = ?, kemampuanrafa = ?, gajirafa = ?, warafa = ?, batalionrafa = ?, beratrafa = ?, tinggirafa = ? 
                                WHERE cid = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit_anggota.php?cid='. (int)$cid);
  }

  #bind parameter dan eksekusi (s = string, i = integer)
  mysqli_stmt_bind_param($stmt, "ssssi", $noang, $nama, $jabatan, $tgljadi, $skill, $gaji, $nowa, $batalion, $bb, $tb, $cid);

  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    unset($_SESSION['oldanggota']);
    /*
      Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('read.php'); #pola PRG: kembali ke data dan exit()
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['oldanggota'] = [
      'noang'  => $noang,
      'nama'   => $nama,
      'jabatan' => $jabatan,
      'tgljadi' => $tgljadi,
      'skill'  => $skill,
      'gaji'   => $gaji,
      'nowa'   => $nowa,
      'batalion' => $batalion,
      'bb'     => $bb,
      'tb'     => $tb
    ];
    $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('edit_anggota.php?cid='. (int)$cid);
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('edit_anggota.php?cid='. (int)$cid);