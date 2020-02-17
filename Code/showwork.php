<?php
header("Content-Type:text/html;charset=utf-8");
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");
require_once 'model.php';
$arr = array();
$pid = $_POST['FID'];
$pname = $_POST['FName'];
if (!$conn) {
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}
if ($pid) {
    $cel =  "select FID,FName,FWorkStart,FWorkEnd,FReason from work_history where FID= '$pid' or FName= '$pname';";
    $rip = mysqli_query($conn, $cel);
    
    while($rew = mysqli_fetch_assoc($rip)){
        $i++;
        array_push($arr, $rew);     
    }
} else {
    $sql = "select FID,FName,FWorkStart,FWorkEnd,FReason from work_history;";
    $res = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($res)) {
        $i++;
        array_push($arr, $row);
    }
}

$responseData['count'] = $i;
$responseData['data'] = $arr;

echo json_encode($responseData);
