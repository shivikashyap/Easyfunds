<?php

if(isset($_GET['vkey'])) {

    $vkey = $_GET['vkey'];
    include 'config.php';
    $sql = "SELECT vkey,verified FROM organizers WHERE verified = 0 AND vkey = '$vkey' LIMIT 1"; //limit 1 means to return only 1 result
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck == 1) { 
        //validate the email and update the table
        $sql = "UPDATE organizers SET verified = 1 WHERE vkey = '$vkey' LIMIT 1";
        $updated = mysqli_query($conn,$sql);
        if($updated) {
            echo "<script>alert('Email Verified Successfully');</script>";
                    echo "<script type='text/javascript'> document.location ='../login.php'; </script>";
        } else {
            echo $conn->error;
        }
    } else {
        echo "<script>alert('Invalid email or Authentication email has been done. Kindly login from login page');</script>";
                    echo "<script type='text/javascript'> document.location ='../login.php'; </script>";
    }
} else {
     echo "<script>alert('You are not allowed to access this page');</script>";
                    echo "<script type='text/javascript'> document.location ='../index.php'; </script>";
}