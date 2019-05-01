<?php
require 'config/config.php';
if (
    isset($_GET['title']) && !empty($_GET['title'])
    || isset($GET['author']) && !empty($_GET['author'])
) {

    
    $title = $_GET['title'];
    $author = $_GET['author'];
    //What's their endpoint?
    define('GOOGLE_BOOKS_API', 'https://www.googleapis.com/books/v1/volumes');
    if($author == 'No Author'){
        $url = GOOGLE_BOOKS_API . "?q=" . $title . "&key=AIzaSyCa7VNQhw7vHTefuAK67TNcj_gpUWnshQs&orderBy=relevance&maxResults=1";
    }
    else{
        $url = GOOGLE_BOOKS_API . "?q=" . $title . "+inauthor:" . $author . "&key=AIzaSyCa7VNQhw7vHTefuAK67TNcj_gpUWnshQs&orderBy=relevance&maxResults=1";
    }
    //replace all white space
    $newUrl = str_replace(' ','+',$url);
    
    //use curl to retrieve info of the book
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $newUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    //convert json file to php assoc array
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response,true);
    $book = $response['items'][0];
    
    //retrieve all display info
    $title = $book['volumeInfo']['title'];
    $author = $book['volumeInfo']['authors'][0];
    $publisher = $book['volumeInfo']['publisher'];
    $descript = $book['volumeInfo']['description'];
    $descript = str_replace('\\','', $descript);
    $image = $book['volumeInfo']['imageLinks']['thumbnail'];
    $googlelink = $book['accessInfo']['webReaderLink'];
    $amazonlink = $_GET['l'];
    
    //check rating
    if(array_key_exists('averageRating', $book['volumeInfo'])){
        $rating = $book['volumeInfo']['averageRating'];
        $count = $book['volumeInfo']['ratingsCount'];
    }
    else{
        $noRating = 'Rating Currently Unavailable';
    }
    
    if(array_key_exists('imageLinks', $book['volumeInfo'])){
        $imageUrl = $book['volumeInfo']['imageLinks']['thumbnail'];
    }
    else{
        $imageUrl = '../images/warning.jpg';
    }
    
    if(array_key_exists('industryIdentifiers', $book['volumeInfo'])){
        $isbn = $book['volumeInfo']['industryIdentifiers'][1]['identifier'];
    }
    else{
        $isbn = "NO ISBN AVAILABLE";
    }

    if(array_key_exists('publishedDate', $book['volumeInfo'])){
        $date = $book['volumeInfo']['publishedDate'];
    }
    else{
        $date = "NO DATE";
    }

    //alert add in message and clear
    if(isset($_SESSION['favM']) && !empty($_SESSION['favM'])){
        echo "<script type='text/javascript'>alert('".$_SESSION['favM']."');</script>";
        $_SESSION['favM'] = "";
    }
    //alert remove message and clear
    if(isset($_SESSION['removeM']) && !empty($_SESSION['removeM'])){
        echo "<script type='text/javascript'>alert('".$_SESSION['removeM']."');</script>";
        $_SESSION['removeM'] = "";
    }
    $hasUser = false;
    $inFav = false;
    $userFavid = 0;
    //check if the book's in user's fav
    if(isset($_SESSION['logged_in'])&& $_SESSION['logged_in'] == true){
        $hasUser = true;
        //DB connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->errno ) {
            echo $mysqli->error;
            exit();
        }
        //find the book id with given info
        $sqlCheck = "SELECT * FROM books WHERE title ='".$title."' AND author ='".$author."' AND date = '".$date."'";
        $results = $mysqli->query($sqlCheck);
        if ( !$results ) {
          echo $mysqli->error;
          exit();
        }
        
        //book in browse history
        if($results->num_rows > 0){
            $row = $results->fetch_assoc();
            $bookid = $row['book_id'];
    
            //find the usr_fav id
            $sqlCheck = "SELECT * FROM user_favs WHERE book_id = ". $bookid . " AND user_id = ".$_SESSION['userid'];
            $results = $mysqli->query($sqlCheck);
            if ( !$results ) {
                echo $mysqli->error;
                exit();
            }
            //already in favs
            if($results->num_rows > 0){
                $inFav = true;
                $row = $results->fetch_assoc();
                $userFavid = $row['user_favs_id'];
            }
            else{
                $inFav = false;
            }
        }
        //book not in browse history, insert it into books
        else{
            //insert into the book table
            $sqlCheck = "INSERT INTO books(title,author,date)
            VALUES('".$title."', '".$author."','".$date."')";
            $results = $mysqli->query($sqlCheck);
            if ( !$results ) {
                echo $mysqli->error;
                exit();
            }
        }

        // close the database
        $mysqli->close();

    }
    else{
        $hasUser = false;
    }

} else {
    $error = "No Such Detail Page For This Book. Try Valid Input.";
}


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/detail.css">
    <!-- custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Cute+Font|Muli|Nunito|Lobster|Gugi" rel="stylesheet">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Detail page of a book</title>
</head>

<body>
    <!-- navbar -->
    <?php require 'nav.php'; ?>

    <div class="fluid-container">
        <!-- error message -->
        <?php if (isset($error) || !empty($error)) : ?>
            <div id="error" class="my-4">
                <h2> <?php echo $error ?></h2>
            </div>
        <?php else : ?>
            <!-- book detail -->
            <div id="detail" class="py-4 px-4">
                <div class="row">
                    <div class="col-lg-5">
                        <img src="<?php echo $imageUrl;?>" alt="" 
                            id="bookCover">
                    </div>
                    <div class="col-lg-7">
                        <div class="sect">
                            <!-- fav icon -->
                            <?php if ($hasUser == false || $inFav == false):?>
                                <h3 id="title"><?php echo $title ?> <i class="far fa-heart mx-2 fav" id="addFav"></i></h3>
                            <?php else:?>
                                <h3 id="title"><?php echo $title ?> <i class="fas fa-heart mx-2 fav" id="removeFav"></i></h3>
                            <?php endif;?>

                            <h5 id="author">Author: <?php echo $author?></h5>
                            <p>Publisher: <?php echo $publisher?></p>
                            <p>Date: <?php echo $date?></p>
                            <?php if(isset($noRating)&& !empty($noRating)):?>
                                <p><?php echo $noRating?></p>
                            <?php else:?>
                                <p>Rating: <?php echo $rating ?>/5.0(<?php echo $count ?> counts)</p>
                            <?php endif;?>
                            <p>ISBN: <?php echo $isbn;?></p>
                            <div class="row my-4">
                                <div class="col-lg-3 link">
                                    <a href="<?php echo $googlelink?>" target="_blank">View On Google</a>
                                </div>
                                <div class="col-lg-3 link">
                                    <a href="<?php echo $amazonlink?>" target="_blank">View On Amazon</a>
                                </div>
                            </div>
                            <p>Description: </p>
                            <p><?php echo $descript?></p>
                            <form method="POST" action="addFav.php" id="addForm">
                                <input type="hidden" value="<?php echo $title?>" name="title">
                                <input type="hidden" value="<?php echo $author?>" name="author">
                                <input type="hidden" value="<?php echo $date?>" name="date">
                            </form>
                            <form method="POST" action="removeFav.php" id="removeForm">
                                <input type="hidden" value="<?php echo $title?>" name="title">
                                <input type="hidden" value="<?php echo $author?>" name="author">
                                <input type="hidden" value="<?php echo $userFavid?>" name="userFavid">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script>
        $("#addFav").click( () => {
            $("#addForm").submit();
        });
        $("#removeFav").click( () => {
            $("#removeForm").submit();
        });
    </script>
</body>

</html>