<?php
  require_once('logincheck.php');
  include_once('mysql.class.php');
  $db=new Mysql();
  if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
  {
    echo "数据库连接错误";
    die;
  }
  //添加学生
    if(!isset($_GET['id']))
    {
      header("location:laboratorytable.php");
    }
    if(isset($_POST['name'])&&$_POST['name']!=""&&isset($_POST['teacher'])&&$_POST['teacher']!=""&&isset($_POST['maxnum'])&&$_POST['maxnum']!="")
      {
        $data=array(
          "name"=>$_POST['name'],
          "teacherid"=>$_POST['teacher'],
          "maxnum"=>$_POST['maxnum'],
          "info"=>$_POST['info']
        );
        if($db->update("t_laboratory",$data,"id=".$_GET['id']))
        {
          header("location:laboratoryinfo.php?id=".$_GET['id']);
        }
      }
  $sql1="select * from t_teacher";
  $row1=$db->findAll($sql1);
  $sql2="select * from t_laboratory where id=".$_GET['id'];
  $row2=$db->findAll($sql2);
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
      <h2><i class="fa fa-home"></i> 添加实验室 </h2>
      <div class="breadcrumb-wrapper">
        <span class="label">位置：</span>
        <ol class="breadcrumb">
          <li><a href="index.php">主页</a></li>
          <li>实验室管理</li>
          <li class="active">添加实验室</li>
        </ol>
      </div>
    </div>
    <div class="contentpanel">
      
      <div class="panel panel-default">
        <div class="panel-heading">

          <div class="panel-btns">
            <a href="laboratorytable.php"><button class="btn btn-primary" style="float: right;">查看实验室</button></a>
          </div>
          <h3 class="panel-title">添加实验室</h4>
        </div>
        <div class="panel-body panel-body-nopadding">
          
          <form id="form" class="form-horizontal form-bordered" method="post" action="changelaboratory.php?id=<?php echo $_GET['id']; ?>">
            
            <div class="form-group">
              <label class="col-sm-3 control-label">实验室</label>
              <div class="col-sm-6">
                <input type="text" placeholder="实验室" class="form-control" name="name" value="<?php echo $row2[0]['name']; ?>" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">人数上限</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="maxnum" value="<?php echo $row2[0]['maxnum']; ?>" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">教师</label>
              <div class="col-sm-6">
                <input list="bj1" placeholder="教师" class="form-control" name="teacher" value="<?php echo $row2[0]['teacherid']; ?>" />
                <datalist id="bj1">
                      <?php 
                        if (is_root) {
                          for($i=0;$i<count($row1);$i++){
                            echo "<option value='".$row1[$i]['id']."'>".$row1[$i]['name']."</option>";
                          }
                        } else{
                          echo "<option value='".$id."'>".$name."</option>";
                        }
                     ?>
                </datalist> 
                
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">介绍</label>
              <div class="col-sm-6">
                <textarea class="form-control" rows="5" name="info" value="<?php echo $row2[0]['info']; ?>"></textarea>
              </div>
            </div>

            <div class="form-group">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-4">
                <button class="btn btn-primary btn-lg">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
