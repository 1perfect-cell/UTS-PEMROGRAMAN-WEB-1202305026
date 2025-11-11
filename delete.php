<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM calibrations WHERE id = ?");
    $stmt->execute([$id]);
}

// Setelah hapus, redirect ke index dengan parameter notifikasi
header("Location: index.php?deleted=true");
exit;
?>