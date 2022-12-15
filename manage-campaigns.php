<?php include 'includes/config.php' ;?>
<?php
session_start();
error_reporting(0);
$user=$_SESSION['o_username'];
include('includes/config.php');
if(strlen($_SESSION['o_username'])==0)
  { 
      echo "<script> alert('Session Expired, Please Login Again!');</script>" ;
      echo "<script type='text/javascript'> document.location ='login.php'; </script>";
}
else{?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
      EasyFundss - Manage Campaigns
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <?php include 'includes/sidebar.php' ;?>
    <div class="main-panel">
      <!-- Navbar -->
            <?php include 'includes/navbar.php' ;?>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          
          
          </div>
       
        <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Campaigns waiting to be Approved by Admin</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                    <th>Campaign Name</th>
                    <th>Creator's Name</th>
                    <th>Date & Time</th>
                    <th>Category</th>
                    <th>Details</th>
                    </thead>
                    <tbody>
                      <?php
                 $sql1="SELECT * FROM campaigns WHERE campaignCreator='$user' and campaignApproval=0";
                 $result1=mysqli_query($conn,$sql1);
                 $num=1;
                 while($row= mysqli_fetch_assoc($result1))
                 	{
                        
                 		echo "<tr>";
                 		echo "<td>".$row['campaign_name'];
                 		echo "<td>".$row['campaignCreator'];
                 		echo "<td>".$row['campaign_reg_date'];
                 		echo "<td>".$row['campaign_type'];
                        ?>
                 		<td><form method='post' action='edit-campaigns.php'>
                            <input type="hidden" name="id" value="<?php echo $row['campaign_id'];?> "><button type="submit" name="review" class="reviewButton">Edit</button></form>
                 		<?php echo "</tr>";
                        $num++;
                         
                
                 	
                 	}

                 	?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          </div>
          </div>
      </div>
      <?php include 'includes/footer.php' ;?>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
</body>
</html>
<?php } ?>