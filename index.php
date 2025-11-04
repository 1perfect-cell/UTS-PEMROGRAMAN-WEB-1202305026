<?php
require 'db.php';
require 'header.php';

// Pagination sederhana (opsional)
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Search
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$params = [];
$where = '';
if ($search !== '') {
    $where = "WHERE device_name LIKE :s OR model LIKE :s OR serial_number LIKE :s OR technician LIKE :s";
    $params[':s'] = "%$search%";
}

// Count total
$stmt = $pdo->prepare("SELECT COUNT(*) FROM calibrations $where");
$stmt->execute($params);
$total = $stmt->fetchColumn();

// Fetch rows
$stmt = $pdo->prepare("SELECT * FROM calibrations $where ORDER BY created_at DESC LIMIT :offset, :limit");
foreach ($params as $k=>$v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Daftar Alkes</h3>
  <a href="create.php" class="btn btn-success">+ Tambah Baru</a>
</div>

<form class="row g-2 mb-3" method="get" action="index.php">
  <div class="col-auto">
    <input type="text" name="q" class="form-control" placeholder="Cari device, model, teknisi..." value="<?= htmlspecialchars($search) ?>">
  </div>
  <div class="col-auto">
    <button class="btn btn-outline-primary">Cari</button>
  </div>
</form>

<table class="table table-striped table-bordered">
  <thead class="table-light">
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
    <?php if ($rows): foreach ($rows as $r): ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= htmlspecialchars($r['device_name']) ?></td>
      <td><?= htmlspecialchars($r['model']) ?></td>
      <td><?= htmlspecialchars($r['serial_number']) ?></td>
      <td><?= $r['calibration_date'] ? htmlspecialchars($r['calibration_date']) : '-' ?></td>
      <td><?= htmlspecialchars($r['technician']) ?></td>
      <td><?= htmlspecialchars($r['status']) ?></td>
      <td>
        <a href="view.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">Lihat</a>
        <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="delete.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?php
// Pagination links
$pages = ceil($total / $perPage);
if ($pages > 1):
?>
<nav>
  <ul class="pagination">
    <?php for ($p=1;$p<=$pages;$p++): ?>
      <li class="page-item <?= $p==$page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $p ?><?= $search ? '&q='.urlencode($search) : '' ?>"><?= $p ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

<?php require 'footer.php'; ?>
