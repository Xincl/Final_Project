<?php
//数据库连接
require_once 'model.php';
//从注册页面接受来的数据
$pid = $_POST['id'];
$pname = $_POST['name'];
$psex = $_POST['sex'];
$page = $_POST['age'];
$pkind = $_POST['kind'];
$pprison = $_POST['prison'];
$pcomtime = $_POST['cometime'];
$pallow = $_POST['allow'];

//根据规则计算ID 
$num = rand(0,100);
$rid = $pid.$num;

$pid = $pbid+mt_rand(0,50);

//查询数据是不是已经拥有该编号和姓名
$sql = "select * from prisoner where FID='$pid' AND FName='$pname';";
// $sql = "select * from prisoner where FID=2";
$res = mysqli_query($conn,$sql);
$row = mysqli_num_rows($res);

if(!$row){
    if($pallow == ""){
        $sql1="INSERT INTO prisoner (FID, FName, FSex, FAge, FKind, FPrison, FComeTime, FWorkTime, FSalary) VALUES ('$rid','$pname','$psex','$page','$pkind','$pprison','$pcomtime','无法劳动','无法劳动');";
        $res1=mysqli_query($conn,$sql1);
        echo "<script>alert('注册成功');location='../page/register.html'</script>";
     }else{
        $sql1="INSERT INTO prisoner (FID, FName, FSex, FAge, FKind, FPrison, FComeTime, FWorkTime, FSalary) VALUES ('$rid','$pname','$psex','$page','$pkind','$pprison','$pcomtime','0','0');";
        $res1=mysqli_query($conn,$sql1);
        echo "<script>alert('注册成功');location='../page/register.html'</script>";
     } 
}else{
     echo "<script>alert('此编号/此人已注册');location='../page/register.html'</script>";
};



mysqli_close($conn);

?>