<?php
//数据库连接
require_once 'model.php';
session_start();
$name = $_SESSION['name'];
$sql = "update manager set Login= '离线' where (Login= '在线' and ID= '$name') or (Login= '在线' and Name= '$name');";
$res = mysqli_query($conn,$sql);

session_destroy();
mysqli_close($conn);

?>