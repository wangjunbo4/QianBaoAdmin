<div class="headerbar">
      
      <a class="menutoggle"><i class="fa fa-bars"></i></a>
       <form class="searchform" action="http://themepixels.com/demo/webpage/bracket/index.html" method="post">
        <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
      </form>
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <img src="images/photos/loggeduser.png" alt="" />
                <?php
                  include_once('mysql.class.php');
                  $db=new Mysql();
                  $sql="select name from t_teacher where id='".$_SESSION['id']."'";
                  if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
                  {
                    echo "数据库连接错误";
                    die;
                  }
                  $res_tname=$db->findAll($sql);
                  echo $res_tname[0]['name'];
                 ?>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                <li><a href="changepw.php"><i class="glyphicon glyphicon-cog"></i> 修改密码</a></li>
                <li><a href="login.php"><i class="glyphicon glyphicon-log-out"></i> 退出登录</a></li>
              </ul> 
            </div>
          </li>
        </ul>
      </div><!-- header-right -->
    </div><!-- header-bar -->