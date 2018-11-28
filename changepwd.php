<?php
	if(is_file('inc/360webscan.php')){
		require_once('inc/360webscan.php');
	}
	include_once('/inc/logincheck.php');
	$sql="select * from t_student where id=".$_SESSION['id'];
	$userinfo=$db->findAll($sql);
	if(count($userinfo)==0){
		header("location:login.php");
	}
	$msg=array("","密码输入错误","两次新密码不一致","密码长度需要超过六位","修改失败");
	$err=0;
	if(isset($_POST['oldpwd'])&&isset($_POST['newpwd1'])&&isset($_POST['newpwd2'])){
		if(sha1($_POST['oldpwd'])==$userinfo[0]['password']){
			if($_POST['newpwd1']==$_POST['newpwd2']){
				if(strlen($_POST['newpwd1'])>=6){
					$data = array('password' => sha1($_POST['newpwd1']) );
					$sql="id=".$_SESSION['id'];
					if($db->update("t_student",$data,$sql)){
						header('location:login.php?id='.$_SESSION['laboratoryid']);
					} else {
						$err=4;
					}
				} else {
					$err=3;
				}
			} else {
				$err=2;
			}
		} else {
			$err=1;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>个人页面</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
		<div class="row">
			<center><h3>个人信息</h3></center>
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
			<form action="changepwd.php" method="post" class="bs-example bs-example-form" role="form">
		        <div class="input-group input-group-lg">
		            <span class="input-group-addon">旧密码</span>
		            <input name="oldpwd" type="password" class="form-control">
		        </div>
		        <br>
		        <div class="input-group input-group-lg">
		            <span class="input-group-addon">新密码</span>
		            <input name="newpwd1" type="password" class="form-control">
		        </div>
		        <br>
		        <div class="input-group input-group-lg">
		            <span class="input-group-addon">新密码</span>
		            <input name="newpwd2" type="password" class="form-control">
		        </div>
		        <br>
		        <center>
			        <div class="input-group input-group-lg">
			            <input type="submit" class="form-control" value="修改">
			        </div>
		        </center>
		    </form>
		</div>
	</div>
</body>
</html>