<?php
session_start();
//数据库连接
require_once '../Code/model.php';
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");
$man = $_SESSION['name'];
$arr = array();

$value = $_POST['value'];
$data = $_POST['data'];
$field = $_POST['field'];
$time2 = $_POST['time2'];

$id = $data['ID'];
$name = $data['Name'];
$password = $data['PassWord'];
$phoneNum = $data['PhoneNum'];
$email = $data['Email'];

//判断数据库连接
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

//查询之前数据库
$cel = "select Name, PassWord ,PhoneNum, Email from manager where ID = '$id';";
$result = mysqli_query($conn,$cel);
$row = mysqli_fetch_assoc($result);
$nname = $row['Name'];
$npassword = $row['PassWord'];
$nphoneNum= $row['PhoneNum'];
$nemail = $row['Email'];

//判断名字是否相同
if(strcmp($name,$nname)==0){
    $namef = '无改变';
}else{
    $namef = $nname."-->".$name;
}
//判断密码是否相同
if(strcmp($password,$npassword)==0){
    $passwordf = '无改变';
}else{
    $passwordf = $npassword."-->".$password;
}
//判断手机号码是否相同
if(strcmp($phoneNum,$nphoneNum)==0){
    $phoneNumf = '无改变';
}else{
    $phoneNumf = $nphoneNum."-->".$phoneNum;
}
//判断邮箱是否相同
if(strcmp($email,$nemail)==0){
    $emailf = '无改变';
}else{
    $emailf = $nemail."-->".$email;
}

//将其插入历史记录表中
$his = "insert into manager_history (ID,Name,PassWord,PhoneNum,Email,Super,ChangeTime,Operate) values ('$id','$namef','$passwordf','$phoneNumf','$emailf','无改变','$time2','$o');";
$rip = mysqli_query($conn,$his);

//修改管理人员原生表
$sql = "update manager set Name= '$name',PassWord= '$password',PhoneNum= '$phoneNum',Email= '$email' where ID=  '$id';";
$res = mysqli_query($conn,$sql);
$responseData['code'] = 3;
$responseData['message'] = "修改成功";

$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);



mysqli_close($conn);
?>