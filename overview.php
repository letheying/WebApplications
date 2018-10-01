<?php 
  //Written by: Shi Wang
  //Assisted by: Hairong Wang
  //Debugged by: Yutong Gao
 ?>
<?php ob_start(); ?>
<?php include 'includes/header_for_overview.php';?>
<?php include 'overviewCtrl.php';?>
<!-- NAVBAR
================================================== -->
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
        <div id="welcome">
        <div class="col-md-7"><h1>Chart</h1></div>
        <div class="col-md-5"><h2>Welcome, <?php echo $userinformation['username'];?></h2></div>
        </div>
          
          <?php /* Chart */?>
          <div class="row">
            <div class="col-md-7">
            <h3 align="center"><?php echo $stockname;?></h3>
            <canvas id="line" class="chart chart-line" chart-data="data"
              chart-labels="labels" chart-series="series">
            </canvas>
            </div>
            <div class="col-md-5">
                <form role="form" method="post" action="overview.php?id=<?php echo $email;?>">
                  <div class="col-md-5">    
                  <label>
                    <input type="radio" name="datatype" value="open">
                    Open
                  </label><br/>
                  <label>
                    <input type="radio" name="datatype" value="high">
                    High
                  </label><br/>
                  <label>
                    <input type="radio" name="datatype" value="low">
                    Low
                  </label><br/>
                  <label>
                    <input type="radio" name="datatype" value="close">
                    Close
                  </label><br/>
                  <label>
                    <input type="radio" name="datatype" value="volume">
                    Volume
                  </label><br><br> 
                  <label>Select Indicator</label>
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="MA">
                    Moving Average
                  </label>  
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="BB">
                    Bollinger Bands
                  </label> 
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="KC">
                    Keltner Channels
                  </label>    
                </div>
                <div class="col-md-7">
                <div class="row">
                  <input type="text" class="form-control" name="stockname" placeholder="Stock Name">
                  <br>
                </div>
                  <div class="row">    
                      <label>Start Date</label>
                      <select name="startdate" class="form-control">
                        <?php while($row=$time1->fetch_assoc()):?>
                            <option value="<?php echo $row['date'];?>"><?php echo $row['date']?></option>
                        <?php endwhile;?>
                      </select>
                  </div>
                  <div class="row">    
                      <label>End Date</label>
                      <select name="enddate" class="form-control">
                        <?php while($row=$time2->fetch_assoc()):?>
                            <option value="<?php echo $row['date'];?>"><?php echo $row['date']?></option>
                        <?php endwhile;?>
                      </select>
                  </div>
                  <br>
                  <div class="row"><input id = "searchButton" name="submit" type="submit" class="btn btn-lg btn-default btn-block" value="Search" /></div>
                  <?php echo $error;?>
                </div>
                </form>             
            </div>
          </div>
          
              <?php /* Table */?>
            <h3 class="sub-header"></h3>

              <div>
                <table class="table table-striped">
                  <thead>
                    <th style="width:25%">The highest stock price in the last ten days</th>
                    <th style="width:15%"><?php if(isset($_POST['submit'])){ echo $max; }?></th>
                  </thead>
                  <thead>
                    <th style="width:25%">Average stock price in the latest one year</th>
                    <th style="width:15%"><?php if(isset($_POST['submit'])){ echo $avg2;}?></th>
                  </thead>
                  <thead>
                    <th style="width:25%">Lowest stock price in the latest one year</th>
                    <th style="width:15%"><?php if(isset($_POST['submit'])){echo $min;}?></th>
                  </thead>
                  <thead>
                    <th style="width:25%">The companies who have the average stock price lesser than the lowest of the selected company in the latest one year</th>
                    <th style="width:15%"><?php if(isset($_POST['submit'])){echo $name;}?></th>
                  </thead>
                </table>
              </div>

          <?php /* Table */?>
            <h3 class="sub-header">Table</h3>

              <div>
                <table class="table table-striped">
                  <thead>
                    <th style="width:25%">Date</th>
                    <th style="width:15%">Open</th>
                    <th style="width:15%">High</th>
                    <th style="width:15%">Low</th>
                    <th style="width:15%">Close</th>
                    <th style="width:15%">Volume</th>
                  </thead>
                </table>
              </div>

              <div class="mytable">
                <table class="table table-striped">
                  <tbody>
                    <tr ng-repeat="x in histories">
                      <td style="width:25%">{{x.date}}</td>
                      <td style="width:15%">{{x.open}}</td>
                      <td style="width:15%">{{x.high}}</td>
                      <td style="width:15%">{{x.low}}</td>
                      <td style="width:15%">{{x.close}}</td>
                      <td style="width:15%">{{x.volume}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>



    
            </div>
            


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    
     
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
  </body>
</html>
