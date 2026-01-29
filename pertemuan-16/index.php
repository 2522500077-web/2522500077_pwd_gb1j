<?php
session_start();
require_once __DIR__ . '/fungsi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Judul Halaman</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1>Ini Header</h1>
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
      &#9776;
    </button>
    <nav>
      <ul>
        <li><a href="#home">Beranda</a></li>
        <li><a href="#about">Tentang</a></li>
        <li><a href="#contact">Kontak</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="home">
      <h2>Selamat Datang</h2>
      <?php
      echo "halo dunia!<br>";
      echo "nama saya hadi";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>
 <?php
    $flash_suksesanggota = $_SESSION['flash_suksesanggota'] ?? ''; #jika query sukses
    $flash_erroranggota  = $_SESSION['flash_erroranggota'] ?? ''; #jika ada error
    $oldanggota          = $_SESSION['oldanggota'] ?? []; #untuk nilai lama form

    unset($_SESSION['flash_suksesanggota'], $_SESSION['flash_erroranggota'], $_SESSION['oldanggota']); #bersihkan 3 session ini
    ?>
    <section id="anggota">
      <h2>Data Anggota</h2>
      <form action="proses_anggota.php" method="POST">

      <label for="txtNoAng"><span>Nama:</span>
          <input type="text" id="txtNoAng" name="txtNoAng" placeholder="Masukkan nomor anggota"
            required autocomplete="noang"
            value="<?= isset($old['noang']) ? htmlspecialchars($old['noang']) : '' ?>">
        </label>
      <label for="txtNmAng"><span>Nama:</span>
          <input type="text" id="txtNmAng" name="txtNmAng" placeholder="Masukkan nama anggota"
            required autocomplete="nama"
            value="<?= isset($old['nama']) ? htmlspecialchars($old['nama']) : '' ?>">
        </label>
      <label for="txtJabAng"><span>Jabatan:</span>
          <input type="text" id="txtJabAng" name="txtJabAng" placeholder="Masukkan jabatan anggota"
            required autocomplete="jabatan"
            value="<?= isset($old['jabatan']) ? htmlspecialchars($old['jabatan']) : '' ?>">
        </label>
      <label for="txtTglJadi"><span>Tanggal Jadi Anggota:</span>
          <input type="text" id="txtTglJadi" name="txtTglJadi" placeholder="Masukkan Tanggal Jadi Anggota"
            required autocomplete="tgljadi"
            value="<?= isset($old['tanggal']) ? htmlspecialchars($old['tanggal']) : '' ?>">
        </label>
      <label for="txtSkill"><span>Kemampuan Anggota:</span>
          <input type="text" id="txtSkill" name="txtSkill" placeholder="Masukkan Kemampuan Anggota"
            required autocomplete="skill"
            value="<?= isset($old['skill']) ? htmlspecialchars($old['skill']) : '' ?>">
        </label>
      <label for="txtGaji"><span>Gaji Anggota:</span>
          <input type="text" id="txtGaji" name="txtGaji" placeholder="Masukkan Gaji Anggota"
            required autocomplete="gaji"
            value="<?= isset($old['gaji']) ? htmlspecialchars($old['gaji']) : '' ?>">
        </label>
      <label for="txtNoWa"><span>Nomor WA:</span>
          <input type="text" id="txtNoWa" name="txtNoWa" placeholder="Masukkan Nomor WA"
            required autocomplete="nowa"
            value="<?= isset($old['nowa']) ? htmlspecialchars($old['nowa']) : '' ?>">
        </label>
      <label for="txBatalion"><span>Batalion Anggota:</span>
          <input type="text" id="txBatalion" name="txBatalion" placeholder="Masukkan Batalion Anggota"
            required autocomplete="batalion"
            value="<?= isset($old['batalion']) ? htmlspecialchars($old['batalion']) : '' ?>">
        </label>
      <label for="txtBB"><span>Berat Badan:</span>
          <input type="text" id="txtBB" name="txtBB" placeholder="Masukkan Berat Badan"
            required autocomplete="bb"
            value="<?= isset($old['bb']) ? htmlspecialchars($old['bb']) : '' ?>">
        </label>
      <label for="txtTB"><span>Tinggi Badan:</span>
          <input type="text" id="txtTB" name="txtTB" placeholder="Masukkan Tinggi Badan"
            required autocomplete="tb"
            value="<?= isset($old['tb']) ? htmlspecialchars($old['tb']) : '' ?>">
        </label>
        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>
    </section>

    <section id="about">
      <h2>Tentang Saya</h2>
      <?php include 'read_anggota_inc.php' ?>
    </section>

    <?php
    $flash_sukses = $_SESSION['flash_sukses'] ?? ''; #jika query sukses
    $flash_error  = $_SESSION['flash_error'] ?? ''; #jika ada error
    $old          = $_SESSION['old'] ?? []; #untuk nilai lama form

    unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old']); #bersihkan 3 session ini
    ?>

    <section id="contact">
      <h2>Kontak Kami</h2>

      <?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
      <?php endif; ?>

      <form action="proses.php" method="POST">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama"
            required autocomplete="name"
            value="<?= isset($old['nama']) ? htmlspecialchars($old['nama']) : '' ?>">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email"
            required autocomplete="email"
            value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..."
            required><?= isset($old['pesan']) ? htmlspecialchars($old['pesan']) : '' ?></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>

        <label for="txtCaptcha"><span>Captcha 2 + 3 = ?</span>
          <input type="number" id="txtCaptcha" name="txtCaptcha" placeholder="Jawab Pertanyaan..."
            required
            value="<?= isset($old['captcha']) ? htmlspecialchars($old['captcha']) : '' ?>">
        </label>

        <button type=" submit">Kirim</button>
          <button type="reset">Batal</button>
      </form>

      <br>
      <hr>
      <h2>Yang menghubungi kami</h2>
      <?php include 'read_inc.php'; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>