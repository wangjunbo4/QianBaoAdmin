<?php
require_once('logincheck.php');
include_once('mysql.class.php');
$db = new Mysql();
if ($db->connect($dbhost, $dbuser, $dbpassword, $dbname)) {
  echo "数据库连接错误";
  die;
}
  //添加学生
if (isset($_POST['name']) && isset($_POST['class']) && isset($_POST['teacher']) && isset($_POST['id']) && isset($_POST['phone'])) {
  $data = array(
    "name" => $_POST['name'],
    "class" => $_POST['class'],
    "teacherid" => $_POST['teacher'],
    "projectid" => $_POST['project'],
    "id" => $_POST['id'],
    "password" => sha1($_POST['id']),
    "laboratoryid" => $_POST['laboratory']
  );

  if (!$db->save("t_student", $data)) {
    echo "插入数据失败";
  }

  if (isset($_POST['project'])) {
    $data = $arrayName = array(
      'studentid' => $_POST['id'],
      'proid' => $_POST['project']
    );
    if (!$db->save("t_stu_pro", $data)) {
      echo "插入数据失败";
    }
  }

  if (!isset($_POST['laboratory'])) {
    $data = $arrayName = array(
      'studentid' => $_POST['id'],
      'laboratoryid' => $_POST['laboratory']
    );
    if ($db->save("t_stu_laboratory", $data)) {
      echo "插入数据失败";
    }
  }
  header("location:stutable.php");
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
  
  <?php require_once('leftpanel.php'); ?>
  
  <div class="mainpanel">
    
    <?php require_once('headerright.php'); ?>
      
    <div class="pageheader">
      <h2><i class="fa fa-home"></i> 添加学生信息 </h2>
      <div class="breadcrumb-wrapper">
        <span class="label">位置：</span>
        <ol class="breadcrumb">
          <li><a href="index.html">主页</a></li>
          <li><a href="general-forms.html">学生信息管理</a></li>
          <li class="active">添加学生信息</li>
        </ol>
      </div>
    </div>
    <div class="contentpanel">
      
      <div class="panel panel-default">
        <div class="panel-heading">

          <div class="panel-btns">
            <a href="stutable.php"><button class="btn btn-primary" style="float: right;">查看学生信息</button></a>
          </div>
          <h3 class="panel-title">添加学生信息</h4>
        </div>
        <div class="panel-body panel-body-nopadding">
          
          <form id="form" class="form-horizontal form-bordered" method="post" action="addstu.php">
            
            <div class="form-group">
              <label class="col-sm-3 control-label">姓名</label>
              <div class="col-sm-6">
                <input type="text" placeholder="姓名" class="form-control" name="name" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">学号</label>
              <div class="col-sm-6">
                <input type="text" placeholder="学号" class="form-control" name="id" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">班级</label>
              <div class="col-sm-6">
                <input type="text" placeholder="班级" class="form-control" name="class" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">手机</label>
              <div class="col-sm-6">
                <input type="text" placeholder="手机号" class="form-control" name="phone" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">教师</label>
              <div class="col-sm-6">
                <input list="bj1" placeholder="教师" class="form-control" name="teacher" />
                <datalist id="bj1">
                    <?php 
                    if (is_root) {
                      $sql = "select * from t_teacher";
                    } else {
                      $sql = "select * from t_teacher where id='" . $_SESSION['id'] . "'";
                    }
                    $row = $db->findAll($sql);
                    for ($i = 0; $i < count($row); $i++) {
                      echo "<option value='" . $row[$i]['id'] . "'>" . $row[$i]['name'] . "</option>";
                    }
                    ?>
                </datalist> 
                
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">实验室</label>
              <div class="col-sm-6">
                <input list="bj2" placeholder="实验室" class="form-control" name="laboratory" />
                <datalist id="bj2">
                    <?php 
                    if (is_root) {
                      $sql = "select * from t_laboratory";
                    } else {
                      $sql = "select * from t_laboratory where teacherid='" . $_SESSION['id'] . "'";
                    }
                    $row = $db->findAll($sql);
                    for ($i = 0; $i < count($row); $i++) {
                      echo "<option value='" . $row[$i]['id'] . "'>" . $row[$i]['name'] . "</option>";
                    }
                    ?>
                </datalist> 
                
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">项目</label>
              <div class="col-sm-6">
                <input list="bj3" class="form-control" placeholder="项目" name="project" />
                <datalist id="bj3">
                    <?php 
                    if (is_root) {
                      $sql = "select * from t_project";
                    } else {
                      $sql = "select * from t_project where teacherid='" . $_SESSION['id'] . "'";
                    }
                    $row = $db->findAll($sql);
                    for ($i = 0; $i < count($row); $i++) {
                      echo "<option value='" . $row[$i]['id'] . "'>" . $row[$i]['name'] . "</option>";
                    }
                    ?>
                </datalist> 
              </div>
            </div>
            
            <div class="form-group">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-4">
              	<button class="btn btn-primary btn-lg" onclick="btn_submit();">提交</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              	<button class="btn btn-default btn-lg" onclick="btn_reset();">取消</button>
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
