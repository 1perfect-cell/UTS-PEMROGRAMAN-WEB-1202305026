<?php
require 'db.php';
require 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo "<div class='alert alert-danger mt-3'>ID tidak valid.</div>";
    require 'footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM calibrations WHERE id = :id");
$stmt->execute([':id' => $id]);
$r = $stmt->fetch();

if (!$r) {
    echo "<div class='alert alert-warning mt-3'>Data tidak ditemukan.</div>";
    require 'footer.php';
    exit;
}
?>

<div class="card shadow-lg mx-auto mb-5" style="max-width: 800px; border-radius: 20px; background: rgba(255, 255, 255, 0.9);">
  <div class="card-header text-center fw-bold" style="background: #ffcc00; border-top-left-radius: 20px; border-top-right-radius: 20px;">
    DETAIL KALIBRASI #<?= htmlspecialchars($r['id']) ?>
  </div>
  <div class="card-body">
    <table class="table table-borderless">
      <tr>
        <th width="200">Device</th>
        <td><?= htmlspecialchars($r['device_name']) ?></td>
      </tr>
      <tr>
        <th>Model</th>
        <td><?= htmlspecialchars($r['model']) ?></td>
      </tr>
      <tr>
        <th>Serial Number</th>
        <td><?= htmlspecialchars($r['serial_number']) ?></td>
      </tr>
      <tr>
        <th>Tanggal Kalibrasi</th>
        <td><?= $r['calibration_date'] ?: '-' ?></td>
      </tr>
      <tr>
        <th>Teknisi</th>
        <td><?= htmlspecialchars($r['technician']) ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td>
          <?php if ($r['status'] === 'Selesai'): ?>
            <span class="badge bg-success"><?= htmlspecialchars($r['status']) ?></span>
          <?php elseif ($r['status'] === 'Proses'): ?>
            <span class="badge bg-warning text-dark"><?= htmlspecialchars($r['status']) ?></span>
          <?php else: ?>
            <span class="badge bg-secondary"><?= htmlspecialchars($r['status']) ?></span>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <th>Catatan</th>
        <td><?= nl2br(htmlspecialchars($r['notes'])) ?></td>
      </tr>
      <tr>
        <th>Dibuat</th>
        <td><?= htmlspecialchars($r['created_at']) ?></td>
      </tr>
    </table>

    <div class="text-center mt-4">
      <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning px-4 me-2"><i class="bi bi-pencil-square"></i> Edit</a>
      <a href="index.php" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
    </div>
  </div>
</div>

<?php require 'footer.php'; ?>
