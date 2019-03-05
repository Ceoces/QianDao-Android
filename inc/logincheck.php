<?php 
	include_once('mysql.class.php');
	function Error($i){
		if($i==1){ //不处于登陆状态跳转到登陆页面
			header("locaton:login.php?id=".$_GET['id']);
		}
	}
	session_start();
	if(!isset($_SESSION['laboratoryid']))$_SESSION['laboratoryid']=$_GET['id'];
	$isLogin=0;
	if(!isset($mustlogin))$mustlogin=1;
	if(isset($_SESSION['id'])&&isset($_SESSION['pwd'])&&$_SESSION['id']!=""&&$_SESSION['pwd']!=""){
		$debug=$_SESSION['id'];
		if(!isset($db)){
			$db=new Mysql();
			$db->connect($dbhost,$dbuser,$dbpassword,$dbname);
		}
		$sql="select password from v_student where id=".$_SESSION['id']." and laboratoryid=".$_SESSION['laboratoryid'];
		$row=$db->findAll($sql);
		if(count($row)!=0){
			if($row[0]['password']!=$_SESSION['pwd']){
				Error($mustlogin);
			}else {
				$isLogin=1;
			}
		} else {
			Error($mustlogin);
		}
	} else {
		Error($mustlogin);
	}
?>