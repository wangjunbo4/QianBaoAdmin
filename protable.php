<?php 
  require_once('logincheck.php'); 
  
  header("Content-Type: text/html; charset=utf-8");
  
  include_once('mysql.class.php');
  $db=new Mysql();
  $sql="select * from v_project ";
  if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
  {
    echo "数据库连接错误";
    die;
  }
  $row=$db->findAll($sql);
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

  <link href="css/style.default.css" rel="stylesheet">
  <link href="css/jquery.datatables.css" rel="stylesheet">

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
      <h2><i class="fa fa-home"></i> 查看项目信息 </h2>
      <div class="breadcrumb-wrapper">
        <span class="label">位置：</span>
        <ol class="breadcrumb">
          <li><a href="index.html">主页</a></li>
          <li>项目管理</li>
          <li class="active">查看项目信息</li>
        </ol>
      </div>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">
              <a href="addpro.php"><button class="btn btn-primary" style="float: right;">添加项目信息</button></a>
            </div>
            <h4 class="panel-title">查看项目信息</h4>
        </div><!-- panel-heading -->
        <div class="panel-body">
          <div class="table-responsive">
          <table class="table" id="table2">
              <thead>
                 <tr>
                    <th>项目名称</th>
                    <th>指导教师</th>
                    <th>地点</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th></th>
                 </tr>
              </thead>
              <tbody>
                 <?php  
                  $sql="select * from v_project ";
                  if(is_root==0){
                    $sql="select * from v_project where teacherid='".$_SESSION['id']."'";
                  }
                  if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
                  {
                    echo "数据库连接错误";
                    die;
                  }
                  $row=$db->findAll($sql);
                      for ($i=0; $i < count($row); $i++) 
                      { 
                        echo "<tr class='odd gradeX'>";
                        echo "<td><a href='proinfo.php?id=" .$row[$i]['proid']."'>".$row[$i]['proname']."</a></td>";
                        echo "<td>".$row[$i]['teachername']."</td>";
                        echo "<td><a href='laboratoryinfo.php?id=".$row[$i]['laboratoryid']."'>".$row[$i]['laboratoryname']."</a></td>";
                        echo "<td>".$row[$i]['startTime']."</td>";
                        echo "<td>".$row[$i]['endTime']."</td>";
                        if (Teacher_Admin($row[$i]['teacherid'], $_SESSION['id']))
                        {
                            echo "<td><a href='changepro.php?id=".$row[$i]['proid']."'><button class='btn btn-warning btn-sm'>修改</button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='delete.php?obj=project&id=".$row[$i]['proid']."'><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal'>删除</button></a></td>";
                        }
                        else {
                            echo "<td><button class='btn btn-warning btn-sm' onclick=\"IsNot_root()\")\">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-danger btn-sm' onclick=\"IsNot_root()\")\">删除</button></td>";
                        }
                        
                        echo "</tr>";
                      }
                 ?>
              </tbody>
           </table>
          </div><!-- table-responsive -->
          
        </div><!-- panel-body -->
      </div><!-- panel -->
        
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->
  
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        确定删除这条记录么？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <a><button type="button" class="btn btn-primary">删除</button></a>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/toggles.min.js"></script>
<script src="js/retina.min.js"></script>
<script src="js/jquery.cookies.js"></script>

<script src="js/jquery.datatables.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>

<script src="js/custom.js"></script>
<script>


  jQuery(document).ready(function() {
    
    jQuery('#table1').dataTable();
    
    jQuery('#table2').dataTable({
      "sPaginationType": "full_numbers"
    });
    
    // Chosen Select
    jQuery("select").chosen({
      'min-width': '100px',
      'white-space': 'nowrap',
      disable_search_threshold: 10
    });
    
    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var c = confirm("Continue delete?");
      if(c)
        jQuery(this).closest('tr').fadeOut(function(){
          jQuery(this).remove();
        });
        
        return false;
    });
    
    // Show aciton upon row hover
    jQuery('.table-hidaction tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });
  
  
  });
</script>

</body>
</html>
