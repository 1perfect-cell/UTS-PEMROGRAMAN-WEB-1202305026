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
$row = $stmt->fetch();
if (!$row) {
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
    require 'footer.php';
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_name = trim($_POST['device_name'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $serial_number = trim($_POST['serial_number'] ?? '');
    $calibration_date = $_POST['calibration_date'] ?? null;
    $technician = trim($_POST['technician'] ?? '');
    $status = $_POST['status'] ?? 'PENDING';
    $notes = trim($_POST['notes'] ?? '');

    if ($device_name === '') $errors[] = 'Nama device wajib diisi.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE calibrations SET device_name=:device_name, model=:model, serial_number=:serial_number, calibration_date=:calibration_date, technician=:technician, status=:status, notes=:notes WHERE id=:id");
        $stmt->execute([
            ':device_name'=>$device_name,
            ':model'=>$model?:null,
            ':serial_number'=>$serial_number?:null,
            ':calibration_date'=>$calibration_date?:null,
            ':technician'=>$technician?:null,
            ':status'=>$status,
            ':notes'=>$notes?:null,
            ':id'=>$id
        ]);
        header('Location: index.php');
        exit;
    }
}
?>
<h3>Edit Kalibrasi (#<?= $row['id'] ?>)</h3>

<?php if ($errors): ?>
<div class="alert alert-danger">
  <ul class="mb-0">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Nama Device</label>
    <input name="device_name" class="form-control" value="<?= htmlspecialchars($_POST['device_name'] ?? $row['device_name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Model</label>
    <input name="model" class="form-control" value="<?= htmlspecialchars($_POST['model'] ?? $row['model']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Serial Number</label>
    <input name="serial_number" class="form-control" value="<?= htmlspecialchars($_POST['serial_number'] ?? $row['serial_number']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Tanggal Kalibrasi</label>
    <input name="calibration_date" type="date" class="form-control" value="<?= htmlspecialchars($_POST['calibration_date'] ?? $row['calibration_date']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Teknisi</label>
    <input name="technician" class="form-control" value="<?= htmlspecialchars($_POST['technician'] ?? $row['technician']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php $sel = $_POST['status'] ?? $row['status']; ?>
      <option value="OK" <?= $sel==='OK' ? 'selected' : '' ?>>OK</option>
      <option value="REPAIR" <?= $sel==='REPAIR' ? 'selected' : '' ?>>REPAIR</option>
      <option value="PENDING" <?= $sel==='PENDING' ? 'selected' : '' ?>>PENDING</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="4"><?= htmlspecialchars($_POST['notes'] ?? $row['notes']) ?></textarea>
  </div>
  <button class="btn btn-primary">Update</button>
  <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require 'footer.php'; ?>
