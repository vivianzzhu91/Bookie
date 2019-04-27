<?php
  require 'config/config.php';
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
    <title>Signup Page</title>
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
            <button class="btn inactive px-4 py-2 mx-2">
              <a href="login.php">
                Log In
              </a>
            </button>
            <button class="btn active px-3 py-2 mx-2">
              <a href="signup.php">
                Sign Up
              </a>
            </button>
          </div>
          <div class="my-4 formdata">
            <form class="my-4" id="signupForm" method="POST" action="signupConfirm.php">
              <div class="form-group my-3">
                <label for="username" class="my-3">USERNAME</label>
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  placeholder="Type Your Username"
                  name="username"
                />
              </div>
              <div class="form-group my-3">
                <label for="pass" class="my-3">PASSWORD</label>
                <input
                  type="password"
                  class="form-control"
                  id="pass"
                  placeholder="Give Your Password"
                  name="password"
                />
              </div>
              <div class="form-group my-3">
                <label for="repass" class="my-3">CONFIRM PASSWORD</label>
                <input
                  type="password"
                  class="form-control"
                  id="repass"
                  placeholder="Confirm Your Password"
                />
              </div>
              <div class="my-3">
                <p>NOTICE: MAKE SURE YOUR USENAME IS NOT TAKEN</p>
                <p>PASSWORDS MUST MATCH</p>
                <div class="warning">
                  <?php if(isset($_SESSION['signErr'])||!empty($_SESSION['signErr'])): ?>
                      <?php echo $_SESSION['signErr'];?>
                  <?php endif;?>
                </div>
              </div>
              <button class="btn submitBut py-4 mt-4" type="submit">
                Begin Journey
              </button>
            </form>
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
    <script src="../js/signup.js"></script>
  </body>
</html>
