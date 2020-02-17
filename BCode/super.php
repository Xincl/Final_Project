<?php
session_start();
//数据库连接
require_once '../Code/model.php';
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");
$man = $_SESSION['name'];

//接受前端页面传来的消息
$rec = $_POST['data'];
$id = $rec['ID'];
$name = $rec['Name'];
$time2 = $_POST['time2'];

//查询操作人
$oop = "select * from manager where ID= '$man' or Name= '$man';";
$roop = mysqli_query($conn,$oop);
$riip = mysqli_fetch_assoc($roop);
$oid = $riip['ID'];
$oname = $riip['Name'];
$o = $oid.":".$oname;

//查找表中所选人员权限情况
$sql = "select * from manager where ID= '$id';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$super = $row['Super'];

if(strcmp($super,"超级管理员")==0){
    $cel = "UPDATE manager set Super= '管理员' where ID= '$id';";
    $res = mysqli_query($conn, $cel);
    $responseData['code'] = 2;
    $responseData['message'] = "已将权限降级为管理员";
    $superc = $super."-->管理员";
}else{
    $cel = "UPDATE manager set Super= '超级管理员' where ID= '$id';";
    $res = mysqli_query($conn, $cel);
    $responseData['code'] = 3;
    $responseData['message'] = "已将权限升级为超级管理员";
    $superc = $super."-->超级管理员";
}
    
$seel = "INSERT into manager_history (ID,Name,PassWord,PhoneNum,Email,Super,ChangeTime,Operate) values('$id','$name','无改变','无改变','无改变','$superc','$time2','$o')";
$rip = mysqli_query($conn, $seel);

$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

mysqli_close($conn);
?>
