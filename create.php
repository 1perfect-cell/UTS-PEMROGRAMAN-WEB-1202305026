<?php
require 'db.php';
require 'header.php';

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
        $stmt = $pdo->prepare("INSERT INTO calibrations (device_name, model, serial_number, calibration_date, technician, status, notes) VALUES (:device_name, :model, :serial_number, :calibration_date, :technician, :status, :notes)");
        $stmt->execute([
            ':device_name'=>$device_name,
            ':model'=>$model?:null,
            ':serial_number'=>$serial_number?:null,
            ':calibration_date'=>$calibration_date?:null,
            ':technician'=>$technician?:null,
            ':status'=>$status,
            ':notes'=>$notes?:null
        ]);
        header('Location: index.php');
        exit;
    }
}
?>
<h3>Tambah Kalibrasi</h3>

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
    <input name="device_name" class="form-control" value="<?= htmlspecialchars($_POST['device_name'] ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Model</label>
    <input name="model" class="form-control" value="<?= htmlspecialchars($_POST['model'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Serial Number</label>
    <input name="serial_number" class="form-control" value="<?= htmlspecialchars($_POST['serial_number'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Tanggal Kalibrasi</label>
    <input name="calibration_date" type="date" class="form-control" value="<?= htmlspecialchars($_POST['calibration_date'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Teknisi</label>
    <input name="technician" class="form-control" value="<?= htmlspecialchars($_POST['technician'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php $sel = $_POST['status'] ?? 'PENDING'; ?>
      <option value="OK" <?= $sel==='OK' ? 'selected' : '' ?>>OK</option>
      <option value="REPAIR" <?= $sel==='REPAIR' ? 'selected' : '' ?>>REPAIR</option>
      <option value="PENDING" <?= $sel==='PENDING' ? 'selected' : '' ?>>PENDING</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="4"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require 'footer.php'; ?>