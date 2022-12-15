<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']!=''){
$_SESSION['alogin']='';
}
if(isset($_POST['login']))
{
 //code for captach verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
else
{
$username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM adminlogin WHERE admin_username='$username' AND admin_password='$password'";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck == 1)
{
    $_SESSION['admin_username'] = $_POST['username'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} 
else
{
echo "<script>alert('Invalid Details');</script>";
}
}
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyFundss | Admin Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
  <body>
    <div id="app">
        <div class="auth-layout">
            <div class="nav hidden-lg-up">
                <a href="#/" class="basix-home open active"></a>
            </div> 
            <div class="main row">
                <div class="auth-content col-md-6">
                    <div data-v-06c1e12c="" class="login">
                        <div data-v-e1a7d39c="" data-v-06c1e12c="" class="card">
                            <div data-v-e1a7d39c="" class="card-header"><!----> 
                                <strong data-v-e1a7d39c="" class="card-title">Welcome !</strong> <!---->
                            </div> 
                            <div data-v-e1a7d39c="" class="card-body">
                                <div data-v-06c1e12c="" data-v-e1a7d39c="" class="card-body card-block">
                                    <form role="form" method="post">
                                        <div data-v-06c1e12c="" data-v-e1a7d39c="" class="form-group">
                                            <div data-v-06c1e12c="" data-v-e1a7d39c="" class="input-group">
                                                <div data-v-06c1e12c="" data-v-e1a7d39c="" class="input-group-addon">
                                                    <i data-v-06c1e12c="" data-v-e1a7d39c="" class="fa fa-envelope"></i>
                                                </div> 
                                                <input data-v-06c1e12c="" data-v-e1a7d39c="" type="text" id="username" name="username" placeholder="Username" class="form-control">
                                            </div>
                                        </div> 
                                        <div data-v-06c1e12c="" data-v-e1a7d39c="" class="form-group">
                                            <div data-v-06c1e12c="" data-v-e1a7d39c="" class="input-group">
                                                <div data-v-06c1e12c="" data-v-e1a7d39c="" class="input-group-addon">
                                                    <i data-v-06c1e12c="" data-v-e1a7d39c="" class="fa fa-asterisk"></i>
                                                </div> 
                                                <input data-v-06c1e12c="" data-v-e1a7d39c="" type="password" id="password" name="password" placeholder="Password" class="form-control">
                                            </div>
                                        </div> 
                                        <div class="form-group">
<label>Verification code : </label>
<input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
</div>
                                        <div data-v-06c1e12c="" data-v-e1a7d39c="" class="form-actions form-group">
                                            <button data-v-06c1e12c="" data-v-e1a7d39c="" type="submit" class="btn btn-success btn-md" name="login">Log In</button> 
                                            
                                        </div>
                                    </form>
                                </div>
                            </div> <!---->
                        </div>
                    </div>
                </div> 
                <div class="auth-wallpaper col-md-6 hidden-md-down">
                    <div class="oblique"></div> 
                    <a href="#/" class="basix-home open active">
                        <img src="assets/images/logo.png" alt="Logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>