<?php
    if(!isset($_POST['username']) || empty($_POST['username']) 
    || !isset($_POST['password']) || empty($_POST['password'])){
      $error = "You Didn't Submit Any Registration Information";
    }
    else{
      //open my sql to validate
      require 'config/config.php';
        
        // DB Connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->errno ) {
            echo $mysqli->error;
            exit();
        }
        //check for duplicate key before inserting
        $sqlCheck = "SELECT * FROM users WHERE username = '".$_POST['username']."';";
        $results = $mysqli->query($sqlCheck);
        if ( !$results ) {
            echo $mysqli->error;
            exit();
        }
        else{
            //duplicate username
            if($results->num_rows > 0){
                $_SESSION['signErr'] = "<p class=\"errorM\">This user is already in taken.</p> 
                        <p class=\"errorM\">Try <a href=\"login.php\">log in</a> 
                        or <a href=\"signup.php\">sign up</a> with a different username</p>";
                $_SESSION['logged_in'] = false;
                header('Location:signup.php');
            }
            //insert the new user into the user table
            else{
        
                $sql = "INSERT INTO users(username, password)
                        VALUES('". $_POST['username'] ."','".$_POST['password']."');";
                $results = $mysqli->query($sql);
                if ( !$results ) {
                    echo $mysqli->error;
                    exit();
                }
                //get the user id
                $sqlCheck = "SELECT * FROM users WHERE username ='".$_POST['username']."'";
                $results = $mysqli->query($sqlCheck);
                if ( !$results ) {
                  echo $mysqli->error;
                  exit();
                }
                $row = $results->fetch_assoc();
                $userid = $row['user_id'];
                $_SESSION['userid'] = $userid;                
                $_SESSION['signErr'] = "";
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $_POST['username'];
                header('Location:index.php');

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
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Cute+Font|Muli|Nunito"
      rel="stylesheet"
    />
    <title>Signup Confirmation Page</title>
  </head>
  <body>
    <?php require 'nav.php'; ?>

    <div class="fluid-container">
      <div class="row page">
        <div class="hero-image col-lg-6 col-md-6">
          <img class="halfImg" src="../images/signup.jpg" alt="" />
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="center my-4">
            <?php if(isset($error) && !empty($error)): ?>
                <?php echo $error?>
            <?php else :?>
                <?php echo "<p class=\"successM\">Hello, " . $_POST['username'] . "</p>"?>
                <?php echo "<p class=\"successM\">You successfully registered an account. </p>" ?>
            <?php endif;?>
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
