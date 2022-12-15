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
    $username = mysqli_real_escape_string($conn, $_POST['username']); //$username can either be username or email
    $password = mysqli_real_escape_string($conn, $_POST['password']);//user prepared statement instead of this

    //error handling: check if username exits in database
    $sql = "SELECT * FROM organizers WHERE organizer_username='$username' OR organizer_email='$username';";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck < 1) { //if no such record in database
        echo "<script>alert('User not found');</script>";
        echo "<script type='text/javascript'> document.location ='login.php'; </script>";
    } else {
        // check for correct password
        if($row = mysqli_fetch_assoc($result)) {
            // DE-HASHING the password
            $hashedPasswordCheck = password_verify($password, $row['organizer_password']);
            if($hashedPasswordCheck == false) {
                echo "<script>alert('Wrong Password');</script>";
        echo "<script type='text/javascript'> document.location ='login.php'; </script>";
                exit();
            } elseif($hashedPasswordCheck == true) {
                // login the user here
                //session variables
                $_SESSION['o_id'] = $row['organizer_id'];
                $_SESSION['o_fullname'] = $row['organizer_fullname'];
                $_SESSION['o_username'] = $row['organizer_username'];
                $_SESSION['o_email'] = $row['organizer_email'];
                $_SESSION['o_phone'] = $row['organizer_phone'];

                $date = $row['organizer_reg_date'];
                $date = strtotime($date);
                $date = date('M D Y',$date); //show date in nice form

                $_SESSION['o_date'] = $date;
                 
                $verified = $row['verified'];
                if($verified == 1) {
                    echo "<script>alert('Correct username and password');</script>";
                    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
                } else {
                    echo "<script>alert('This account has not been yet verified. An email was sent to your email,kindly check it,if not found, check spam');</script>";
                    echo "<script type='text/javascript'> document.location ='login.php'; </script>";
                }

                
            }
        }
    }
}
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyFundss | Organizer's Login</title>
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
                                            <button data-v-06c1e12c="" data-v-e1a7d39c="" type="submit" class="btn btn-primary btn-md float-right">
                                                <a data-v-06c1e12c="" href="register.php" class="link text-light float-right" data-v-e1a7d39c="">Create Account</a>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!---->
                        </div>
                    </div>
                </div> 
                <div class="auth-wallpaper col-md-6 hidden-md-down">
                    <div class="oblique"></div> 
                    <a href="index.php" class="basix-home open active">
                        <img src="assets/images/logo.png" alt="Logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>