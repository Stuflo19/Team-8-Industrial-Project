<?php
  include 'dbconnect.php';
  include 'readdb.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

<meta charset="utf-8">


  <!-- import viewport properties -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- import bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> 
  <!-- import css file -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="scripts.js"></script>
  <link rel="stylesheet" href="master.css">
</head>


<body onload ="generateGraph(<?php echo count($non_compliant_ids)?> , <?php echo mysqli_num_rows($result)?>)">

  <header class="container-fluid p-1">

  </header>


  <main>

  <img src="brightSolid.png" alt="BrightSolid logo" style=" text_align = centre;">



  

  <form>
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="username" id="loginuser" name="loginuser" class="form-control" />
    <label class="form-label" for="loginuser">Username</label>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" id="loginpassword" name="loginpassword" class="form-control" />
    <label class="form-label" for="loginpassword">Password</label>
  </div>

  <!-- Submit button -->
  <button type="Submit" value="Login" class="btn btn-primary btn-block mb-4">Sign in</button>

  <?php 
include("dbconnect.php");

if(isset($_POST['sub']))
{
$user_name = $_POST['loginuser'];

$res = mysqli_query($mysqli,"SELECT* from user where 'loginuser'='$user_name'");
$result=mysqli_fetch_array($res);
if($result)
{
echo "You are login Successfully ";
header("location:dashboard.php"); 
	
}
else
{
	echo "failed ";
}
}
?>

</form>

  </main>

  <!-- Footer -->
  <footer>
   
  </footer>
  <!-- import bootstrap JS, Popper.js, and jQuery  -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="web-app/registerSW.js"></script>
  

</body>


<?php
  $conn->close();
?>