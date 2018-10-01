<?php 
  //Written by: Yutong Gao
  //Assisted by: Qike Ying
  //Debugged by: Ying Liu
 ?>
<?php ob_start(); ?>
<?php include 'includes/header_for_profile.php';?>
<?php
  
    //Create DB Object
    $db = new Database();

    $email = $_GET['id'];
    //Create Query
    $query = "SELECT * FROM userinformation WHERE email = '$email';";
    //Run Query
    $userinformation = $db->select($query)->fetch_assoc();

    $username = $userinformation['username'];
    
    if(isset($_POST['submit'])) {
      $username = mysqli_real_escape_string($db->link, $_POST['username']);
      $email = mysqli_real_escape_string($db->link, $_POST['email']);
      $phonenumber = mysqli_real_escape_string($db->link, $_POST['phonenumber']);
      $gender = mysqli_real_escape_string($db->link, $_POST['gender']);
      $password1 = mysqli_real_escape_string($db->link, $_POST['password1']);
      $password2 = mysqli_real_escape_string($db->link, $_POST['password2']);

      //Simple Validation
      if ($username == '' || $email == '' || $phonenumber == '' || $password1 == '' || $password2 == '') {
        $error = 'Please fill out all required fields';
      } else if ($password1 != $password2){
        $error = 'Your password and confirmation password do not match';
      } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 'email address is invalid ';
      } else if ($phonenumber < 1000000000) {
        $error = 'Please enter a 10 digit phone number';
      } else {
        $query = "UPDATE userinformation
                  SET username='$username', email = '$email', telephone = $phonenumber, gender = '$gender', password='$password1';";
        $update_row = $db->update($query);
        header("Location: profile.php?id=$email&msg=".urlencode('Record Updated'));
        exit();
      }
    }
?>

<!-- NAVBAR
================================================== -->
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
                <li><a href="setting.php?id=<?php echo $email;?>">Setting</a></li>
                <li class="active"><a href="profile.php?id=<?php echo $email;?>">Profile</a></li>
                <li class="dropdown">
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
      
    

    <div class="container">
      <form class="form-signup" role="form" method="post" action="profile.php?id=<?php echo $email;?>">
        <h2 class="form-signin-heading">User Information</h2>
        <div class="row" >
          <div class="col-md-6">
          <label>Username</label>
          <input name="username" type="text" class="form-control" placeholder="Enter Username" value="<?php echo $userinformation['username'];?>">
          </div>
          <div class="col-md-6">
          <label>Email</label>
          <input name="email" type="text" class="form-control" placeholder="Enter Email" value="<?php echo $userinformation['email'];?>"> 
          </div>
        </div>
        <div class="row" >
          <div class="col-md-6">
          <label>Phone Number</label>
          <input name="phonenumber" class="form-control" placeholder="Enter Post Body" value="<?php echo $userinformation['telephone'];?>">
          </div>
          <div class="col-md-6">
          <label>Gender</label>
          <select name="gender" class="form-control">
          <?php if($userinformation['gender'] == 'male'){
                  $select1 = 'selected';
                  $select2 = '';
                } else {
                  $select1 = '';
                  $select2 = 'selected';
                }

           ?>
            <option value="male" <?php echo $select1; ?>>male</option>
            <option value="female" <?php echo $select2; ?>>female</option>
         </select>
          </div>
        </div>
        <div class="row" >
          <div class="col-md-6">
          <label>Password</label>
          <input name="password1" type="text" class="form-control" placeholder="Enter Password" value="<?php echo $userinformation['password'];?>">
          </div>
          <div class="col-md-6">
          <label>Comfirm Your Password</label>
          <input name="password2" type="text" class="form-control" placeholder="Repeat Password" value="<?php echo $userinformation['password'];?>">
          </div>
        </div>
        <?php echo $error;?>
        </br>
        <div class="col-md-6">
          <input name="submit" type="submit" class="btn btn-lg btn-info" value="Update" />
        </div>
        <?php if(isset($_GET['msg'])):?>
          <div class="col-md-6">
              <div class="alert alert-success"><?php echo htmlentities($_GET['msg']);?></div>
          </div>
        <?php endif; ?>
        <br>
      </form>

      <hr>

      

    <?php include 'includes/footer.php';?>



