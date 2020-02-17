<?php
//数据库连接
require_once 'model.php';
//从登录页接受来的数据
session_start();
$name=$_POST['username'];
$pwd=$_POST['password'];
$sql="select Name,PassWord,Super from manager where (Name='$name' AND PassWord='$pwd') or (ID= '$name' and PassWord= '$pwd');";
$result=mysqli_query($conn,$sql);
$row=mysqli_num_rows($result);

if(!$row){

    echo "<script>alert('密码错误，请重新输入');location='../page/login.html'</script>";

}
else{
    $cel = "select * from manager where (Login= '在线' and Name='$name' AND PassWord='$pwd') or (Login= '在线' and ID= '$name' and PassWord= '$pwd');";
    $rel = mysqli_query($conn,$cel);
    if($row1 = mysqli_fetch_assoc($rel)){
        echo "<script>alert('用户已登录');location='../page/login.html'</script>";
    }else{
        $_SESSION['name'] = $name;
        $seel = "update manager set Login= '在线' where Name= '$name' or ID= '$name';";
        $rip = mysqli_query($conn,$seel);
        $_SESSION['username'] = $name;
        echo "<script>alert('登录成功');location='../page/Home.html'</script>";
    }

};
?>