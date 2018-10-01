<?php 
  //Written by: Ying Liu
  //Assisted by: Yutong Gao
  //Debugged by: Hairong Wang
 ?>
<?php ob_start(); ?>
<?php date_default_timezone_set('America/New_York');?>
<?php include 'includes/header_for_prediction.php';?>
<?php 
    $email = $_GET['id'];
    //Create DB Object
    $db = new Database();
    //Create Query
    $query = "SELECT DISTINCT stockname FROM historydata";
    //Run Query
    $stocknames = $db->select($query);

    //Create Query
    $query = "SELECT * FROM userinformation WHERE email = '$email';";
    //Run Query
    $userinformation = $db->select($query)->fetch_assoc();

    $username = $userinformation['username'];

    if(isset($_POST['submit'])){
      $method = mysqli_real_escape_string($db->link, $_POST['predictionMethod']);
      $stockname = mysqli_real_escape_string($db->link, $_POST['stockname']);
      $startyear = mysqli_real_escape_string($db->link, $_POST['startyear']);
      $startmonth = mysqli_real_escape_string($db->link, $_POST['startmonth']);
      $startday = mysqli_real_escape_string($db->link, $_POST['startday']);
      $endyear = mysqli_real_escape_string($db->link, $_POST['endyear']);
      $endmonth = mysqli_real_escape_string($db->link, $_POST['endmonth']);
      $endday = mysqli_real_escape_string($db->link, $_POST['endday']);
      $days = mysqli_real_escape_string($db->link, $_POST['days']);
      $dataType = mysqli_real_escape_string($db->link, $_POST['dataType']);
      
      $ss = $startyear.'-'.$startmonth.'-'.$startday;
      $starttime = new DateTime($ss);
      $startdate = $starttime->format('Y-m-d');

      $ee = $endyear.'-'.$endmonth.'-'.$endday;
      $endtime = new DateTime($ee);
      $enddate = $endtime->format('Y-m-d');

      if($stockname == ""){
          $error = "Please input stock name";
      }
      elseif($days == ""){
          $error = "Please enter the number of days past the end of the date range for which you would like the forecast";
      }
      elseif($startdate >= $enddate){
          $error = "start date must be less than end date";
      }
    }
?>

<script>
  angular.module("app", ["chart.js"]).controller("myCtrl", function ($scope) {
    $scope.labels = [];
    $scope.data = [];
    Price = [];

        <?php if($error == ""):?>
        <?php $query = "SELECT * FROM historydata WHERE stockname = '$stockname' AND date >= '$startdate' AND date <= '$enddate';"; ?>
        <?php $result = $db->select($query);?>      
        <?php if($result): ?>
          <?php while ($row = $result->fetch_assoc()): ?> 
            $scope.labels.splice(0, 0, '<?php echo $row['date'];?>');
            Price.splice(0, 0, <?php echo $row[$dataType];?>);
            <?php $parameter = $row[$dataType].' '.$parameter;?>
          <?php endwhile;?>
        <?php endif;?>
        <?php $parameter = substr($parameter, 0, -1);?>
        <?php $current = $row[$dataType];?>

        <?php while ($days > 0):?> 
            <?php if($method == 'Bayesian Curve Fitting'):?>
              <?php $result = exec("python Bayesian_Curve_Fitting.py '$parameter' '$days'");?>
            <?php elseif($method == 'Artificial Neural Network'):?>
              <?php $result = exec("python Artificial_Neural_Network.py '$parameter' '$days'");?>
            <?php elseif($method == 'Support Vector Machine'):?>
              <?php $result = exec("python Support_Vector_Machine.py '$parameter' '$days'");?>
            <?php endif ?>
            $scope.labels.push('<?php echo 'predictive value';?>');
            Price.push(<?php echo $result;?>);
            
            <?php $days = $days - 1; ?> 
          <?php endwhile?>
          <?php $current = $result;?>
        $scope.data = Price;        
        <?php endif;?>


  });
</script>
 <?php 
 if($result>$current){
  $strategy = "We suggest you to buy more";
 }
 else{
  $strategy = "We suggest you to sell";
 }
 ?>

  <body>
  <div ng-app="app" ng-controller="myCtrl">

    <div class="navbar-wrapper">
      <div class="container">
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
    <br>
    <br>
    <br>



    <div class="container">
        <div>
          <h1 class="page-header">Prediction</h1>        
            <form role="form" method="post" action="prediction.php?id=<?php echo $email;?>">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Stock Name</label>
                      <select name="stockname" class="form-control">
                        <?php while($row=$stocknames->fetch_assoc()):?>
                            <option value="<?php echo $row['stockname'];?>"><?php echo $row['stockname']?></option>
                        <?php endwhile;?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Prediction Method</label>
                      <select name="predictionMethod" class="form-control">
                        <option value="Bayesian Curve Fitting">Bayesian Curve Fitting</option>
                        <option value="Artificial Neural Network">Artificial Neural Network</option>
                        <option value="Support Vector Machine">Support Vector Machine</option>
                      </select>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <h4>Please Select Data Range For This Perdiction</h4>
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
                    </div>
                    <div class="col-md-6">
                    <br>
                    <br>
                    <label>Data Type</label>
                      <select name="dataType" class="form-control">
                        <option value="open">Open</option>
                        <option value="high">High</option>
                        <option value="low">Low</option>
                        <option value="close">Close</option>
                        <option value="volume">Volume</option>
                      </select>
                    <label>Enter the number of days past the end of the date range for which you would like the forecast</label>
                       <input name="days" class="form-control" placeholder="1,2,3..." />
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-md-6">
                      <label><?php echo "Prediction Method: ".$method;?></label>
                    </div>
                    <div class="col-md-6">
                      <label><?php echo "Result : ";?></label>
                    </div>
                  </div>
                  
                  
                  <br>
                  <br>
                  <div class="row">
                  <div class="col-md-6"><input name="submit" type="submit" class="btn btn-info" value="Predict" /></div>
                  </div>
                  <?php echo $error;?>
              </form>         

        </div>
        <div class="row"><div class="col-md-4"></div><div class="col-md-4"><h2><?php echo $strategy;?></h2></div><div class="col-md-4"></div></div>
        
            <canvas id="line" class="chart chart-line" chart-data="data"
              chart-labels="labels" chart-series="series">
            </canvas>


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
      
      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 Company, Inc.</p>
      </footer>
    </div>



  </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    </div>
  </body>
 





</html>
