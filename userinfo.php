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
	$msg=array("","有选项未填写","修改失败");
	$err=0;
	if(isset($_POST['name'])&&isset($_POST['class'])&&isset($_POST['info'])){
		if($_POST['name']!=""&&$_POST['class']!=""&&$_POST['info']!=""){
			$data = array('name' => $_POST['name'],
				'class' => $_POST['class'],
				'info' => $_POST['info']
			 );
			$sql="id=".$_SESSION['id'];
			if($db->update("t_student",$data,$sql)){
				header('location:user.php');
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
			<form method="post" action="userinfo.php" class="bs-example bs-example-form" role="form">
		        <div class="input-group input-group-lg">
		            <span class="input-group-addon">姓名</span>
		            <input type="text" name="name" class="form-control" value=<?php echo "'".$userinfo[0]['name']."'" ?>>
		        </div>
		        <br>
		        <div class="input-group input-group-lg">
		            <span class="input-group-addon">班级</span>
		            <input type="text" name="class" class="form-control" value=<?php echo "'".$userinfo[0]['class']."'" ?>>
		        </div>
		        <br>
		        <div class="form-group">
				    <label for="name">自我介绍</label>
				    <textarea class="form-control" name="info" rows="3"><?php echo $userinfo[0]['info']; ?></textarea>
				</div>
				<center>
					<div class="input-group input-group-lg">
			            <input type="submit" class="form-control" value="提交">
			        </div>
		    	</center>
		    </form>
		</div>
	</div>
</body>
</html>