<?php
//数据库连接
require_once '../Code/model.php';
$responseData = array("code" => 0,"message" => "","count" => "","data" => ":");
$arr = array();
$sql = "select ID, Name, PassWord, PhoneNum, Email, Login, Super from manager;";
$res = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($res)){
    $i++;
    array_push($arr,$row);
}




$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

mysqli_close($conn);
?>