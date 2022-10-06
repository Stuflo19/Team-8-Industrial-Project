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


<body>

  <header class="container-fluid p-1">

  </header>


  <main>

  <img src="brightSolid.png" alt="BrightSolid logo" style=" text_align = centre;">



  

     <!-- Use a form for data entery with method post for the php to work :) -->
     <form action="index.php" method="post">

        <h2>LOGIN</h2>

        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>

        <label>User Name</label>

        <input type="text" name="user_name" placeholder="User Name"><br>

        <label>Password</label>

        <input type="password" name="password" placeholder="Password"><br> 

        <button type="submit">Login</button>
        
        <?php 
            //Creates the session
            session_start(); 
            //Using my local db file to connect to my db for testing
            include 'dbconnect.php';
            // using post method in the form (important bit) to get data
            if (isset($_POST['user_name'])) {
              // strips away whitespaces in password and user_name
                function validate($data){
                    $data = trim($data);
                    return $data;
            
                }
                //set user_name and password to variable
                $user_name = validate($_POST['user_name']);
                //if no user_name, tell them to enter one
                if (empty($user_name)) {
                    echo "Enter user_name";
                    exit();
                }
                //if both fields have data
                else{
                  //go into database login table and select everything from user_name and password rows
                    $sql = "SELECT * FROM user WHERE user_name='$user_name'";
                    //create a query to database
                    $result = mysqli_query($conn, $sql);
                    //if there is data in a row
                    if (mysqli_num_rows($result) === 1) {
                        $row = mysqli_fetch_assoc($result);
                        //compare the user_name and password entered to the user_name and password in database to check for match (if match login)
                        if ($row['user_name'] === $user_name) {
                            echo "Logged in! Go to next page";
                            $_SESSION['user_name'] = $row['user_name'];
                            $_SESSION['user_id'] = $row['user_id'];
                            header('location: dashboard.php')
                            exit();
                        }
                        //if not match, tell them incorrect
                        else {
                            echo "Incorrect user_name or password";
                            exit();
                        }
                    }
                    //if not match, tell them incorrect
                    else {
                        echo "Incorrect user_name or password";
                        exit();
                    }
                }
            }

            else {
              echo "no";
                exit();
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