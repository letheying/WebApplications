<?php 
  //Written by: Yutong Gao
  //Assisted by: Ying Liu
  //Debugged by: Qike Ying
 ?>




<?php ob_start(); ?>
<?php include 'includes/header_for_admin.php';?>

<?php $db = new Database(); ?>
<?php $email = $_GET['id'];?>
<?php

  //Create Query
    $query = "SELECT * FROM userinformation WHERE email = '$email';";
    //Run Query
    $userinformation = $db->select($query)->fetch_assoc();

    $username = $userinformation['username'];
?>


 <?php if(isset($_POST['submit'])) : ?>
    <?php $stockname = mysqli_real_escape_string($db->link, $_POST['stockname']);
          $startyear = mysqli_real_escape_string($db->link, $_POST['startyear']);
          $startmonth = mysqli_real_escape_string($db->link, $_POST['startmonth']);
          $startday = mysqli_real_escape_string($db->link, $_POST['startday']);
          $endyear = mysqli_real_escape_string($db->link, $_POST['endyear']);
          $endmonth = mysqli_real_escape_string($db->link, $_POST['endmonth']);
          $endday = mysqli_real_escape_string($db->link, $_POST['endday']);
          $startmonth = $startmonth-1;
          $endmonth = $endmonth-1;
      ?>

      <?php if ($stockname == '' || $startyear == '' || $startmonth == '' || $startday == '' || $endyear == '' || $endmonth == '' || $endday == ''): ?>
        <?php $error = 'Please fill out all required fields'; ?>
      <?php else : ?>
        <?php 

          $url = "http://chart.finance.yahoo.com/table.csv?s=$stockname&a=$startmonth&b=$startday&c=$startyear&d=$endmonth&e=$endday&f=$endyear&g=d&ignore=.csv";

          $data = file_get_contents("$url");

          $row = explode("\n",$data);
          $row_number = count($row);

          for($x = 0;$x<$row_number-2;$x++){
            $day[$x] = explode(",", $row[$x+1]);
              $date = $day[$x][0];
              $open = $day[$x][1];
              $high = $day[$x][2];
              $low = $day[$x][3];
              $close = $day[$x][4];
              $volume = $day[$x][5];
              $query = "SELECT * FROM historydata 
                        WHERE stockname = '$stockname' AND date = '$date'";
              $record = $db->select($query);
              if(!$record){
                $query = "INSERT INTO historydata (date,open,high,low,close,volume,stockname)
                        VALUES ('$date','$open','$high','$low','$close','$volume','$stockname')";
                $insert_row = $db->insert($query);
              }
          }
          header("Location: admin.php?id=$email&msg=".urlencode('Record Added'));
          exit();
        ?>
      <?php endif ?>
<?php endif ?>
      


<?php if(isset($_POST['delete'])) : ?>
      <?php $deletestockname = mysqli_real_escape_string($db->link, $_POST['deletestockname']); ?>
      <?php if ($deletestockname == '') : ?>
        <?php $error2 = 'Please fill out stock name'; ?>
      <?php else : ?>
        <?php
        $query = "DELETE FROM historydata WHERE stockname = '$deletestockname';";
        $delete_row = $db->delete($query); ?>
        <?php header("Location: admin.php?id=$email&msg=".urlencode('Record Deleted'));
          exit();?>
      <?php endif ?>
<?php endif ?>


<body>
    <div class="navbar-wrapper">
      <div class="container">
       <div ng-app="app" ng-controller="myCtrl">
        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php?id=<?php echo $email;?>">StockPrediction</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="index.php?id=<?php echo $email;?>">Home</a></li>
                <li><a href="setting.php?id=<?php echo $email;?>">Join us</a></li>
                <li><a href="profile.php?id=<?php echo $email;?>">Profile</a></li>
                <li  class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="help.php?id=<?php echo $email;?>">Contact us</a></li>
                    <li><a href="report.php?id=<?php echo $email;?>">Reports</a></li>
                    
                  </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                  <li class="account signup">
                        <a type="button" class="btn btn-link-2" data-toggle="modal" data-target="#SignInModal" href="profile.php?id=<?php echo $email;?>"><?php echo $username;?></a>
                  </li>
                  <li class="account signin">
                        <a type="button" class="btn btn-link-2" href="signin.php">Log Out</a>
                  </li>
              </ul>                  
            </div>
          </div>
        </nav>
      </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="row">
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Admin</h1>
          <h1><?php echo $record;?></h1>
          <div class="col-md-5">
              <h2 class="page-header">Add</h2>
              <form role="form" method="post" action="admin.php?id=<?php echo $email;?>">
                  <label>Stock Name</label>
                  <input name="stockname" type="text" class="form-control" placeholder="Enter Stock">
                  <label>Start Date</label>
                  <div class="row">
                  <div class="col-md-4"> <input name="startyear" class="form-control" placeholder="Year"/> </div>
                  <div class="col-md-4"> <input name="startmonth" class="form-control" placeholder="Month"/> </div>
                  <div class="col-md-4"> <input name="startday" class="form-control" placeholder="Day"/> </div>
                  </div>
                  <label>End Date</label>
                  <div class="row">
                  <div class="col-md-4"> <input name="endyear" class="form-control" placeholder="Year"/> </div>
                  <div class="col-md-4"> <input name="endmonth" class="form-control" placeholder="Month"/> </div>
                  <div class="col-md-4"> <input name="endday" class="form-control" placeholder="Day"/> </div>
                  </div>
                  <br>
                  <?php echo $error;?>
                  <input name="submit" type="submit" class="btn btn-info" value="Add" />
              </form>         
            </div>

            <div class="col-md-5">
              <h2 class="page-header">Delete</h2>
              <form role="form" method="post" action="admin.php?id=<?php echo $email;?>">
                <div>
                  <label>Stock Name</label>
                  <input name="deletestockname" type="text" class="form-control" placeholder="Enter Stock">
                </div>
                <?php echo $error2;?>
                <br>
                  <div><input name="delete" type="submit" class="btn btn-info" value="Delete" /></div>
                <br>
              </form>

                <?php if(isset($_GET['msg'])):?>
                  <div class="alert alert-success"><?php echo htmlentities($_GET['msg']);?></div>
                <?php endif; ?>
            </div>
        </div>
        </div><!--/.col-xs-12.col-sm-9-->

        
      </div><!--/row-->

      <hr>

      <?php include 'includes/footer.php';?>


