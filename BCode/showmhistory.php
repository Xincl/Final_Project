<?php
header("Content-Type:text/html;charset=utf-8");
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");
require_once '../Code/model.php';
$arr = array();
$id = $_POST['ID'];
$name = $_POST['Name'];
if (!$conn) {
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}
if ($id) {
    $cel = "select ID,Name,PassWord,PhoneNum,Email,Super,Operate,ChangeTime from manager_history where ID= '$id' or Name= '$name';";
    $rip = mysqli_query($conn, $cel);
    
    while($rew = mysqli_fetch_assoc($rip)){
        $i++;
        array_push($arr, $rew);     
    }
} else {
    $sql = "select ID,Name,PassWord,PhoneNum,Email,Super,Operate,ChangeTime from manager_history;";
    $res = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($res)) {
        $i++;
        array_push($arr, $row);
    }
}

$responseData['count'] = $i;
$responseData['data'] = $arr;

echo json_encode($responseData);
?>