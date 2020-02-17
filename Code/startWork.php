<?php
//数据库连接
session_start();
require_once 'model.php';
$responseData = array("code" => 0,"message" => "","count" => "","data" => ":");
$man = $_SESSION['name'];

//接受开始按钮传递来的数据
$re = $_POST['data'];
$rec = json_decode($re,true);
$time = $_POST['time'];
$time2 = $_POST['time2'];
$arr = array();
$v = array();
$n = array();
$id = array();
$name = array();
//将ID放进一个数组
for($i=0;$i<count($rec);$i++){
    $v[$i] = $rec[$i]['FID'];
}
//将名字放进一个数组
for($i=0;$i<count($rec);$i++){
  $n[$i] = $rec[$i]['FName'];
}

if(!$conn){
  $responseData['code'] = 1;
  $responseData['message'] = "数据库连接失败";
  echo json_encode($responseData);
  exit;
}

if(count($v)==0){
  $responseData['code'] = 4;
  $responseData['message'] = "没有选择服刑人员进行工作";
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

//判断勾选的人员是否有已经在工作
for($i=0;$i<count($v);$i++){
  $seel = "select FID,FName,FWorkStart from prisoner where FWorkStart != 0 and FID = '$v[$i]';";
  $result = mysqli_query($conn, $seel);
  if($row = mysqli_fetch_assoc($result)){
    $id = $row['FID'];
    $name = $row['FName'];
    $responseData['code'] = 2;
    $responseData['message'] = "编号：".$id."  ".$name." 已在劳动,请不要勾选";
    echo json_encode($responseData); 
    exit;
  }

}

//将记录插入工作记录表中
for($i=0;$i<count($v);$i++){
  $cel = "insert into work_history (FID,FName,FWorkStart,FWorkEnd,FReason,FOperate) values('$v[$i]','$n[$i]','$time2','未结束劳动','无请假','$o');";
  $rip = mysqli_query($conn,$cel);
}

//插入数据库开始时间
for($i=0;$i<count($v);$i++){
  $sql = "UPDATE prisoner SET FWorkStart = '$time' where FID = '$v[$i]';";
  $res = mysqli_query($conn,$sql);
  $responseData['code'] = 3;
  $responseData['message'] = "所选人员开始劳动";

}
$responseData['count'] = $i;
$responseData['data'] = $arr;
echo json_encode($responseData);

mysqli_close($conn);

?>
