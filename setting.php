<?php 
  //Written by: Qike Ying
  //Assisted by: Hairong Wang
  //Debugged by: Shi Wang
 ?>
<?php ob_start(); ?>

<?php include 'includes/header_for_setting.php';?>
<?php 
  //Create DB Object
  $db = new Database();
  $email = $_GET['id'];

  //Create Query
  $query = "SELECT * FROM userinformation WHERE email = '$email';";
  //Run Query
  $userinformation = $db->select($query)->fetch_assoc();
  $username = $userinformation['username'];

//Create Query
  $query = "SELECT detail FROM style WHERE username = '$username' AND styletype = 'member';";
  //Run Query
  $memberShip = $db->select($query)->fetch_assoc();

  //Create Query
  $query = "SELECT detail FROM style WHERE username = '$username' AND styletype = 'wish';";
  //Run Query
  $wishList = $db->select($query)->fetch_assoc();

?>
<?php
  if(isset($_POST['submit'])){
    $memberShip = mysqli_real_escape_string($db->link, $_POST['member_ship']);
    $wishList = mysqli_real_escape_string($db->link, $_POST['wish_list']);
    //$headerColor = mysqli_real_escape_string($db->link, $_POST['headerColor']);
    

    $query = "UPDATE style
              SET  detail = '$memberShip'
              WHERE username = '$username' AND styletype = 'member';";
    $insert_row = $db->insert($query);

    $query = "UPDATE style
              SET  detail = '$wishList'
              WHERE username = '$username' AND styletype = 'wish';";
    $insert_row = $db->insert($query);
    header("Location: setting.php?id=$email&msg=".urlencode('Setting Updated'));
        exit();
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
                <li class="active"><a href="setting.php?id=<?php echo $email;?>">Join us</a></li>
                <li><a href="profile.php?id=<?php echo $email;?>">Profile</a></li>
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
    </div>
    <br>
    <br>
    <br>
    <br>


    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

            <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="row">
          <div class="jumbotron">
            <h1>Join the membership</h1>
            <p>Make money with money</p>
          </div>
            <form role="form" method="post" action="setting.php?id=<?php echo $email;?>">
              <dir class="row">
                <div class="col-md-4">
                    <h2>Prediction Membership</h2>
                    <select name="member_ship" class="form-control">
                      <?php 
                        $select1 = '';$select2 = '';$select3 = '';$select4 = '';$select5 = '';
                        switch($memberShip['detail']){
                              case '7':$select1 = 'selected';
                              break;
                              case '14':$select2 = 'selected';
                              break;
                              case '30':$select3 = 'selected';
                              break;
                              case '365':$select4 = 'selected';
                              break;
                              case '0':$select5 = 'selected';
                              break;}
                      ?>
                      <option value="7" <?php echo $select1;?>>7 days</option>
                      <option value="14" <?php echo $select2;?>>14 days</option>
                      <option value="30" <?php echo $select3;?>>30 days</option>
                      <option value="365" <?php echo $select4;?>>365 days</option>
                      <option value="0" <?php echo $select5;?>>ooops, let me think about it again!</option>
                   </select>
                  </div><!--/.col-xs-6.col-lg-4-->
                  <div class="col-md-4">
                    <h2>Wish List membership</h2>
                    <select name="wish_list" class="form-control">
                      <?php 
                        $select1 = '';$select2 = '';$select3 = '';$select4 = '';$select5 = '';
                        switch($wishList['detail']){
                              case '7':$select1 = 'selected';
                              break;
                              case '14':$select2 = 'selected';
                              break;
                              case '30':$select3 = 'selected';
                              break;
                              case '365':$select4 = 'selected';
                              break;
                              case '0':$select5 = 'selected';
                              break;}
                      ?>
                     <option value="7" <?php echo $select1;?>>7 days</option>
                      <option value="14" <?php echo $select2;?>>14 days</option>
                      <option value="30" <?php echo $select3;?>>30 days</option>
                      <option value="365" <?php echo $select4;?>>365 days</option>
                      <option value="0" <?php echo $select5;?>>ooops, let me think about it again!</option>
                   </select>
                  </div><!--/.col-xs-6.col-lg-4-->
                </dir>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                    <input name="submit" type="submit" class="btn btn-lg btn-primary btn-block" value="Buy it"/>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                  <?php if(isset($_GET['msg'])):?>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="alert alert-success" style="text-align: center;"><?php echo htmlentities($_GET['msg']);?></div>
                    </div>
                    <div class="col-md-4"></div>
                  <?php endif; ?>
          </form> 
          
        </div><!--/.col-xs-12.col-sm-9-->

        
      </div><!--/row-->

      <hr>

      <?php include 'includes/footer.php';?>