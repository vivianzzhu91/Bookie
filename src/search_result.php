<?php
    require 'config/config.php';
    if(!isset($_GET['search']) || empty($_GET['search'])){
      $error="Error with search input";
    }
    else{
      $title = $_GET['search'];
      //What's their endpoint?
      define('GOOGLE_BOOKS_API', 'https://www.googleapis.com/books/v1/volumes');
      $url = GOOGLE_BOOKS_API . "?q=" . $title . "&key=AIzaSyCa7VNQhw7vHTefuAK67TNcj_gpUWnshQs&orderBy=relevance&maxResults=10";
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
      $books = $response['items'];
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
    <link rel="stylesheet" href="../css/search.css" />
    <!-- custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Cute+Font|Muli|Nunito|Lobster|Gugi"
      rel="stylesheet"
    />
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Search Result Page</title>
  </head>
  <body>
    <!-- navbar -->
    <?php require 'nav.php'; ?>
    
    <!-- cover -->
    <div class="fluid-container">
      <?php if(isset($error) && !empty($error)):?>
        <h2 class="error py-4"><?php echo $error?></h2>
      <?php else:?>
        <div id="result">
          <div id="subtitle"><h4>Display <?php echo sizeof($books)?> result(s)</h4> </div>
          <ul id="rec">
            <!-- loop through all result -->
            <?php foreach($books as $book):?>
              <li class="item mx-4 my-4 px-2 py-3">
                <!-- check missing parameters -->
                <?php
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
                  if(array_key_exists('authors', $book['volumeInfo'])){
                    $author = $book['volumeInfo']['authors'][0];
                  }
                  else{
                    $author = 'No Author';
                  }
                ?>
                <a class="titles" 
                  href='detail.php?title=<?php echo $book['volumeInfo']['title'];?>&author=<?php echo $author?>&l=https://www.amazon.com/s?k=<?php echo $book['volumeInfo']['title'];?>'>
                  <?php echo  $book['volumeInfo']['title']; ?>
                </a>

                <h6><?php echo $author;?></h6>
                <p><?php echo $book['volumeInfo']['publishedDate'];?></p>
                <?php if(isset($noRating)&& !empty($noRating)):?>
                    <p><?php echo $noRating?></p>
                <?php else:?>
                    <p>Rating: <?php echo $rating ?>/5.0(<?php echo $count ?> counts)</p>
                <?php endif;?>
                <img class="imgbox" src="<?php echo $imageUrl;?>">
              </li>
            <?php endforeach;?>
          </ul>
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
