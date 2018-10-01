<?php 
  //Written by: Shi Wang
  //Assisted by: Qike Ying
  //Debugged by: Ying Liu
 ?>
<?php 
    //Create DB Object
    $db = new Database();

    $email = $_GET['id'];
     //Create Query
    $query1 = "SELECT DISTINCT date FROM historydata ORDER BY date ASC";
    $query2 = "SELECT DISTINCT date FROM historydata ORDER BY date DESC";
    //Run Query
    $time1 = $db->select($query1);
    $time2 = $db->select($query2);
    //Create Query
    $query = "SELECT * FROM userinformation WHERE email = '$email';";
    //Run Query
    $userinformation = $db->select($query)->fetch_assoc();

    $username = $userinformation['username'];


    $query = "SELECT DISTINCT stockname FROM historydata";
    //Run Query
    $stocknames = $db->select($query);
?>



<?php date_default_timezone_set('America/New_York');?>
        <?php
             $starttime = new DateTime();
             $todaydate = $starttime->format('Y-m-d');
         
             $tendaysdate = date('Y-m-d',strtotime('-10 day')); 
            
             $oneyeardate = date('Y-m-d',strtotime('-1 year'));
            
        ?>


<?php 
    if(isset($_POST['submit'])){ 
        $stockname = mysqli_real_escape_string($db->link, $_POST['stockname']);
        $type = mysqli_real_escape_string($db->link, $_POST['datatype']);
        $startdate = mysqli_real_escape_string($db->link, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($db->link, $_POST['enddate']);
        $MA = mysqli_real_escape_string($db->link, $_POST['MA']);
        $BB = mysqli_real_escape_string($db->link, $_POST['BB']);
        $KC = mysqli_real_escape_string($db->link, $_POST['KC']);
        if($stockname == ""){
            $error = "Please input stock name";
        }
        elseif($type == ""){
            $error = "Please select data type";
        }
        elseif($startdate >= $enddate){
            $error = "start date must be less than end date";
        }
        else{
          
          $query = "SELECT * FROM historydata WHERE stockname = '$stockname' AND date >= '$tendaysdate' AND date <= '$todaydate';"; 
          $result = $db->select($query);
           if($result){
          while ($row = $result->fetch_assoc()){ 
            $tendaysarr = array();
          array_push($tendaysarr, $row['high']);
          $max = max($tendaysarr);
         }
        }

          
         $query = "SELECT * FROM historydata WHERE stockname = '$stockname' AND date >= '$oneyeardate' AND date <= '$todaydate';"; 
         $result = $db->select($query);
         if($result){
          while ($row = $result->fetch_assoc()){
            $averagearr = array();
            array_push($averagearr, $row['close']);
           $avg1 = array_sum($averagearr) / count($averagearr);
           $avg2 = round($avg1,1);
           }
       }

         
          $query = "SELECT * FROM historydata WHERE stockname = '$stockname' AND date >= '$oneyeardate' AND date <= '$todaydate';"; 
           $result = $db->select($query);
           if($result){
           while ($row = $result->fetch_assoc()){
            $lowestarr= array();
           array_push($lowestarr, $row['low']);
           $min = min($lowestarr);
         }
         }
           
        
         while($row=$stocknames->fetch_assoc()){
               $a = $row['stockname'];  
           $query = "SELECT * FROM historydata WHERE stockname ='$a' AND date >= '$oneyeardate' AND date <= '$todaydate';"; 
            $result = $db->select($query);
            if($result){
             while ($row = $result->fetch_assoc()){
              $averageall = array();
              array_push($averageall, $row['close']);
              $avg11 = array_sum($averageall) / count($averageall);
              $avg12 = round($avg11,1);  
            }              
            if($avg12 < $min){
               $name = $name.$a."(".$avg12.")"." ";
            }
           }            
         }           
        }
    }

?>

<script>
  angular.module("app", ["chart.js"]).controller("myCtrl", function ($scope) {
    $scope.labels = [];
    $scope.histories = [];
    TR = [];
    ATR = [];
    Price = [];
    MA = [];
    BBU = [];
    BBL = [];
    KCU = [];
    KCL = [];

        <?php if($error == ""):?>
        <?php $query = "SELECT * FROM historydata WHERE stockname = '$stockname' AND date >= '$startdate' AND date <= '$enddate';"; ?>
        <?php $result = $db->select($query);?>      
        <?php if($result): ?>
          <?php while ($row = $result->fetch_assoc()): ?> 
            $scope.histories.push(new History('<?php echo $row['date'];?>', <?php echo $row['open'];?>, <?php echo $row['high'];?>, <?php echo $row['low'];?>, <?php echo $row['close'];?>, <?php echo $row['volume'];?>));
            $scope.labels.splice(0, 0, '<?php echo $row['date'];?>');
            Price.splice(0, 0, <?php echo $row[$type];?>);
          <?php endwhile;?>
        <?php endif;?>


        <?php $query = "SELECT * FROM historydata WHERE stockname = '$stockname' AND date >= '$startdate' AND date <= '$enddate';"; ?>
        <?php $result = $db->select($query);?>      
        <?php if($result): ?>
          <?php while ($row = $result->fetch_assoc()): ?> 
            TR.push(<?php echo $row['high'];?>-<?php echo $row['low'];?>);
          <?php endwhile;?>
        <?php endif;?>
        <?php endif;?>
        
        // Moving Average
        for(i = 0;i<Price.length;i++){
          temp = 0;
          if(i<4||i>Price.length-6){
            temp = Price[i];
          }
          else{
            for(j=i-4;j<=i+5;j++){
              temp += Price[j];
            }
            temp /=10;
          }
          MA.push(temp);
        }
        // Bollinger Bands
        for(i = 0;i<Price.length;i++){
          temp = 0;

          if(i<4||i>Price.length-6){
            temp = 0;
          }
          else{
            for(j=i-4;j<=i+5;j++){
              temp += (Price[j] - MA[j]) * (Price[j] - MA[j]);
            }
            temp /=10;
            temp = Math.sqrt(temp);
          }

          BBU.push(MA[i] + 2*temp);
          BBL.push(MA[i] - 2*temp);
        }
        // Keltner Channels
        //ATR
        for(i = 0;i<Price.length;i++){
          temp = 0;
          if(i<9){
            temp = TR[i];
          }
          else{
            for(j=i-4;j<=i+5;j++){
              temp += TR[j];
            }
            temp /=10;
          }
          ATR.push(temp);
        }

        for(i = 0;i<Price.length;i++){
          KCU.push(MA[i] + 2*ATR[i]);
          KCL.push(MA[i] - 2*ATR[i]);
        }
        
        <?php if($MA == "on" && $BB == "on" && $KC == "on"):?>
          $scope.series = ['Price', 'Moving Average', 'Bollinger Upper Band', 'Bollinger Lower Band','Keltner Channel Upper Band', 'Keltner Channel Lower Band'];
          $scope.data = [[],[],[],[],[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = MA;
          $scope.data[2] = BBU;
          $scope.data[3] = BBL;
          $scope.data[4] = KCU;
          $scope.data[5] = KCL;
        <?php endif;?>
        <?php if($MA != "on" && $BB != "on" && $KC != "on"):?>
          $scope.series = ['Price'];
          $scope.data = [[]];
          $scope.data[0] = Price;
        <?php endif;?>
        <?php if($MA == "on" && $BB != "on" && $KC != "on"):?>
          $scope.series = ['Price', 'Moving Average'];
          $scope.data = [[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = MA;
        <?php endif;?>
        <?php if($MA != "on" && $BB == "on" && $KC != "on"):?>
          $scope.series = ['Price', 'Bollinger Upper Band', 'Bollinger Lower Band'];
          $scope.data = [[],[],[],[],[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = BBU;
          $scope.data[2] = BBL;
        <?php endif;?>
        <?php if($MA != "on" && $BB != "on" && $KC == "on"):?>
          $scope.series = ['Price', 'Keltner Channel Upper Band', 'Keltner Channel Lower Band'];
          $scope.data = [[],[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = KCU;
          $scope.data[2] = KCL;
        <?php endif;?>
        <?php if($MA == "on" && $BB == "on" && $KC != "on"):?>
          $scope.series = ['Price', 'Moving Average', 'Bollinger Upper Band', 'Bollinger Lower Band'];
          $scope.data = [[],[],[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = MA;
          $scope.data[2] = BBU;
          $scope.data[3] = BBL;
        <?php endif;?>
        <?php if($MA == "on" && $BB != "on" && $KC == "on"):?>
          $scope.series = ['Price', 'Moving Average', 'Keltner Channel Upper Band', 'Keltner Channel Lower Band'];
          $scope.data = [[],[],[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = MA;
          $scope.data[2] = KCU;
          $scope.data[3] = KCL;
        <?php endif;?>
        <?php if($MA != "on" && $BB == "on" && $KC == "on"):?>
          $scope.series = ['Price', 'Bollinger Upper Band', 'Bollinger Lower Band','Keltner Channel Upper Band', 'Keltner Channel Lower Band'];
          $scope.data = [[],[],[],[],[]];
          $scope.data[0] = Price;
          $scope.data[1] = BBU;
          $scope.data[2] = BBL;
          $scope.data[3] = KCU;
          $scope.data[4] = KCL;
        <?php endif;?>
        
  });
</script>