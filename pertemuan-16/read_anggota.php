<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  $sql = "SELECT * FROM tbl_anggota ORDER BY cid DESC";
  $q = mysqli_query($conn, $sql);
  if (!$q) {
    die("Query error: " . mysqli_error($conn));
  }
?>

<?php
  $flash_suksesanggota = $_SESSION['flash_suksesanggota'] ?? ''; #jika query sukses
  $flash_erroranggota  = $_SESSION['flash_erroranggota'] ?? ''; #jika ada error
  #bersihkan session ini
  unset($_SESSION['flash_suksesanggota'], $_SESSION['flash_erroranggota']); 
?>

<?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_suksesanggota; ?>
        </div>
<?php endif; ?>

<?php if (!empty($flash_erroranggota)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_erroranggota; ?>
        </div>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Aksi</th>
    <th>ID</th>
    <th>Nomor Anggota</th>
    <th>Nama Anggota</th>
    <th>Jabatan</th>
    <th>Tanggal Jadi</th>
    <th>Kemampuan</th>
    <th>Gaji</th>
    <th>Nomor WA</th>
    <th>Batalion</th>
    <th>Berat Badan</th>
    <th>Tinggi Badan</th>

  </tr>
  <?php $i = 1; ?>
  <?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td>
        <a href="edit_anggota.php?cid=<?= (int)$row['cid']; ?>">Edit</a>
        <a onclick="return confirm('Hapus <?= htmlspecialchars($row['cnama']); ?>?')" href="proses_delete_anggota.php?cid=<?= (int)$row['cid']; ?>">Delete</a>
      </td>
      <td><?= $row['cid']; ?></td>
      <td><?= htmlspecialchars($row['nomorrafa']); ?></td>
      <td><?= htmlspecialchars($row['namarafa']); ?></td>
      <td><?= htmlspecialchars($row['jabatan']); ?></td>
      <td><?= htmlspecialchars($row['tanggalrafa']); ?></td>
      <td><?= htmlspecialchars($row['kemampuanrafa']); ?></td>
      <td><?= htmlspecialchars($row['gajirafa']); ?></td>
      <td><?= htmlspecialchars($row['warafa']); ?></td>
      <td><?= htmlspecialchars($row['batalionrafa']); ?></td>
      <td><?= htmlspecialchars($row['beratrafa']); ?></td>
      <td><?= htmlspecialchars($row['tinggirafa']); ?></td>
     
    </tr>
  <?php endwhile; ?>
</table>