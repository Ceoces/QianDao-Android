<?php


  	include_once('inc/mysql.class.php');
  	if(is_file('360webscan.php')){
		require_once('360webscan.php');
	}
	  $db=new Mysql();
	  if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
	  {
	    echo "数据库连接失败";
	    die;
	  }
		$mustlogin=0;
		include_once('inc/logincheck.php');
	  if(isset($_GET['id'])){
	  	$laboratoryid=mysql_escape_string($_GET['id']);
	  	$sql="select name,info from t_laboratory where id=".$laboratoryid;
	  	$laboratoryinfo=$db->findAll($sql);
	  	if (count($laboratoryinfo)==0) {
	  		die;
	  	}
	  } else {
	  	die;
	  }
	  if(isset($isLogin)&&$isLogin==1){
	  	$sql="select * from v_student where id=".$_SESSION['stuid']." and laboratoryid=".$laboratoryid;
	  	$stuinfo=$db->findAll($sql);
	  }
?>


<!DOCTYPE HTML>
<html><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<title>开放实验室签报系统</title>
		<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
		 <!-- Custom Theme files -->
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
		<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
		 <!-- Custom Theme files -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		</script>
		<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
		 <!---- start-smoth-scrolling---->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
		<style type="text/css">
			#userinfo{
				text-decoration: none;
				out-line: none;
				color: #FFFAFA;
			}
	</style>
	</head>
	<body>
		<!-- start-header-->
			<div id="home" class="header">
					<div class="top-header">
						<div class="container">
							<div class="logo">
								<h3 style="color: #4BCAFD;" class="subheader">开放实验室签报系统</h3>
							</div>
							 <nav class="top-nav">
								<ul class="top-nav">
									<li class="active"><a href="#home" class="scroll">签到</a></li>
									<li><a href="#people" class="scroll">当前人员</a></li>
									<li><a href="#video" class="scroll">实验室简介</a></li>
									<li><a href="#testimonial" class="scroll">教师简介</a></li>
									<li><a href="#object" class="scroll">项目简介</a></li>
								</ul>
							</nav>
							<div class="clearfix"> </div>
					</div>
				</div>
			    <div  id="top" class="callbacks_container">
			      <ul class="rslides" id="slider4">
			        <li>
			        	<center class="row align-items-center">
			        		<a id="userinfo" href=<?php
			        			if($isLogin==1){
			        				echo "user.php"; 
			        			} else{
			        		 		echo "'login.php?id=".$_GET['id']."' "; 
			        		 	}
			        		 ?>>
			          			<img src=<?php
			        			if($isLogin==1){
			        				if(is_file( "./stupic/".$_SESSION['stuid'].".jpg")){
			        					echo "'./stupic/".$_SESSION['stuid'].".jpg'"; 
			        				} else {
			        					echo "'./images/user.png'";
			        				}
			        			} else{
			        				echo "'./images/user.png'";
			        		 	}
			        		 ?> style="border:1px; border-radius: 100%;width: 80px;height: 80px;" />
			          			<h3 style="color:#FFFAFA"><?php if($isLogin==1) echo $stuinfo[0]['stuname']; else echo "未登录"; ?></h3>
			          		</a>
			          		<a class="dow-btn" href="sign.php?id=<?php echo $laboratoryid; ?>">签到</a>
			          	</center>
			          <div class="slider-top">
						</div>
			        </li>
			      </ul>
			    </div>
		</div>

	<!--当前人员-->
		<div id="people" class="Gallery">
			<div class="container">
				<?php
					$sql = "select * from v_signtable where laboratoryid=".$laboratoryid." and static = 1 and to_days(intime) = to_days(now())";
					$row = $db->findAll($sql);
				 ?>
				<div class="gallery-head">
					<?php
					 	if(count($row)!=0) echo "<center><h3>当前人员:</h3></center>";
					 	else echo "<center><h3>实验室内没有学生</h3></center>"; 
					 ?>
				</div>
				<div class="section group">
					<?php 
						for($i=0;$i<count($row);$i++){
							if(is_file( "./stupic/".$row[$i]['stuid'].".jpg")){
			        			$url="'./stupic/".$row[$i]['stuid'].".jpg'"; 
			        		} else {
			        			$url="'./images/user.png'";
			        		}
							echo "<div class='col-xs-3'><center style='width:80px;'><img src=".$url."' width='80px' height='80px' /><h4>".$row[$i]['stuname']."</h4></center></div>";
						}
					 ?>
                </div>
		</div>
	<!-- //End-features-->

		<!--video-start-->
		 <div id="video" class="Video">
				<div class="container">
					<div class="video-head">
					<h3><?php echo $laboratoryinfo[0]['name']; ?></h3>
					<p><?php echo $laboratoryinfo[0]['info']; ?></p>
					</div>
					<!--beanner-info-->	  
				</div>
			</div>
<!--video-ends-->

<div id="testimonial" class="Testimonials">
	<div class="container">
		<!-- testmonials -->
		<h3>教师简介</h3>
			<div class="test-monials">
			<!--sreen-gallery-cursual-->
				<div class="sreen-gallery-cursual">
					<!-- requried-jsfiles-for owl -->
					<link href="css/owl.carousel.css" rel="stylesheet">
					<script src="js/owl.carousel.js"></script>
					<script>
						$(document).ready(function() {
						$("#owl-demo").owlCarousel({
						  items : 1,
						  lazyLoad : true,
						  autoPlay : true,
						  navigation : false,
						  navigationText :  false,
						  pagination : true,
						 });
						});
					</script>
					<!-- requried-jsfiles-for owl -->
					<!-- start content_slider -->
					<div id="owl-demo" class="owl-carousel">
						<?php 
							$sql="select teachername,teacherinfo from v_laboratory where id=".$laboratoryid;
							$row=$db->findAll($sql);
							echo "<div class='item'>";
							echo "    <div class='col-md-3 testmonial-img'>";
							echo "        <img src='images/slide1.png' class='img-responsive'/>";
						    echo "    </div>";
						    echo "    <div class='col-md-9 testmonial-text'>";
						    echo "        <p><strong>".$row[0]['teachername']."</strong><p>";
							echo "        <p>".$row[0]['teacherinfo']."</p>";
						    echo "    </div>";
						    echo "    <div class='clearfix'> </div>";
						    echo "</div>";
						 ?>
					</div>
				</div>
				<!--//sreen-gallery-cursual-->
			</div>
		</div>
	</div>
</div>
		<!-- testmonials -->

 <div id="object" class="pricing-plans">
					 <div class="container">
					 	<div class="price-head">
					 		<h3>项目简介</h3>
					 	</div>
						<div class="pricing-grids">

						<?php 
							$sql = "select * from v_project where laboratoryid=".$laboratoryid;
							$row=$db->findAll($sql);
							for($i=0;$i<count($row);$i++)
							{
								echo "<div class='col-md-4 pricing-grid2'>";
								echo "	<div class='price-number2'>";
								echo "		<h4>".$row[$i]['proname']."</h4>";
								echo "	</div>";
								echo "	<div class='price-bg'>";
								echo "	<ul>";
								echo "		<li><a href='#'>".$row[$i]['proinfo']."</a></li>";
								echo "	</ul>";
								echo "	<div class='cart2'>";
								echo "		<a class='popup-with-zoom-anim' href='#small-dialog'>申请加入</a>";
								echo "	</div>";
								echo "	</div>";
								echo "</div>";
							}
						 ?>
							</div>
						<div class="clearfix"> </div>
					</div>
				
				</div>
	<!----End-pricingplans---->

	<!-- /start-footer-->
	<div class="footer">
		<div class="container">
			<div class="footer-content">
			</div>	
		</div>	
		<div class="clearfix"> </div>  							
	</div>
	<!-- //End-footer-->
	<script type="text/javascript">
	$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
	});
	</script>
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
</body>
</html>