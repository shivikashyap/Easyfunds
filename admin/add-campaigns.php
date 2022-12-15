<?php include 'includes/config.php' ;?>

<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['admin_username'])==0)
  { 
      echo "<script> alert('Session Expired, Please Login Again!');</script>" ;
      echo "<script type='text/javascript'> document.location ='index.php'; </script>";
}
else{?>
<?php
if(isset($_POST['add_campaign_submit']))
{
    $campaigncreator ="Admin";


    $campaignName = $_POST['campaignName'];
    $campaignType = $_POST['campaignType'];
    $campaignDays = $_POST['campaignDays'];
    $campaignAmount = $_POST['campaignAmount'];
    $campaignDescription = $_POST['campaignDescription'];
    $campaignPhone = $_POST['phone'];
    $campaignApproval = '1';

    // error handling
    if(!preg_match("/^[a-zA-Z'. -]+$/", $campaignName)) 
    {    
        echo "<script>alert('Use Only Letters for name');</script>";
        echo "<script>document.location ='add-campaigns.php';</script>";
        exit();
    } 
    else 
    {
        // check if there is already a campaign with same inputted campaignName by the organizer
        $sql = "SELECT * FROM campaigns WHERE campaign_name = '$campaignName'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
        echo "<script>alert('Campaign Name Already Taken, Try a Unique Name');</script>";
        echo "<script>document.location ='add-campaigns.php';</script>";
        } 
        else 
        {

            // for campaign photo part

            $filename = $_FILES['campaignPhoto']['name'];
            $tempname = $_FILES['campaignPhoto']['tmp_name'];
            $filename = md5($filename.time());
            $campaignImagePath = "assets/images/campaignImages/".$filename;
            
            move_uploaded_file($tempname,$campaignImagePath);

             // insert the input value into database
             $sql = "INSERT INTO campaigns(campaign_name, campaign_type, campaign_days, campaign_amount, campaign_description,campaignPhone,campaignImage,`campaignCreator`,`campaignApproval`) VALUES('$campaignName','$campaignType',$campaignDays,$campaignAmount,'$campaignDescription',$campaignPhone,'$campaignImagePath','$campaigncreator','$campaignApproval');";
             $insertSuccess = mysqli_query($conn, $sql);
// to-do
             // if campaign input data successfully inserted in database then redirect him to success page with link of organizer profile
             if($insertSuccess) 
             {
                echo "<script>alert('Campaign Created Successfully');</script>";
                echo "<script>document.location ='dashboard.php';</script>";;
             } else 
             {
                 echo $conn->error;
             }
        }
    }

}
;?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
      EasyFundss - Add Campaigns
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
                <h5 class="card-title">Add Campaigns</h5>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Campaign Name</label>
                        <input type="text" class="form-control" name="campaignName" placeholder="Name Of Campaign">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Total Days</label>
                        <input type="text" name="campaignDays" class="form-control" placeholder="Number of days,campaign will run" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                          <label>Type Of Campaign</label><br>
                        <select name="campaignType" style="width: -webkit-fill-available ; height: 35px;" required>
                    <option disabled selected>Type of Campaign</option>
                    <option value="natural disaster">Natural Disasters</option>
                    <option value="social">Social</option>
                    <option value="others">Others</option>  
                </select>
                        
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Estimated Amount (in INR)</label>
                        <input type="text" name="campaignAmount" class="form-control" placeholder="1,00,000" >
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" name="phone" class="form-control" placeholder="99xxxxxxxx">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>About Campaign</label>
                        <textarea class="form-control textarea">Write something about your campaign here!</textarea>
                      </div>
                    </div>
                  </div>
                        <span id="campaignImage">Upload an image for campaign : </span>
                        <input type="file" name="campaignPhoto" accept="image/*">
                        <br><br>
                        <input type="checkbox" required><span id="agreeterms"> Agree all terms and conditions</span><br>
                <input type="hidden" name="approval" value="1">
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="add_campaign_submit" class="btn btn-primary btn-round">Add Campaign</button>
                    </div>
                  </div>
                </form>
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