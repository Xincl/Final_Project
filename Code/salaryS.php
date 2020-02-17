<?php
header("Content-Type:text/html;charset=utf-8");
$rec = $_POST['re'];
$responseData = array("code" => 0,"message" => "","count" => "","data" => ":");
require_once 'model.php';
if(!$conn){
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}
$sql = "select FID,FName,FAge,FComeTime,FWorkTime,FSalary from prisoner where FName='$rec';";
$res = mysqli_query($conn,$sql);
$arr = array();

while($row = mysqli_fetch_assoc($res)){
    $i++;
    array_push($arr,$row);
}
$responseData['count'] = $i;
$responseData['data'] = $arr;

echo json_encode($responseData);

mysqli_close($conn);
?>