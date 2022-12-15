<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']!=''){
$_SESSION['alogin']='';
}
if(isset($_POST['submit']))
{
 //code for captach verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
else
{
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // for email verification: generate vkey
    $vkey = md5(time().$username); //will generate a random verification string key

    // check if the input characters are valid
    if(!preg_match("/^[a-zA-Z'. -]+$/", $fullname)) { 
        
            echo "<script>alert('Invalid Name');</script>";
                echo "<script type='text/javascript'> document.location ='register.php'; </script>";
    } else {
        // check if there is already a username with same inputted data by new user
        $sql = "SELECT * FROM organizers WHERE organizer_username = '$username'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            echo "<script>alert('sorry, username has been taken, kindly try again with another username');</script>";
                echo "<script type='text/javascript'> document.location ='register.php'; </script>";
        } else {
            // password hashing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // insert the organizer into database
            $sql = "INSERT INTO organizers(organizer_fullname, organizer_username, organizer_email, organizer_password, organizer_phone, vkey) VALUES('$fullname','$username','$email','$hashedPassword','$phone','$vkey');";
            $insertSuccess = mysqli_query($conn, $sql);
            // if signup data successfully inserted in database then send email to him for verification using vkey

            if($insertSuccess) {
                // send mail
                $url = "https://".$url."/includes/emailverification.php?vkey=".$vkey;
                $to = $email;
                $subject = 'Email Verification';
                $message = '<p>You can verify the email from the link below:</br>';
                $message .= '<a href="' .$url. '">Verify Email</a></p>';

                $headers = "From: Easyfunds <mrmananraj34@gmail.com>\r\n";
                $headers .= "Reply-To: mrmananraj34@gmail.com\r\n";
                $headers .= "Content-type: text/html\r\n"; //to make the html work in email

                mail($to, $subject, $message, $headers);
                
                echo "<script>alert('Account Accepted,you will receive an email with verification link,kindly verify your email through that and login through username and password');</script>";
                echo "<script type='text/javascript'> document.location ='login.php'; </script>";
                
            } else {
                echo $conn->error;
            }        
        }
    }
    
    
    
    
    
    
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
                                        <label>Full Name :</label>
                                        <input type="text" name="fullname" placeholder="Enter full Name" required><br><br>
                                        <label>Username :</label>
                                        <input type="text" name="username" placeholder="username" pattern="[A-Za-z0-9]+" title="Username should only contain letters and numbers only. e.g. john12345" required><br><br>
                                        <label>Email :</label>
                                        <input type="email" name="email" placeholder="E-mail" required><br><br>
                                        <label>Password :</label>
                                        <input type="password" id = "password" name="password" placeholder="password" required><br><br>
                                        <label>Confirm Password :</label>
                                        <input type="password" id="repeat-password" name="repeat-password" placeholder="Confirm password" required><br><br>
                                        <label>Phone Number :</label>
                                        <input type="tel" name="phone" placeholder="Phone: 98********" pattern="[0-9]{10}" required><br><br>
                                        <input type="checkbox" name="" required><span id="agreeterms"> Agree all terms and conditions</span><br>
                                        
                                        <div class="form-group">
                                        <label>Verification code : </label>
                                            <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
                                        </div>
                                        <input type="submit" name="submit" value="Register Now" id="submit"><br>
                                        <div data-v-06c1e12c="" data-v-e1a7d39c="" class="form-actions form-group">
                                            <br><button data-v-06c1e12c="" data-v-e1a7d39c="" type="submit" class="btn btn-primary btn-md float-right">
                                                <a data-v-06c1e12c="" href="login.php" class="link text-light float-right" data-v-e1a7d39c="">Already Have an account? Login</a>
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
                    <a href="#/" class="basix-home open active">
                        <img src="assets/images/logo.png" alt="Logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>