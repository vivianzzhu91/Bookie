<?php
    require 'config/config.php';
    if(!isset($_POST['username']) || empty($_POST['username'])
    || !isset($_POST['pass']) || empty($_POST['pass'])){
            $error = "All required Information Is Not Filled Yet.";
          }
    else{
      //open my sql to validate
      
      // DB Connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->errno ) {
            echo $mysqli->error;
            exit();
        }
        //check for existing user 
        $sqlCheck = "SELECT * FROM users WHERE username = '".$_POST['username']."';";
        $results = $mysqli->query($sqlCheck);
        if ( !$results ) {
            echo $mysqli->error;
            exit();
        }
        else{
            //No this user
            if($results->num_rows == 0){
                $_SESSION['logged_in'] = false;
                $_SESSION['logErr'] = "<p class=\"errorM\">This user is not registered.</p> 
                <p class=\"errorM\">Try <a href=\"login.php\">log in</a> 
                or <a href=\"signup.php\">sign up</a> with a different username</p>";
                header('Location:login.php');
            }
            // get the userid and all info
            else{
        
              $row = $results->fetch_assoc();
              $cPass = $row['password'];
              if($cPass == $_POST['pass']){
                
                $userid = $row['user_id'];
                $_SESSION['userid'] = $userid;
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['logErr'] = "";
                header('Location:index.php');
              }
              else{
                  $_SESSION['logged_in'] = false;
                  $_SESSION['logErr'] = "<p class=\"errorM\">PASSWORDS AND USERNAME DO NOT MATCH</p> ";
                  header('Location:login.php');
              }
            
            }
        }
        
        // close the database
        $mysqli->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- stylesheet -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
      integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/user.css" />
    <!-- custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Cute+Font|Muli|Nunito"
      rel="stylesheet"
    />
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Login Page</title>
  </head>
  <body>
    <!-- navbar -->
    <?php require 'nav.php';?>

    <div class="fluid-container">
      <div class="row page">
        <div class="hero-image col-lg-6 col-md-6">
          <img class="halfImg" src="../images/login.jpg" alt="" />
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="center my-4">
            <button class="btn active px-4 py-2 mx-2">
              <a href="login.php">
                Log In
              </a>
            </button>
            <button class="btn inactive px-3 py-2 mx-2">
              <a href="signup.php">
                Sign Up
              </a>
            </button>
          </div>
          <div class="my-4">
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
      integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
      integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
