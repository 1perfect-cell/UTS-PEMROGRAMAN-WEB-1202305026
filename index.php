<?php
require 'db.php';
require 'header.php';

// Query semua data kalibrasi
$stmt = $pdo->query("SELECT * FROM calibrations ORDER BY id DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Daftar Alkes</h3>
<div class="mb-3 d-flex">
  <input type="text" class="form-control me-2" placeholder="Cari device, model, teknisi">
  <button class="btn btn-primary">Cari</button>
</div>

<a href="create.php" class="btn btn-success mb-3">+ Tambah Baru</a>

<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Device</th>
      <th>Model</th>
      <th>Serial</th>
      <th>Tgl Kalibrasi</th>
      <th>Teknisi</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['device_name']) ?></td>
        <td><?= htmlspecialchars($r['model']) ?></td>
        <td><?= htmlspecialchars($r['serial_number']) ?></td>
        <td><?= htmlspecialchars($r['calibration_date']) ?></td>
        <td><?= htmlspecialchars($r['technician']) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
        <td>
          <a href="view.php?id=<?= $r['id'] ?>" class="btn btn-info btn-sm text-white">Lihat</a>
          <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $r['id'] ?>">Hapus</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require 'footer.php'; ?>