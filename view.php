<?php
require 'db.php';
require 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo "<div class='alert alert-danger'>ID tidak valid.</div>";
    require 'footer.php';
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM calibrations WHERE id = :id");
$stmt->execute([':id'=>$id]);
$r = $stmt->fetch();
if (!$r) {
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
    require 'footer.php';
    exit;
}
?>
<h3>Detail Kalibrasi #<?= $r['id'] ?></h3>
<table class="table table-bordered w-75">
  <tr><th>Device</th><td><?= htmlspecialchars($r['device_name']) ?></td></tr>
  <tr><th>Model</th><td><?= htmlspecialchars($r['model']) ?></td></tr>
  <tr><th>Serial Number</th><td><?= htmlspecialchars($r['serial_number']) ?></td></tr>
  <tr><th>Tanggal Kalibrasi</th><td><?= $r['calibration_date'] ?: '-' ?></td></tr>
  <tr><th>Teknisi</th><td><?= htmlspecialchars($r['technician']) ?></td></tr>
  <tr><th>Status</th><td><?= htmlspecialchars($r['status']) ?></td></tr>
  <tr><th>Catatan</th><td><?= nl2br(htmlspecialchars($r['notes'])) ?></td></tr>
  <tr><th>Dibuat</th><td><?= $r['created_at'] ?></td></tr>
</table>
<a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning">Edit</a>
<a href="index.php" class="btn btn-secondary">Kembali</a>

<?php require 'footer.php'; ?>
