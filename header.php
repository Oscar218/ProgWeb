<?php
/*
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
*/
require 'tchck.php';
//require 'database.php';
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    
    <style type="text/css">
        body{ 
		background-color:#2ecc71;
		font: 10px sans-serif;
		 #text-align: center;}
	</style>
</head>
<body>

<div class="page-header">
       <h3>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>. Welcome.</h3>
        <a href="index.php" class="btn btn-danger">HOME</a>
        <a href="view.php" class="btn btn-danger">View_Entradas</a>
        <a href="create.php" class="btn btn-warning">Create</a>
        <a href="calendario.php" class="btn btn-danger">Calendario</a>
        <a href="reset-password.php" class="btn btn-warning"> Reset_Pass </a>
        <a href="logout.php" class="btn btn-danger">Sign Out</a>
</div>
  </body>
</html>