<?php
    if(is_file('inc/360webscan.php')){
        require_once('inc/360webscan.php');
    }
    session_start();
    if($_FILES["file"]["error"])
    {
        echo $_FILES["file"]["error"];    
    } else {
        if (($_FILES["file"]["type"] == "image/jpeg")
        && ($_FILES["file"]["size"] < 20000)){
                move_uploaded_file($_FILES["file"]["tmp_name"],"./stupic/".$_SESSION['id'].".jpg");
                header('location:index.php?id='.$_SESSION['laboratoryid']);    
        } else {
            header('location:changepic.php?err=1');
        }
    }
?>