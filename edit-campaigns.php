<?php include 'includes/config.php' ;?>

<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['o_username'])==0)
  { 
      echo "<script> alert('Session Expired, Please Login Again!');</script>" ;
      echo "<script type='text/javascript'> document.location ='index.php'; </script>";
}
else{?>
<?php
if(isset($_POST['review']))
{
    $id =$_POST['id'];
	$row=$id;
	 $sql1="SELECT * FROM campaigns WHERE campaign_id=$id";
      $result1=mysqli_query($conn,$sql1); 
}
	  ?>
	  <?php
	  if (isset($_POST['update'])) {
	  	$id =$_POST['id'];
	  	$row=$id;
	  	$campaignName=$_POST['campaignName'];
	  	$campaignType=$_POST['campaignType'];
	  	$campaignDays=$_POST['campaignDays'];
	  	$campaignAmount=$_POST['campaignAmount'];
	  	$campaignDesription=$_POST['campaignDescription'];
	  	$campaignPhone=$_POST['phone'];
	  	$approval='0';
	  	

	  	$sql="UPDATE `campaigns` SET `campaign_name`='$campaignName',`campaign_type`='$campaignType',`campaign_days`='$campaignDays',`campaign_amount`='$campaignAmount',`campaign_description`='$campaignDesription',`campaignPhone`='$campaignPhone', `campaignApproval`='$approval' WHERE campaign_id=$id ";
	  	$result1=mysqli_query($conn,$sql);
	  	if($result1)
	  	{
	  	    echo "<script>alert('Campaign Updated Successfully');</script>";
                echo "<script>document.location ='manage-campaigns.php';</script>";
	  	}

	  }
	  ?>
	  <?php
	  if (isset($_POST['delete'])) {
	  	$id =$_POST['id'];
	  	echo $id;
	  	$row=$id;
	  	$campaignName=$_POST['campaignName'];
	  	echo $campaignName;

	  	$sql="DELETE FROM `campaigns` WHERE campaign_id=$id ";
	  	$result1=mysqli_query($conn,$sql);
	  	if($result1)
	  	{
	  	
	  	    echo "<script>alert('Campaign Deleted Successfully');</script>";
                echo "<script>document.location ='manage-campaigns.php';</script>";
	  	}

	  }

	  ?>
	  
	 
	  
	  
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
      EasyFundss - Edit Campaigns
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
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit/Delete Campaigns</h5>
              </div>
              <div class="card-body">
                  <?php
		while($row= mysqli_fetch_assoc($result1))
          {
          	?>
                <form method="POST" enctype="multipart/form-data">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Campaign Name</label>
                        <input type="text" class="form-control" name="campaignName" placeholder="Name Of Campaign" value="<?php echo $row['campaign_name'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Total Days</label>
                        <input type="text" name="campaignDays" value="<?php echo $row['campaign_days'];?>" class="form-control" placeholder="Number of days,campaign will run" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                          <label>Type Of Campaign</label><br>
                        <select name="campaignType" style="width: -webkit-fill-available ; height: 35px;" required>
                    <option value="<?php echo $row['campaign_type'];?>" selected><?php echo $row['campaign_type'];?></option>
                    <option value="natural disaster">Natural Disasters</option>
                    <option value="social">Social</option>
                    <option value="others">Others</option>  
                </select>
                        
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Estimated Amount (in INR)</label>
                        <input type="text" name="campaignAmount" value="<?php echo $row['campaign_amount'];?>" class="form-control" placeholder="1,00,000" >
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" name="phone" class="form-control" value="<?php echo $row['campaignPhone'];?>" placeholder="99xxxxxxxx">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>About Campaign</label>
                        <textarea class="form-control textarea" value="<?php echo $row['campaign_description'];?>"><?php echo $row['campaign_description'];?></textarea>
                      </div>
                    </div>
                  </div>
                        <input type="hidden" name="id" value="<?php echo $row['campaign_id'];?>">
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                        <center><input type="submit" name="update" value="update">
                        <input type="submit" name="delete" value="Delete">
                </center> 
                    </div>
                  </div>
                </form><?php
	}
	?>
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