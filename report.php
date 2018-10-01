<?php 
  //Written by: Qike Ying
  //Assisted by: Hairong Wang
  //Debugged by: Yutong Gao
 ?>
<?php ob_start(); ?>
<?php include 'includes/header_for_report.php';?>
<?php $email = $_GET['id'];?>

<?php 
    //Create DB Object
    $db = new Database();

    //Create Query
    $query = "SELECT * FROM userinformation WHERE email = '$email';";
    //Run Query
    $userinformation = $db->select($query)->fetch_assoc();

    $username = $userinformation['username'];

    if(isset($_POST['submit'])) {
      $category = mysqli_real_escape_string($db->link, $_POST['category']);
      $feedback = mysqli_real_escape_string($db->link, $_POST['feedback']);


      //Simple Validation
      if ($feedback == '') {
        $error = 'Please fill out all required fields';
      } else {
        $query = "INSERT INTO problem
                    (email, category, feedback)
                    VALUE('$email', '$category', '$feedback')";
        $insert_row = $db->insert($query);
        header("Location: report.php?id=$email&msg=".urlencode('Feedback Submitted Successfully'));
        exit();
      }
    }
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
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        
          
            
                  <h1 class="page-header">Report</h1>
                      <form role="form" method="post" action="report.php?id=<?php echo $email;?>">
                          <div class="row">
                            <div class="col-md-6">
                              <label>Category</label>
                              <select name="category" class="form-control">
                                <option value="NOT MOBILE-FRIENDLY">NOT MOBILE-FRIENDLY</option>
                                <option value="POOR DESIGN">POOR DESIGN</option>
                                <option value="OUT DATED CONTENT">OUTDATED CONTENT</option>
                              </select>
                            </div>
                          </div>
                          <br>
                          <br>
                          <div>
                            <label>Write down your feedback</label>
                            <div class="row">
                            <div class="col-md-6">
                              <textarea name="feedback" class="form-control" placeholder="Enter Your Feedback"></textarea>
                            </div>
                          </div>
                          <br>
                          <?php echo $error;?>
                          <div class="row">
                          <div class="col-md-6"><input name="submit" type="submit" class="btn btn-info" value="Send" /></div>
                          <?php if(isset($_GET['msg'])):?>
                          <div class="col-md-6"><div class="alert alert-success"><?php echo htmlentities($_GET['msg']);?></div></div>
                          <?php endif; ?>
                          </div>
                      </form>         
              
          
        </div><!--/.col-xs-12.col-sm-9-->

        
      </div><!--/row-->

      <hr>

      <?php include 'includes/footer.php';?>

