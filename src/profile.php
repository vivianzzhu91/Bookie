<?php
  require 'config/config.php';
  if(isset($_GET['i']) && !empty($_GET['i'])){
    
    //DB connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->errno ) {
        echo $mysqli->error;
        exit();
    }
    //check current user in users
    $sqlCheck = "SELECT * FROM users WHERE user_id=".$_GET['i'];
    $results = $mysqli->query($sqlCheck);
    if ( !$results ) {
      echo $mysqli->error;
      exit();
    }
    if($results->num_rows == 0){
      $error = "No Existing User Info";
    }
    else{
      //get user_favs from userid
      //find the book id with given info
      $sqlCheck = "SELECT * FROM user_favs 
      JOIN books
        ON user_favs.book_id = books.book_id
      WHERE user_id=".$_GET['i'];
      $results = $mysqli->query($sqlCheck);
      if ( !$results ) {
        echo $mysqli->error;
        exit();
      }
      if($results->num_rows == 0){
        $status = "No Favorites Yet";
      }
  
      //check results
      $noFavs = "";
      if($results->num_rows == 0){
        $noFavs = "Currently No Favorites";
      }
    }
    // close the database
    $mysqli->close();
  }
  else{
    $error = "No Existing User Profile";
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
    <link rel="stylesheet" href="../css/profile.css" />
    <!-- custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Cute+Font|Muli|Nunito|Lobster|Gugi"
      rel="stylesheet"
    />
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>User Favorites Page</title>
  </head>
  <body>
    <!-- navbar -->
    <?php require 'nav.php'; ?>
    
    <!-- cover -->
    <div class="fluid-container">
      <?php if(isset($error) && !empty($error)):?>
        <h2 class="error py-4"><?php echo $error?></h2>
      <?php else:?>
        <div id="profile">
          <p class="center pt-4 mb-2">Hello <span class="username"><?php echo $_SESSION['username'];?></span></p>
          <p class="rec">Here's Your Favorite Bookies</p>
          <?php if(isset($status) && !empty($status)):?>
            <p class='center pt-2 mb-2'><?php echo $status;?></p>
          <?php else:?>
            <ul class="results pb-4 mr-3">
              <div class="row">
                <?php while($row = $results->fetch_assoc()):?>
                <div class="col-lg-9">
                    <div class="list">
                      <a href="detail.php?title=<?php echo $row['title']?>&author=<?php echo $row['author']?>&l=https://www.amazon.com/s?k=<?php echo $row['title'];?>">
                        <li class="my-2 mx-2">
                          <h4><?php echo $row['title']?> By <?php echo $row['author']?> <?php echo $row['date']?></h4>
                        </li>
                      </a>
                    </div>
                  </div>
                <div class="col-lg-3">
                    <div>
                      <h5 class="py-4 px-2"><?php echo $row['time'];?></h5>
                    </div>
                  </div>
                <?php endwhile;?>
              </div>
            </ul>
          <?php endif;?>
        </div>
      <?php endif;?>
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
