<?php 
	include_once('inc/mysql.class.php');
	if(is_file('inc/360webscan.php')){
		require_once('inc/360webscan.php');
	}
	include_once("inc/logincheck.php");
  if(isset($_GET['id'])){
  	$laboratoryid=mysql_escape_string($_GET['id']);
  } else {
  	die;
  }

	$err=0;
	$id=$_SESSION['id'];
	$sql="select * from t_signtable where stuid='".$id."' and laboratoryid=".$laboratoryid." and static=1 and to_days(intime) = to_days(now()) order by intime desc";
	$row=$db->findAll($sql);
	//判断是否进入实验室
	echo  count($row);
	if(count($row)==0){
		//添加一条记录
			$data = array('stuid' => $id,
					'static' => 1,
					'laboratoryid' => $laboratoryid
				);
		if (!$db->save("t_signtable", $data)) {
		    $err=2;
		}
	} else {
	//修改原纪录的状态和离开时间
		$data = array('static' => 0,'outtime' => date('Y-m-d H:i:s') );
		$sql = " stuid='".$id."' and to_days(intime) = to_days(now()) and laboratoryid=".$laboratoryid." and id=".$row[0]['id'];
		if(!$db->update("t_signtable",$data,$sql)){
			$err=2;
		}
		//更新学生的累计时间
		$time=$str_row[0]['intime']+(strtotime('now')-strtotime($row[0]['intime']));
		$data = array('intime'=>$time);
		$db->update("t_student",$data,"id=".$id);
	}
	if($err==0){
		header('location:index.php?id='.$laboratoryid);
	}
?>