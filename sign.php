<?php 
	include_once('inc/mysql.class.php');

  if(isset($_GET['id'])){
  	$laboratoryid=mysql_escape_string($_GET['id']);
  } else {
  	die;
  }

	$db=new Mysql();
	
	$msg=array("","学号或密码错误","签到失败","连接失败");
	$err=0;
	if($db->connect($dbhost,$dbuser,$dbpassword,$dbname)){
		$err=3;
	} else {
		if(isset($_POST['id'])&&$_POST['id']!=""&&isset($_POST['password'])&&$_POST['password']!=""){
			//字符串过滤
			$id=mysql_escape_string($_POST['id']);
			$pwd=$_POST['password'];
			$sql="select password,intime from v_student where id='".$id."' and laboratoryid=".$laboratoryid;
			$stu_row=$db->findAll($sql);

			//判断登陆状态
			if(count($stu_row)==0||$stu_row[0]['password']!=sha1($pwd)){
				$err=1;
			} else {
				$sql="select * from t_signtable where stuid='".$id."' and laboratoryid=".$laboratoryid." and static=1 and to_days(intime) = to_days(now()) order by intime desc";
				$row=$db->findAll($sql);
				//判断是否进入实验室
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
					//在更新学生的累计时间
					$time=$str_row[0]['intime']+(strtotime('now')-strtotime($row[0]['intime']));
					$data = array('intime'=>$time);
					$db->update("t_student",$data,"id=".$id);
				}
			}
			if($err==0){
				header('location:index.php?id='.$laboratoryid);
			}
		}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>签到</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
	  <form action="sign.php?id=<?php echo $laboratoryid; ?>" method="post">
	    <div class="row">
	      <h2 style="text-align:center">登陆</h2>
	      <div class="mb20"></div>
	      <div class="alert alert-warning alert-dismisable" role="alert" style="display: <?php 
	      	if(!$err) {
	      		echo "none";
	      	} else { 
	      		echo "block";
	      	}
	      ?>;">
	      	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	      	<span aria-hidden="true">&times;</span></button>
	      	<strong><?php echo $msg[$err]; ?></strong>
	      </div>
	        <div class="form-group ">
				<input class="form-control" name="id" placeholder="请输入学号">
			</div>
			<div class="form-group ">
				<input class="form-control" type="password" name="password" placeholder="请输入密码">
			</div>
			<div class="form-group ">
	        	<input class="form-control" type="submit" value="签到">
	        </div>
	    </div>
	  </form>
	</div>
</body>
</html>