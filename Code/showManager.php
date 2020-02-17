<?php
//数据库连接
require_once 'model.php';
$responseData = array("code" => 0,"message" => "","count" => "","data" => ":");
session_start();
$arr = array();
$name = $_SESSION['name'];
$sql = "select ID, Name, PhoneNum, Email from manager where (Login= '在线' and ID= '$name') or (Login= '在线' and Name= '$name');";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);

array_push($arr,$row);

$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

mysqli_close($conn);
?>