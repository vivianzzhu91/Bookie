<?php
  require 'config/config.php';
  //check loggedin userinfo
  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    //check required info
    if(isset($_POST['title']) && !empty($_POST['title'])
      && isset($_POST['author']) && !empty( $_POST['author'])){
        //DB connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->errno ) {
            echo $mysqli->error;
            exit();
        }

        //find the book id with given info
        $sqlCheck = "SELECT * FROM books WHERE 
          title ='".$_POST['title']."' AND author ='".$_POST['author']."' AND date ='".$_POST['date']."'";
        $results = $mysqli->query($sqlCheck);
        if ( !$results ) {
          echo $mysqli->error;
          exit();
        }
        $row = $results->fetch_assoc();
        $bookid = $row['book_id'];

        //insert into the user_fav table
        $sqlAdd = "INSERT INTO user_favs(book_id,user_id)
          VALUES('".$bookid."', '".$_SESSION['userid']."')";
        $results = $mysqli->query($sqlAdd);
        if ( !$results ) {
          echo $mysqli->error;
          exit();
        }

        $_SESSION['favM'] = 'Add In Favorites Successful!';
        header('Location:detail.php?title='.$_POST['title'].'&author='.$_POST['author'].'&l=https://www.amazon.com/s?k='.$_POST['title']);
        // close the database
        $mysqli->close();
    }
    else{
      //redirect back to detail page and alert box
      $_SESSION['favM'] = 'Unable To Add Favorites. Missing Info';
      header('Location:detail.php?title='.$_POST['title'].'&author='.$_POST['author'].'&l=https://www.amazon.com/s?k='.$_POST['title']);
    }
  }
  else{
    //redirect back to sign up page
    header('Location:signup.php');
  }
?>