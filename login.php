<?php
  include 'dbconnect.php';
  include 'readdb.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
 
</head>


<body onload ="generateGraph(<?php echo count($non_compliant_ids)?> , <?php echo mysqli_num_rows($result)?>)">

  <header class="container-fluid p-1">

  </header>


  <main>

  <img src="brightSolid.jpg" alt="BrightSolid logo">


  <form>
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="username" id="loginuser" class="form-control" />
    <label class="form-label" for="loginuser">Username</label>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" id="loginpassword" class="form-control" />
    <label class="form-label" for="loginpassword">Password</label>
  </div>

  <!-- Submit button -->
  <button type="button" class="btn btn-primary btn-block mb-4">Sign in</button>
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