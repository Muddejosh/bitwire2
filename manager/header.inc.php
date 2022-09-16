<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tracknet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body{
            background: Gainsboro;
        }
        .wrapper{
            border-top:20px solid powderblue;
            width: 1000px; 
            margin: 0 auto;
            background:white;
            /* height: 400px;; */
            margin-top:60px;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <?php
if (isset($_SESSION['username'])) {

     echo "<nav class='navbar navbar-light bg-light'>
     <div class='container-fluid'>
       <a class='navbar-brand' href='#'>"."<div class='h6'>Welcome <span class='text-success'>" . $_SESSION['username'] ."!</span></div>";  

     echo "<i class='bi bi-emoji-smile-fill'></i>"."<a href='../login/logout.php'>Logout</a>"."</a>
     </div>
   </nav>" ;}
    ?>

    <div class="wrapper container shadow-lg p-3 mb-5 bg-white rounded" >