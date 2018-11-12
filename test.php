<html>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <TITLE> New Document </TITLE>
    <META NAME="Generator" CONTENT="EditPlus">
    <META NAME="Author" CONTENT="milk">
    <style type="text/css">
        body{
            font-family: 幼圆;
        }
        #login{
            position: relative;
            display: none;
            top: 20px;
            left: 30px;
            width: 280px;
            height: 300px;
            background-color: #ffffff;
            text-align: center;
            border: solid 1px;
            padding: 10px;
            z-index: 1;
        }
        #panel{
            background-color: #CCFFFF;
            padding: 10px;
            margin: 10px;
        }
    </style>
    <script type="text/javascript">
        function showLogin()
        {
            login.style.display = "block";
        }
        function showForbid()
        {
            forbid.style.width = document.body.clientWidth;
            forbid.style.height = document.body.clientHeight;
            forbid.style.visibility = "visible";
        }
    </script>
</HEAD>
<body>
<div id="forbid" style="position: absolute; visibility: hidden; z-index: 0; top: 0px; left: 0px;
background-color: #CCCCCC;"></div>
<a href="javascript:showLogin();showForbid();void(0);">点击登录</a>
<div id="login">
    <span>登录</span>
    <div id="panel">
        <lable>昵 称：</lable><input type="text" size="20" /><br /><br />
        <lable>密 码：</lable><input type="password" size="20"><br /><br />
        <input type="checkbox" /><lable>记住我</lable>
    </div>
    <input type="button" value="登录" />
    <br />
    <br />
    <a href="javascript:login.style.display = 'none';forbid.style.visibility = 'hidden'; void(0);">关闭</a>
</div>
</body>
</html>