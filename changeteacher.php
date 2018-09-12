<?php
  require_once('logincheck.php');
  include_once('mysql.class.php');
  $db=new Mysql();
  if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
  {
    echo "数据库连接错误";
    die;
  }
    //修改教师
    if(isset($_POST['name'])&&isset($_POST['id'])&&isset($_POST['pwd'])&&isset($_POST['phone'])&&isset($_POST['email']))
    {
	if(!isset($_POST['static']))
		$static=0;
	else
		$static=1;
        $data=array(
          "name"=>$_POST['name'],
          "phone"=>$_POST['phone'],
          "password"=>sha1($_POST['pwd']),
	  "email"=>$_POST['email'],
	  "info"=>$_POST['info'],
	  "static"=>$static
        );
	$id = $_POST['id'];
        if(!$db->update("t_teacher",$data,"id='$id'"))
        {
          echo "修改失败！";
        }
	header("locatio:teachertable.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>实验室签报系统</title>

  <link rel="stylesheet" href="css/style.default.css" />
  
  <link rel="stylesheet" href="css/bootstrap-fileupload.min.css" />
  <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" />
  <link rel="stylesheet" href="css/jquery.tagsinput.css" />
  <link rel="stylesheet" href="css/colorpicker.css" />
  <link rel="stylesheet" href="css/dropzone.css" />
  

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  
</head>

<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
<?php require_once('leftpanel.php');
if(isset($_GET['id']) && strlen($_GET['id'])<=10)
	$id = $_GET['id'];
else
	$id = '0';
	    $sql = "select name,id,email,phone,info,static from t_teacher where id='$id'";
$row = $db->find($sql);
if($row['static']==1){
	$val="checked";
}
else
	$val="";
?>
  
  <div class="mainpanel">
    
    <?php require_once('headerright.php'); ?>
      
    <div class="pageheader">
      <h2><i class="fa fa-home"></i> 修改教师信息 </h2>
      <div class="breadcrumb-wrapper">
        <span class="label">位置：</span>
        <ol class="breadcrumb">
          <li><a href="index.html">主页</a></li>
          <li><a href="teachertable.php">教师信息管理</a></li>
          <li class="active">修改教师信息</li>
        </ol>
      </div>
    </div>
    <div class="contentpanel">
      
      <div class="panel panel-default">
        <div class="panel-heading">

          <div class="panel-btns">
            <a href="teachertable.php"><button class="btn btn-primary" style="float: right;">查看教师信息</button></a>
          </div>
          <h3 class="panel-title">修改教师信息</h4>
        </div>
        <div class="panel-body panel-body-nopadding">
          
	<form id="form" class="form-horizontal form-bordered" method="post" action="changeteacher.php?id=<?php echo $row['id']; ?>">
            
            <div class="form-group">
              <label class="col-sm-3 control-label">姓名</label>
              <div class="col-sm-6">
	      <input type="text" value="<?php echo $row["name"]; ?>" class="form-control" name="name" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">职工号</label>
	      <div class="col-sm-6">
		<input type="text" value="<?php echo $row['id'];?>" class="form-control" name="id" readonly/>
		<input type="hidden" name="id" value="<?php echo $row['id'];?>"></td>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">密码</label>
              <div class="col-sm-6">
                <input type="text" placeholder="密码" class="form-control" name="pwd" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">手机</label>
              <div class="col-sm-6">
                <input type="text" value="<?php echo $row['phone']; ?>
" class="form-control" name="phone" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">邮件</label>
              <div class="col-sm-6">
                <input type="text" value="<?php echo $row['email']; ?>
" class="form-control" name="email" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">信息</label>
              <div class="col-sm-6">
                <input type="text" value="<?php echo $row['info']; ?>" class="form-control" name="info" />
              </div>
	    </div>

            <div class="form-group">
              <div class="col-sm-6 col-sm-offset-4">
	      <div class="checkbox block"><label><input type="checkbox" name="static" value="1" <?php echo $val; ?>> &nbsp;超级管理员权限</label></div>
               </div>
            </div>

            <div class="form-group">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-4">
              	<button class="btn btn-primary btn-lg" onClick="btn_submit();">提交</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              	<button class="btn btn-default btn-lg" onClick="btn_reset();">取消</button>
              </div>
            </div>
          </div>
            
            </form>
          </div>
  
</section>


<script type="text/javascript">
  function btn_reset()
  {
    document.getElementById('form').reset();
  }
</script>



<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/toggles.min.js"></script>
<script src="js/retina.min.js"></script>
<script src="js/jquery.cookies.js"></script>

<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/bootstrap-fileupload.min.js"></script>
<script src="js/bootstrap-timepicker.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/jquery.tagsinput.min.js"></script>
<script src="js/jquery.mousewheel.js"></script>
<script src="js/chosen.jquery.min.js"></script>
<script src="js/dropzone.min.js"></script>
<script src="js/colorpicker.js"></script>


<script src="js/custom.js"></script>

<script>
jQuery(document).ready(function(){
    
  // Chosen Select
  jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});
  
  // Tags Input
  jQuery('#tags').tagsInput({width:'auto'});
   
  // Textarea Autogrow
  jQuery('#autoResizeTA').autogrow();
  
  // Color Picker
  if(jQuery('#colorpicker').length > 0) {
	 jQuery('#colorSelector').ColorPicker({
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
				jQuery('#colorpicker').val('#'+hex);
			}
	 });
  }
  
  // Color Picker Flat Mode
	jQuery('#colorpickerholder').ColorPicker({
		flat: true,
		onChange: function (hsb, hex, rgb) {
			jQuery('#colorpicker3').val('#'+hex);
		}
	});
   
  // Date Picker
  jQuery('#datepicker').datepicker();
  
  jQuery('#datepicker-inline').datepicker();
  
  jQuery('#datepicker-multiple').datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  
  // Spinner
  var spinner = jQuery('#spinner').spinner();
  spinner.spinner('value', 0);
  
  // Input Masks
  jQuery("#date").mask("99/99/9999");
  jQuery("#phone").mask("(999) 999-9999");
  jQuery("#ssn").mask("999-99-9999");
  
  // Time Picker
  jQuery('#timepicker').timepicker({defaultTIme: false});
  jQuery('#timepicker2').timepicker({showMeridian: false});
  jQuery('#timepicker3').timepicker({minuteStep: 15});

  
});
</script>


</body>
</html>

