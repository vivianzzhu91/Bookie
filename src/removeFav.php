<?php
  require 'config/config.php';

  //check required info
  if(isset($_POST['userFavid']) && !empty($_POST['userFavid'])
    || isset($_POST['title']) && !empty($_POST['title'])
    || isset($_POST['author']) && !empty($_POST['author'])){
    
    //DB connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->errno ) {
        echo $mysqli->error;
        exit();
    }

    //delete the fav history with given fav_id
    $sqlCheck = "DELETE FROM user_favs WHERE user_favs_id = ". $_POST['userFavid'] ;
    $results = $mysqli->query($sqlCheck);
    if ( !$results ) {
      echo $mysqli->error;
      exit();
    }

    //redirect back to detail page and alert box
    $_SESSION['removeM'] = 'Successfully remove the book from favs';
    header('Location:detail.php?title='.$_POST['title'].'&author='.$_POST['author'].'&l=https://www.amazon.com/s?k='.$_POST['title']);

    // close the database
    $mysqli->close();

  }
  else{
    //redirect back to detail page and alert box
    $_SESSION['removeM'] = 'Unable To Add Favorites. Missing Info';
    header('Location:detail.php?title='.$_POST['title'].'&author='.$_POST['author'].'&l=https://www.amazon.com/s?k='.$_POST['title']);
  }

?>