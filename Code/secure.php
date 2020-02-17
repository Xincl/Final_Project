<?php

//打开session
session_start();
//数据库连接
require_once 'model.php';
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");

$arr = array();

$re = $_POST['d'];
$rec = json_decode($re, true);
$time = $_POST['time'];
$id = $_SESSION['name'];
$pwdO = $rec['passwordOld'];
$pwdN = $rec['passwordNew'];
$pwdS = $rec['password'];

//判断数据库连接
if (!$conn) {
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}

//查询之前数据库
$cel = "select ID,Name,PassWord from manager where ID = '$id' or Name= '$id';";
$result = mysqli_query($conn, $cel);
$row = mysqli_fetch_assoc($result);
$Bpwd = $row['PassWord']; //获得未改变之前的密码
$rid = $row['ID'];
$rname = $row['Name'];

if ($pwdO != $Bpwd) {
    $responseData['code'] = 2;
    $responseData['message'] = "输入密码错误";
    echo json_encode($responseData);
    exit;
}
if ($pwdN != $pwdS) {
    $responseData['code'] = 3;
    $responseData['message'] = "确认密码错误，请重新输入";
    echo json_encode($responseData);
    exit;
}
if($Bpwd == $pwdN){
    $responseData['code'] = 4;
    $responseData['message'] = "密码无改变，请重新输入";
    echo json_encode($responseData);
    exit;
}
//记录表写法
$Bpwd2 = $Bpwd . "-->" . $pwdN;
$operate = $rid.":".$rname;

//将其插入历史记录表中，manager_history
$his = "insert into manager_history (ID,Name,PassWord,PhoneNum,Email,Super,ChangeTime,Operate) values ('$rid','$rname','$Bpwd2','无修改','无修改','无修改','$time','$operate');";
$rip = mysqli_query($conn, $his);

//修改管理人员原生表
$sql = "update manager set PassWord= '$pwdN' where ID=  '$id' or Name= '$id';";
$res = mysqli_query($conn, $sql);
$responseData['code'] = 5;
$responseData['message'] = "密码修改成功";

$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

mysqli_close($conn);

?>
