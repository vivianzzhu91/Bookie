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
    <!-- custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Cute+Font|Muli|Nunito|Lobster|Gugi"
      rel="stylesheet"
    />
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Homepage</title>
  </head>
  <body>
    <!-- navbar -->
    <?php require 'nav.php'; ?>
    
    <!-- cover -->
    <div class="fluid-container">
      <div class="cover">
        <div class="jumbotron">
          <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
              <?php if(!isset($_SESSION['logged_in'])|| empty($_SESSION['logged_in']) 
                || $_SESSION['logged_in'] == false):?>
                <h1 class="display-4 title">Hello Bookies</h1>
              <?php else:?>
                <h1 class="display-4 title">Hello <?php echo $_SESSION['username']?></h1>
              <?php endif;?>
              <p class="lead"></p>
              <hr class="my-4" />
              <h5>Welcome to the world filled with books.</h5>
              <h5>
                The creator of this website, ME, is a book lover and constantly
                worried about discovering meaningful books. Hope you could find
                what you want.
              </h5>
              <div class="text-center">
                <p class="lead my-4">
                  <?php if(!isset($_SESSION['logged_in'])|| empty($_SESSION['logged_in']) 
                  || $_SESSION['logged_in'] == false):?>
                    <a
                      class="btn signUpBut btn-lg"
                      href="signup.php"
                      role="button"
                      >Get Started
                    </a>
                  <?php else:?>
                    <a
                      class="btn signUpBut btn-lg"
                      href="profile.php"
                      role="button"
                    >See Favorites
                    </a>
                  <?php endif;?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="result">
        <div id="subtitle"></div>
        <ul id="rec"></ul>
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
    <script src="../js/index.js"></script>
  </body>
</html>
