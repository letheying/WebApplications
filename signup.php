<?php 
  //Written by: Hairong Wang
  //Assisted by: Qike Ying
  //Debugged by: Shi Wang
 ?>
<?php ob_start(); ?>
<?php include 'includes/header.php';?>
<?php 
    //Create DB Object
    $db = new Database();
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
        $query = "INSERT INTO userinformation
                    (username, email, telephone, gender, password)
                    VALUE('$username', '$email', $phonenumber,'$gender','$password2')";
        $insert_row = $db->insert($query);
        $query = "INSERT INTO style
                    (username, styletype, detail)
                    VALUE('$username', 'member', 'default')";
        $insert_row = $db->insert($query);
        $query = "INSERT INTO style
                    (username, styletype, detail)
                    VALUE('$username', 'wish', 'default')";
        $insert_row = $db->insert($query);
        
        header("Location: signin.php?msg=".urlencode('Register Successfully!'));
        exit();
      }
    }
?>



<form class="form-signup" role="form" method="post" action="signup.php">
  <h2 class="form-signin-heading">Please Sign Up</h2>
  <div class="row" >
    <div class="col-md-6">
    <label>Username</label>
    <input name="username" type="text" class="form-control" placeholder="Enter Username">
    </div>
    <div class="col-md-6">
    <label>Email</label>
    <input name="email" type="text" class="form-control" placeholder="Enter Email"> 
    </div>
  </div>
  <div class="row" >
    <div class="col-md-6">
    <label>Phone Number</label>
    <input name="phonenumber" class="form-control" placeholder="Enter Post Body">
    </div>
    <div class="col-md-6">
    <label>Gender</label>
    <select name="gender" class="form-control">
      <option value="male">male</option>
      <option value="female">female</option>
   </select>
    </div>
  </div>
  <div class="row" >
    <div class="col-md-6">
    <label>Password</label>
    <input name="password1" type="text" class="form-control" placeholder="Enter Password">
    </div>
    <div class="col-md-6">
    <label>Comfirm Your Password</label>
    <input name="password2" type="text" class="form-control" placeholder="Repeat Password">
    </div>
  </div>
  <?php echo $error;?>
  </br>
    <div>
  <input name="submit" type="submit" class="btn btn-lg btn-default" value="submit" />
  <a href="signin.php" class="btn btn-lg btn-danger">Cancel</a>
  </div>
  <br>
</form>