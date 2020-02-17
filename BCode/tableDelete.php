<?php
header("Content-Type:text/html;charset=utf-8");
//加载数据库文件
require_once '../Code/model.php';
session_start();
$man = $_SESSION['name'];
$rec = $_POST['data'];
$time2 = $_POST['time2'];
$id = $rec['ID'];
$name = $rec['Name'];
$password = $rec['PassWord'];
$super = $rec['Super'];
$responseData = array("code" => 0,"message" => "","count" => "","data" => ":");

if(!$conn){
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}

//查询人员插入操作人
$oop = "select * from manager where ID= '$man' or Name= '$man';";
$roop = mysqli_query($conn,$oop);
$riip = mysqli_fetch_assoc($roop);
$oid = $riip['ID'];
$oname = $riip['Name'];
$o = $oid.":".$oname;

//插入记录表
$cel = "insert into manager_history (ID,Name,PassWord,PhoneNum,Email,Super,Operate,ChangeTime) values ('$id','$name','$password','删除用户','','$super','$o','$time2');";
$rip = mysqli_query($conn,$cel);

//删除原生表 manager 记录
$sql = "delete from manager where ID='$id';";
$res = mysqli_query($conn,$sql);
$arr = array();

$responseData['count'] = $i;
$responseData['data'] = $arr;
if(!$res){
    $responseData['code'] = 2;
    $responseData['message'] = "删除失败";
    echo json_encode($responseData);
}else{
    $responseData['message'] = "删除成功";
    echo json_encode($responseData);
}
mysqli_close($conn);
?>