<?php
session_start();
require_once "config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role']!="doctor"){
header("Location: login.php");
exit();
}

$id = intval($_GET['id']);
$status = $_GET['status'];

$stmt = $conn->prepare("UPDATE appointments SET status=? WHERE id=?");
$stmt->bind_param("si",$status,$id);
$stmt->execute();

header("Location: doctor_appointments.php");
exit();
?>