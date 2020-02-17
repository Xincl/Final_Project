<?php
//数据库连接
require_once 'model.php';
$responseData = array("code" => 0, "message" => "", "count" => "", "data" => ":");

//接受结束按钮传递来的数据
$endTime = $_POST['endTime'];
$time2 = $_POST['time2'];
$arr = array();
$v = array(); //存储ID数组
$sel = "select FID,FWorkStart from prisoner where FWorkStart != 0;";
$result = mysqli_query($conn, $sel);

//取出所有符合条件的ID，存入数组
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['FID'];
    $timestart = $row['FWorkStart'];
    array_push($v, $id);//存入ID数组
    // array_push($t,$workstart);//存入时间数组
}

if(!$conn){
    $responseData['code'] = 1;
    $responseData['message'] = "数据库连接失败";
    echo json_encode($responseData);
    exit;
}
if(count($v)==0){
    $responseData['code'] = 2;
    $responseData['message'] = "暂无服刑人员在进行工作";
    echo json_encode($responseData);
    exit;
}

//查询人员插入操作人
$oop = "select * from manager where ID= '$man' or Name= '$man';";
$roop = mysqli_query($conn,$oop);
$riip = mysqli_fetch_assoc($roop);
$oid = $riip['ID'];
$oname = $riip['Name'];
$o = " , ".$oid.":".$oname;

//将记录插入工作记录表中
for($i=0;$i<count($v);$i++){
   $cel = "UPDATE work_history set FWorkEnd= '$time2' ,FOperate= FOperate+'$o'  where FID='$v[$i]' and FWorkEnd= '未结束劳动' and FReason= '无请假';"; 
   $rip = mysqli_query($conn,$cel);
}

$time = $endTime - $timestart;
$timemin = ceil($time/60);
$salary = $timemin*0.05;

array_push($arr,$timemin);

//根据V数组中的ID，插入计算后的时间
for($i=0;$i<count($v);$i++){
  $sql = "UPDATE prisoner SET FWorkTime = FWorkTime+'$timemin' , FWorkStart=0 ,FSalary = FSalary+'$salary' where FID = '$v[$i]';";
  $res = mysqli_query($conn,$sql);
}
$responseData['code'] = 3;
$responseData['message'] = "所有人的工作结束了";
$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

// echo json_encode($responseData);

mysqli_close($conn);
?>