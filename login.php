<!-- RANDOM WEBPAGBE TEMPLATE FOUND ONLINE FOR TESTING NEED TO MAKE ONE FOR WEBAPP-->
<!DOCTYPE html>

<html>

<head>

    <title>LOGIN</title>

    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
      <!-- Use a form for data entery with method post for the php to work :) -->
     <form action="login.php" method="post">

        <h2>LOGIN</h2>

        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>

        <label>User Name</label>

        <input type="text" name="username" placeholder="User Name"><br>

        <label>Password</label>

        <input type="password" name="password" placeholder="Password"><br> 

        <button type="submit">Login</button>
        
        <?php 
            //Creates the session
            session_start(); 
            //Using my local db file to connect to my db for testing
            include 'dbconnecttest.php';
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
                    $result = mysqli_query($conn, $sql);
                    //if there is data in a row
                    if (mysqli_num_rows($result) === 1) {
                        $row = mysqli_fetch_assoc($result);
                        //compare the username and password entered to the username and password in database to check for match (if match login)
                        if ($row['username'] === $username && $row['password'] === $password) {
                            echo "Logged in! Go to next page";
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['password'] = $row['password'];
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['user_id'] = $row['user_id'];
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
              echo "no";
                exit();
            }
        ?>
     </form>

     
</body>

</html>