<?php 
  require_once('logincheck.php'); 
  //require_once('rootcheck.php');
  header("Content-Type: text/html; charset=utf-8");
  include_once('mysql.class.php');
  $db=new Mysql();
 
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
      <h2><i class="fa fa-home"></i> 查看教师信息 </h2>
      <div class="breadcrumb-wrapper">
        <span class="label">位置：</span>
        <ol class="breadcrumb">
          <li><a href="index.html">主页</a></li>
          <li>教师信息管理</li>
          <li class="active">查看教师信息</li>
        </ol>
      </div>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">
              <a href="addteacher.php"><button class="btn btn-primary" style="float: right;">添加教师信息</button></a>
            </div>
            <h4 class="panel-title">查看教师信息</h4>
        </div><!-- panel-heading -->
        <div class="panel-body">
          <div class="table-responsive">
          <table class="table" id="table2">
              <thead>
                 <tr>
                  <th>教工号</th>
                    <th>姓名</th>
                    <th>权限</th>
                    <th>电话</th>
                    <th>邮箱</th>
                    <th></th>
                 </tr>
              </thead>
              <tbody>
                 <?php  
                       $sql="select * from t_teacher";
                       if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
                       {
                         echo "数据库连接错误";
                         die;
                       }
                       $row=$db->findAll($sql);
                      for ($i=0; $i < count($row); $i++) 
                      { 
                        echo "<tr class='odd gradeX'>";
                        echo "<td>".$row[$i]['id']."</td>";
                        echo "<td><a href='teacherinfo.php?id=" .$row[$i]['id']."'>".$row[$i]['name']."</a></td>";
                        if ($row[$i]['static']=='1') {
                          echo "<td><p class='text-danger'>超级管理员</p></td>";
                        }else{
                          echo "<td>管理员</td>";
                        }
                        echo "<td>".$row[$i]['phone']."</td>";
                        echo "<td>".$row[$i]['email']."</td>";
                        if (is_root)
                        {
                             echo "<td><a href='changeteacher.php?id=".$row[$i]['id']."'><button class='btn btn-warning btn-sm'>修改</button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='delete.php?obj=teacher&id=".$row[$i]['id']."'><button class='btn btn-danger btn-sm'>删除</button></a></td>";
                        }
                       else
                        {
                            echo "<td><button class='btn btn-warning btn-sm' onclick=\"IsNot_root()\")\">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;"."<button class='btn btn-danger btn-sm'  onclick=\"IsNot_root()\")\">删除</button></a></td>";
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
  
  function IsNot_root()
{
    alert("仅超级管理员可执行此操作！")
}
  
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
