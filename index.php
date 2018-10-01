<?php 
  //Written by: Hairong Wang
  //Assisted by: Shi Wang
  //Debugged by: Qike Ying
 ?>

<?php ob_start(); ?>
<?php include 'includes/header_for_index.php';?>
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
    $aaa = $db->select($query)->fetch_assoc();
    $aa = $aaa['detail'];
    
    //Create Query
    $query = "SELECT detail FROM style WHERE username = '$username' AND styletype = 'wish';";
    //Run Query
    $bbb = $db->select($query)->fetch_assoc();
    $bb = $bbb['detail'];

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
                <li class="active"><a href="index.php?id=<?php echo $email;?>">Home</a></li>
                <li><a href="setting.php?id=<?php echo $email;?>">Join us</a></li>
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

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>

      <?php if ($bb == 0):?>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="pictures/city1.jpeg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>MAKE YOUR OWN WATCHLIST</h1>
              <p>Add your favorite stocks in your admin!</p>
              <p><a class="btn btn-lg btn-primary" onclick="aaa()">Add your wish list</a></p>
            </div>
          </div>
        </div>

      <?php else:?>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="pictures/city1.jpeg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>MAKE YOUR OWN WATCHLIST</h1>
              <p>Add your favorite stocks in your admin!</p>
              <p><a class="btn btn-lg btn-primary" href="admin.php?id=<?php echo $email;?>" role="button">Add your wish list</a></p>
            </div>
          </div>
        </div>
        <?php endif?>

      <?php if($aa == 0):?>
        <div class="item">
          <img class="second-slide" src="pictures/stock1.jpeg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>PROFESSIONAL ANALYSIS PROVIDED NOW</h1>
              <p>Together, we can predict the stock market!</p>
              <p><a class="btn btn-lg btn-primary" onclick="aaa()">Start your prediction</a></p>
            </div>
          </div>
        </div>
      <?php else:?>
        <div class="item">
          <img class="second-slide" src="pictures/stock1.jpeg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>PROFESSIONAL ANALYSIS PROVIDED NOW</h1>
              <p>Together, we can predict the stock market!</p>
              <p><a class="btn btn-lg btn-primary"  href="prediction.php?id=<?php echo $email;?>" role="button">start your prediction</a></p>
            </div>
          </div>
        </div>
      <?php endif?>


        <div class="item">
          <img class="third-slide" src="pictures/join.jpeg" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>JOIN US</h1>
              <p>Come and join us! We will make it better!</p>
              <p><a class="btn btn-lg btn-primary" href="setting.php?id=<?php echo $email;?>" role="button">Join us</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">

        <?php if($bb == 0):?>
        <div class="col-lg-4">
          <img class="img-circle" src="pictures/realtime.png" alt="Generic placeholder image" width="140" height="140">
          <h2>Realtime </h2>
          <p>Acquire realtime data</p>
          <p>Start to keep tracking fluctuation on your favorite stocks. Get instant access to realtime sources and make desicions as soon as possible!</p>
          <p><a class="btn btn-default" onclick = "aaa()" role="button">View details &raquo;</a></p>
        <?php else:?>
        <div class="col-lg-4">
          <img class="img-circle" src="pictures/realtime.png" alt="Generic placeholder image" width="140" height="140">
          <h2>Realtime </h2>
          <p>Acquire realtime data</p>
          <p>Start to keep tracking fluctuation on your favorite stocks. Get instant access to realtime sources and make desicions as soon as possible!</p>
          <p><a class="btn btn-default" href="realtime.php?id=<?php echo $email;?>" role="button">View details &raquo;</a></p>
        <?php endif?>
        </div><!-- /.col-lg-4 -->


        <?php if($aa == 0):?>
        <div class="col-lg-4">
          <img class="img-circle" src="pictures/predict.png" alt="Generic placeholder image" width="140" height="140">
          <h2>Predict</h2>
          <p>Make prediction in your way</p>
          <p>Provide you different ways for stock forecasts. Accurate and comprehensive prediction makes a better choice.</p>
          <p><a class="btn btn-default" onclick = "aaa()" role="button">View details &raquo;</a></p>
        <?php else:?>
        <div class="col-lg-4">
          <img class="img-circle" src="pictures/predict.png" alt="Generic placeholder image" width="140" height="140">
          <h2>Predict</h2>
          <p>Make prediction in your way</p>
          <p>Provide you different ways for stock forecasts. Accurate and comprehensive prediction makes a better choice.</p>
          <p><a class="btn btn-default" href="prediction.php?id=<?php echo $email;?>" role="button">View details &raquo;</a></p>
        <?php endif?>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="pictures/history.png" alt="Generic placeholder image" width="140" height="140">
          <h2>Overview</h2>
          <p>History data and query</p>
          <p>Wanna know the stock trends in a specific period? Wanna know the history stock price you are interested in? Don't forget the overview for your favorite stocks!</p>
          <p><a class="btn btn-default" href="overview.php?id=<?php echo $email;?>" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


    

      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 Company, Inc.</p>
      </footer>

    </div><!-- /.container -->


<script>

function aaa()
{
  alert("You need to buy our server first! Press the Join Us botton to get more servers");
}
</script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
  </body>
</html>
