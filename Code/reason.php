<?php
session_start();
//数据库连接
require_once 'model.php';
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");
$man = $_SESSION['name'];

//接受前端页面传来的消息
$rec = $_POST['data'];
$endtime = $_POST['endTime'];
$pid = $rec['FID'];
$pname = $rec['FName'];
$r = $_POST['r'];
$time2 = $_POST['time2'];

//查询人员插入操作人
$oop = "select * from manager where ID= '$man' or Name= '$man';";
$roop = mysqli_query($conn,$oop);
$riip = mysqli_fetch_assoc($roop);
$oid = $riip['ID'];
$oname = $riip['Name'];
$o = $oid.":".$oname;

//查找表中所选人员是否在工作，有工作才可以请假
$sql = "select * from prisoner where FID= '$pid' and FWorkStart != '0';";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_num_rows($result)) {
    while($rew = mysqli_fetch_assoc($result)){
        $timestart = $rew['FWorkStart'];
    }
    
    $time = $endtime-$timestart;
    $timemin = ceil($time/60);
    $salary = $timemin * 0.05;
    $cel = "update work_history set FReason= '$r' ,FWorkEnd= '$time2' ,FOperate= concat(FOperate,' , ','$o') where FID= '$pid' and FWorkEnd= '未结束劳动';";
    $res = mysqli_query($conn, $cel);
    $seel = "UPDATE prisoner SET FWorkTime = FWorkTime+'$timemin' , FWorkStart= '0' ,FSalary = FSalary+'$salary' where FID= '$pid';";
    $rip = mysqli_query($conn, $seel);
    $responseData['code'] = 3;
    $responseData['message'] = "请假成功";
} else {
    $responseData['code'] = 2;
    $responseData['message'] = "所选人员不在工作无法请假";
}
$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

mysqli_close($conn);
?>
