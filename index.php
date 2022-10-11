<?php
  ob_start();
  include 'PHP/dbconnect.php';
  include 'PHP/readdb.php';
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
  <script src="javascript/scripts.js"></script>
  <link rel="stylesheet" href="CSS/master.css">
</head>


<body>

  <header class="container-fluid p-1">

  </header>


  <main>
    <div class="centerdiv col">
    <div class="row">
      <!-- Use a form for data entery with method post for the php to work :) -->
      <img src="CSS/brightSolid.png" alt="BrightSolid logo" class="mb-3 col">
    </div>

    <div class="row">
      <form action="index.php" method="post" class="bg-dark p-3 col" style="border-radius: 25px;">

        <h2 style="color: white; font-weight: bolder">LOGIN:</h2>

        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>

        <label>Username:</label>
        <input type="text" name="username" placeholder="Username"><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Password"><br> 

        <button class="loginbutton my-1" type="submit">Login</button>

        <?php 
            //Creates the session
            session_start(); 
            //Using my local db file to connect to my db for testing
            include 'PHP/dbconnect.php';
            
            // using post method in the form (important bit) to get data
            if (isset($_POST['username']) && isset($_POST['password'])) {
              // strips away whitespaces in password and username
                function validate($data){
                    $data = trim($data);
                    return $data;
            
                }
                //set username and password to variable
                $username = validate($_POST['username']);
                $password = validate($_POST['password']);
                //if no username, tell them to enter one
                if (empty($username)) {
                    echo "Enter username";
                    exit();
                }
                //if no password, tell them to enter one
                else if(empty($password)){
                    echo "Enter password";
                    exit();
                }
                //if both fields have data
                else{
                  //go into database login table and select everything from username and password rows
                    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
                    //create a query to database
                    $login = mysqli_query($conn, $sql);
                    //if there is data in a row
                    if (mysqli_num_rows($login) === 1) {
                        $row = mysqli_fetch_assoc($login);
                        //compare the username and password entered to the username and password in database to check for match (if match login)
                        if ($row['username'] === $username && $row['password'] === $password) {
                            echo "Logged in! Go to next page";
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['password'] = $row['password'];
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['user_id'] = $row['user_id'];
                            header("Location: dashboard.php");
                            exit();
                        }
                        //if not match, tell them incorrect
                        else {
                            echo "Incorrect username or password";
                            exit();
                        }
                    }
                    //if not match, tell them incorrect
                    else {
                        echo "Incorrect username or password";
                        exit();
                    }
                }
            }

            else {
                exit();
            }
        ?>
      </form>
    </div>
  </div>

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