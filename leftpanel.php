<?php
          if(isset($_SESSION['id']))
            {
              require_once('mysql.class.php');
              $db=new Mysql();
              
              $sql="select * from t_teacher where id='".$_SESSION['id']."'";
        
                
              if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
              {
                echo "数据库连接错误";
                die;
              }
              $row=$db->findAll($sql);
              $name=$row[0]['name'];
              $id=$row[0]['id'];

              if($row[0]['static']=="1")
              {
                define("is_root", 1);
              }
              else
              {
                define("is_root",0);
              }
            }
            else
            {
              header('location:login.php');
            }
        ?>
<div class="leftpanel">
    
    <div class="logopanel">
        <h1><span>[</span> 后台管理 <span>]</span></h1>
    </div><!-- logopanel -->
        
    <div class="leftpanelinner">    
      
      <h5 class="sidebartitle">菜单</h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
        <li class="active"><a href="index.php"><i class="fa fa-home"></i> <span>首页</span></a></li>
        <li><a href="signreport.php"><i class="fa fa-th-list"></i> <span>签到情况</span></a></li>
        <li><a href="#"><i class="fa fa-th-list"></i> <span>实验室预约情况</span></a></li>
        <li><a href="#"><i class="fa fa-th-list"></i> <span>实验室值日表</span></a></li>
        <li class="nav-parent"><a href="#"><i class="fa fa-edit"></i> <span>学生管理</span></a>
          <ul class="children">
            <li><a href="stutable.php"><i class="fa fa-caret-right"></i> 查看学生信息</a></li>
            <li><a href="addstu.php"><i class="fa fa-caret-right"></i> 添加学生账号</a></li>
          </ul>
        </li>
        <?php
         echo "<li class='nav-parent'><a href='#'><i class='fa fa-edit'></i> <span>教师管理</span></a><ul class='children'>";
         echo "<li><a href='teachertable.php'><i class='fa fa-caret-right'></i> 查看教师信息</a></li>";
         //echo "<li><a href='addteacher.php'><i class='fa fa-caret-right'></i> 添加教师</a></li></ul></li>";
              if(is_root)
              {
                echo "<li><a href='addteacher.php'><i class='fa fa-caret-right'></i> 添加教师</a></li></ul></li>";
              }
              else
              {
                  echo "</ul></li>";
              }
        ?>
         <li class="nav-parent"><a href="#"><i class="fa fa-edit"></i> <span>项目管理</span></a>
          <ul class="children">
            <li><a href="protable.php"><i class="fa fa-caret-right"></i> 查看项目信息</a></li>
            <li><a href="addpro.php"><i class="fa fa-caret-right"></i> 创建新项目</a></li>
          </ul>
        </li>
        <li class="nav-parent"><a href="#"><i class="fa fa-edit"></i> <span>实验室管理</span></a>
          <ul class="children">
            <li><a href="laboratorytable.php"><i class="fa fa-caret-right"></i> 查看实验室</a></li>
            <li><a href="addlaboratory.php"><i class="fa fa-caret-right"></i> 创建实验室</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->
