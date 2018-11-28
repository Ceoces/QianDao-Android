<?php
	include_once('inc/mysql.class.php');
	if(is_file('360webscan.php')){
		require_once('360webscan.php');
	}
	include_once('inc/logincheck.php');
	if(isset($_SESSION['id'])&&$_SESSION['id']!=""){
		$db=new Mysql();
		$db->connect($dbhost,$dbuser,$dbpassword,$dbname);
		$sql="select * from t_student where id=".$_SESSION['id'];
		$row=$db->findAll($sql);
		if(count($row)==0){
			header('location:login.php');
		}
	} else {
		header('location:login.php');
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
			<ul class="list-group">
				<a class="list-group-item active">
					<h4 class="list-group-item-heading">
						<?php echo $row[0]["name"]; ?>
					</h4>
				</a>
				<a href="userinfo.php" class="list-group-item">
					<h4 class="list-group-item-heading">
						修改信息
					</h4>
				</a>
				<a href="changepic.php" class="list-group-item">
					<h4 class="list-group-item-heading">
						更换头像
					</h4>
				</a>
				<a href="changepwd.php" class="list-group-item">
					<h4 class="list-group-item-heading">
						修改密码
					</h4>
				</a>
				<a href="login.php" class="list-group-item">
					<h4 class="list-group-item-heading">
						退出登录
					</h4>
				</a>
			</ul>
		</div>
	</div>
</body>
</html>