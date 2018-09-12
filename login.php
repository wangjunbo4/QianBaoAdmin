
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>实验室签报系统后台</title>

  <link href="css/style.default.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="signin">
  <?php
  session_start();
  $_SESSION['id']='';
  $_SESSION['pwd']='';
  if(isset($_POST['id'])&&isset($_POST['pwd'])&&isset($_POST['captcha']))
  {
   if(strtolower($_SESSION["captcha"]) != strtolower($_POST['captcha'])){
		$_SESSION['id']="";
      		$_SESSION['pwd']="";
		header('location:login.php?error=2');
	}
   else{
    require_once('mysql.class.php');
    $db=new Mysql();
    $sql="select password from t_teacher where id='".$_POST['id']."'";

    if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
    {
      echo "数据库连接错误";
      die;
    }
    $row=$db->findAll($sql);
    if($row[0]['password']==sha1($_POST['pwd']))
    {
      $_SESSION['id']=$_POST['id'];
      $_SESSION['pwd']=sha1($_POST['pwd']);
      header('location:index.php');
    }
    else
    {
      header('location:login.php?error=1');
      $_SESSION['id']="";
      $_SESSION['pwd']="";
     }
    }
  }   
?>

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
    <div class="signinpanel">
        <div class="row">
            <div class="col-md-7">
                
                <div class="signin-info">
                    <div class="logopanel">
                        <h1><span>[</span> 实验室签报系统后台 <span>]</span></h1>
                    </div><!-- logopanel -->
                </div><!-- signin0-info -->
            
            </div><!-- col-sm-7 -->
            
            <div class="col-md-5">
                
                <form method="post" action="login.php">
                    <h4 class="nomargin">登陆</h4>
                    <input type="text" name="id" class="form-control uname" placeholder="用户名" />
		    <input type="password" name="pwd" class="form-control pword" placeholder="密码" />
		    <input type="text" name="captcha" class="form-control uname" placeholder="验证码"><br/>
		    <img src="code.php"  onclick="this.src='code.php?'+new Date().getTime();" width="125" height="30"><br/>
		<?php
                    if(isset($_GET['error']))
		    {
		      if($_GET['error']==1)
			      echo "<h5 class='text-danger'>账号或密码错误</h2>";
		      else
			       echo "<h5 class='text-danger'>验证码错误</h2>";                    }
                    ?>
                    <button class="btn btn-success btn-block">登陆</button>
                </form>
            </div><!-- col-sm-5 -->
            
        </div><!-- row -->
        
        <div class="signup-footer">
        </div>
        
    </div><!-- signin -->
  
</section>


<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/retina.min.js"></script>

<script src="js/custom.js"></script>

</body>
</html>
