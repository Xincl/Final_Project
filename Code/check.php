<?php
session_start();
//数据库连接
require_once 'model.php';
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");
$man = $_SESSION['name'];
$arr = array();

$sql = "select * from manager where (ID= '$man' and Super= '超级管理员') or (Name= '$man' and Super= '超级管理员');";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);

if($row){
    $responseData['code'] = 3;
    $responseData['message'] = "跳转成功"; 
    echo json_encode($responseData);
}else{
    $responseData['code'] = 2;
    $responseData['message'] = "跳转失败"; 
    echo json_encode($responseData);
}
 
mysqli_close($conn);
?>