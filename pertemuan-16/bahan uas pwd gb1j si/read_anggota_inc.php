    <?php
require 'koneksi.php';

 $fieldConfig = [
      "noang" => ["label" => "Nomor Anggota:", "suffix" => ""],
      "nama" => ["label" => "Nama Anggota:", "suffix" => " &#128526;"],
      "jabatan" => ["label" => "Jabatan Anggota:", "suffix" => ""],
      "tanggal" => ["label" => "Tanggal Jadi Anggota:", "suffix" => ""],
      "skill" => ["label" => "Kemampuan Anggota:", "suffix" => " &#127926;"],
      "gaji" => ["label" => "Gaji Anggota:", "suffix" => " &hearts;"],
      "nowa" => ["label" => "Nomor WA:", "suffix" => " &copy; 2025"],
      "batalion" => ["label" => "Batalion Anggota:", "suffix" => ""],
      "bb" => ["label" => "Berat Badan:", "suffix" => ""],
      "tb" => ["label" => "Tinggi Badan:", "suffix" => ""],
    ];

$sql = "SELECT * FROM tbl_tamu ORDER BY cid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
  echo "<p>Gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
} elseif (mysqli_num_rows($q) === 0) {
  echo "<p>Belum ada data tamu yang tersimpan.</p>";
} else {
  while ($row = mysqli_fetch_assoc($q)) {
  $arrAnggota = [
  "noang" => $_POST["txtNoAng"] ?? "",
  "nama" => $_POST["txtNmAng"] ?? "",
  "jabatan" => $_POST["txtJabAng"] ?? "",
  "tanggal" => $_POST["txtTglJadi"] ?? "",
  "skill" => $_POST["txtSkill"] ?? "",
  "gaji" => $_POST["txtGaji"] ?? "",
  "nowa" => $_POST["txtBatalion"] ?? "",
  "batalion" => $_POST["txBatalion"] ?? "",
  "bb" => $_POST["txtBB"] ?? "",
  "tb" => $_POST["txtTB"] ?? ""
];
    echo tampilkanData($fieldConfig, $arrAnggota);
  }
}
?>