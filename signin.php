<?php 
  //Written by: Hairong
  //Assisted by: Qike Ying
  //Debugged by: Yutong Gao
 ?>
<?php ob_start(); ?>
<?php include 'includes/header.php';?>
<?php 
    //Create DB Object
    $db = new Database();
    if(isset($_POST['Sign_in'])) {
      $email = mysqli_real_escape_string($db->link, $_POST['email']);
      $password = mysqli_real_escape_string($db->link, $_POST['password']);
      //Simple Validation
      if ($email == '' || $password == '') {
        $error = 'Please fill out all required fields';
      } else {
        $query = "SELECT * FROM userinformation
                  WHERE email = '$email';";
        //Run Query
        $result = $db->select($query);
        if(!$result) {
          $error = 'There is no account for this email address';
        } else {
          $result = $result->fetch_assoc();
          if($result['password'] != $password){
            $error = 'password is incorrect';
          } else {
            header("Location: index.php?id=$email");
            exit();
          }
        }
        
      }
    }
?>
  <body>
    <div class="container">
      <form class="form-signin" role="form" method="post" action="signin.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input class="form-control" placeholder="Email address" name="email">
        <label for="inputPassword" class="sr-only">Password</label>
        <input class="form-control" type="password" placeholder="Password" name="password">

        <?php 
          if(isset($_POST['Sign_in'])) {
            echo $error;
          }
        ?>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
          <label>
            <a class="blog-nav-item" href="signup.php">create an account</a>
          </label>
        </div>
        <input name="Sign in" type="submit" class="btn btn-lg btn-primary btn-block" value="submit" />

      </form>
    </div> <!-- /container -->
    <div class="container">
     <div class="col-md-5"></div><div class="col-md-4"><h4><a href="https://www.overleaf.com/read/mkqgbfwfsfxx">Report Of Project</a></h4></div>
    </div> <!-- /container -->
     

    <div class="form-signin">
      <?php if(isset($_GET['msg'])):?>
        <div class="alert alert-success"><?php echo htmlentities($_GET['msg']);?></div>
      <?php endif; ?>
    </div>
  </body>
</html>

