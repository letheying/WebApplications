<?php 
  //Written by: Yutong Gao
  //Assisted by: Qike Ying
  //Debugged by: Ying Liu
 ?>

<?php include 'includes/header_for_help.php';?>
<?php $email = $_GET['id'];?>

<?php
  
    //Create DB Object
    $db = new Database();

    $email = $_GET['id'];

    //Create Query
    $query = "SELECT * FROM userinformation WHERE email = '$email';";
    //Run Query
    $userinformation = $db->select($query)->fetch_assoc();

    $username = $userinformation['username'];
    
?>

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
                <li class="active" class="dropdown">
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
          <div class="jumbotron">
            <h1>Hello, User</h1>
            <p>If you have any questions about this website, please feel free to contact us.</p>
          </div>

          <dir class="row">
            <div class="col-md-1"></div>
            <div class="col-sm-11">
            <div class="col-xs-6 col-lg-4">
              <h2>Shi Wang</h2>
              <p>Team Leader </p>
              <p>Email: sw712@scarletmail.rutgers.edu</p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <h2>Yutong Gao</h2>
              <p>Team Member </p>
              <p>Email: yg296@scarletmail.rutgers.edu</p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <h2>Ying Liu</h2>
              <p>Team Member </p>
              <p>Email: yl1065@scarletmail.rutgers.edu</p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <h2>Hairong Wang</h2>
              <p>Team Member </p>
              <p>Email: hw385@scarletmail.rutgers.edu</p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <h2>Qike Ying</h2>
              <p>Team Member </p>
              <p>Email: qy66@scarletmail.rutgers.edu</p>
            </div><!--/.col-xs-6.col-lg-4-->
            
          </div><!--/row-->
          </dir>

          




        </div><!--/.col-xs-12.col-sm-9-->

        
      </div><!--/row-->

      <hr>

      <?php include 'includes/footer.php';?>

