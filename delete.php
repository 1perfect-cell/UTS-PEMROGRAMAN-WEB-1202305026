<?php
require 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM calibrations WHERE id = :id");
    $stmt->execute([':id'=>$id]);
}
header('Location: index.php');
exit;
