<?php 
	include_once('inc/mysql.class.php');
	if(is_file('360webscan.php')){
		require_once('360webscan.php');
	}

	session_start();
 	$_SESSION['id']='';
 	$_SESSION['pwd']='';

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
			$err=1;
			$pwd=$_POST['password'];
			$sql="select password,intime from v_student where id='".$_POST['id']."' and laboratoryid=".$laboratoryid;
			$stu_row=$db->findAll($sql);

			//判断登陆状态
			if(count($stu_row)!=0&&$stu_row[0]['password']==sha1($pwd)){
				$err=0;
			}
			if($err==0){
				$_SESSION['laboratoryid']=$laboratoryid;
				$_SESSION['id']=$_POST['id'];
				$_SESSION['pwd']=sha1($pwd);
				header('location:index.php?id='.$laboratoryid);
			}
		}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>登陆</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
	  <form action="login.php?id=<?php echo $laboratoryid; ?>" method="post">
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
	        	<input class="form-control" type="submit" value="登陆">
	        </div>
	    </div>
	  </form>
	</div>
</body>
</html>