<?php
//数据库连接
session_start();
require_once '../Code/model.php';
$responseData = array("code" => 0,"message" => "","count" => "","data" => ":");
//从注册页面接受来的数据
$re = $_POST['d'];
$man = $_SESSION['name'];
$rec = json_decode($re,true);
$time = $_POST['time'];
$id = $rec["id"];
$name = $rec['name'];
$password = $rec['password'];
$phoneNum = $rec['phoneNum'];
$email = $rec['email'];
$pallow = $rec['allow'];


//查询人员插入操作人
$oop = "select * from manager where ID= '$man' or Name= '$man';";
$roop = mysqli_query($conn,$oop);
$riip = mysqli_fetch_assoc($roop);
$oid = $riip['ID'];
$oname = $riip['Name'];
$o = $oid.":".$oname;

if(!$conn){
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}

//查询数据是不是已经拥有该编号和姓名
$sql = "select * from manager where Name='$name';";
$sql1 = "INSERT INTO manager (ID,Name,PassWord,PhoneNum,Email,Super,Login) VALUES ('$id','$name','$password','$phoneNum','$email','超级管理员','离线');";
$sql2 = "INSERT INTO manager (ID,Name,PassWord,PhoneNum,Email,Super,Login) VALUES ('$id','$name','$password','$phoneNum','$email','管理员','离线');";
//插入历史表
$cel = "insert into manager_history (ID, Name, PassWord, PhoneNum, Email, Super, Operate, ChangeTime) values ('$id','$name','$password','注册登记','','超级管理员','$o','$time');";
$cel2 = "insert into manager_history (ID, Name, PassWord, PhoneNum, Email, Super, Operate, ChangeTime) values ('$id','$name','$password','注册登记','','管理员','$o','$time');";
$res = mysqli_query($conn,$sql);
$row = mysqli_num_rows($res);

if($row==0){
      if($pallow == 'on'){
          $res1 = mysqli_query($conn,$sql1);
          $rip = mysqli_query($conn,$cel);
          $responseData['code'] = 3;
          $responseData['message'] = "注册成功";
          echo json_encode($responseData); 
      }else{
        $res1 = mysqli_query($conn,$sql2);
        $rip = mysqli_query($conn,$cel2);
        $responseData['code'] = 3;
        $responseData['message'] = "注册成功";
        echo json_encode($responseData); 
      }

}else{
     $responseData['code'] = 2;
     $responseData['message'] = "此编号/此人已注册";
     echo json_encode($responseData);
}

$arr = array();
$responseData['count'] = $i;
$responseData['data'] = $arr;

mysqli_close($conn);
