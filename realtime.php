<?php 
  //Written by: Shi Wang
  //Assisted by: Yutong Gao
  //Debugged by: Ying Liu
 ?>
<?php ob_start(); ?>
<?php include 'config/config.php';?>
<?php include 'libraries/Database.php';?>
<?php include 'helpers/format_helper.php';?>          

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
<?php include 'includes/header_for_realtime.php';?>

  
<body>

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
          <h1 class="page-header">Realtime</h1>
          <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
              <table width="1000">
                <tr>
                  <th style="width:20%">Company</th>
                  <th style="width:20%">Time</th>
                  <th style="width:20%">Ask</th>
                  <th style="width:20%">Bid</th>
                  <th style="width:20%">Volume</th>
                  
                </tr>
                <br>


                <?php $query = "SELECT DISTINCT stockname FROM historydata";?>
                <?php $stocknames = $db->select($query);?>

                <?php while ($row = $stocknames->fetch_assoc()):?>
                   <?php $company = $row['stockname'];?>
                   <?php $format = 't1abv';?>
                   <?php $stocks = file_get_contents("http://download.finance.yahoo.com/d/quotes.csv?s=$company&f=$format");?>
                   <?php $stocks = trim($stocks);?>
                   <?php $stocks_str = explode(',',$stocks);?>
                   <tr>
                    <td style="width:20%"><?php echo $company;?></td>
                    <td style="width:20%"><?php echo $stocks_str[0];?></td>
                    <td style="width:20%"><?php echo $stocks_str[1];?></td>
                    <td style="width:20%"><?php echo $stocks_str[2];?></td>
                    <td style="width:20%"><?php echo $stocks_str[3];?></td>  
                  </tr>
                <?php endwhile;?>
                
              </table>
          </div>
          <div class="col-md-1"></div>
          
          </div>






          

            
            <!-- Marketing messaging and featurettes
            ================================================== -->
            <!-- Wrap the rest of the page in another container to center all the content. -->

            <div class="container marketing">
            <br>
            <br>
            <br>

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
    
  </body>



</html>
