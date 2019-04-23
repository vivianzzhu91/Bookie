//get book details for each book from google book api
getBook = (title, amazonLink, rank) =>{
    const url = 'https://www.googleapis.com/books/v1/volumes?q='+title+'&key=AIzaSyCa7VNQhw7vHTefuAK67TNcj_gpUWnshQs&orderBy=newest&maxResults=5';
    let recom = $("#rec");
    $.ajax({
        url: url,
        success: function(result){
            let item = result.items[0];
            console.log(item); 
            //get related info to display on homepage
            
            let author = item.volumeInfo.authors[0];
            let name = item.volumeInfo.title;
            let date = item.volumeInfo.publishedDate;
            // validate ratings
            let rating = '';
            if (item.volumeInfo.hasOwnProperty('averageRating')) {
                rating = item.volumeInfo.averageRating;
            }
            else{
                rating = 'Rating Not Available'
            }
            // validate image links
            let imgUrl = '';
            if (item.volumeInfo.hasOwnProperty('imageLinks')) {
                imgUrl = item.volumeInfo.imageLinks.thumbnail;
            }
            let googleLink = item.accessInfo.webReaderLink;
            //create new component
            let li = $('<li class="item mx-4 my-4 px-2 py-3"></li>')
            let rankNode = $('<h3 class="rank">'+rank+'</h3>')
            let titleNode = $('<h5>'+name+'</h5>')
            let authorNode = $('<h5>'+author+'</h5>')
            let dateNode = $('<p>'+date+'</p>')
            let ratingNode = $('<p>Rating: '+rating+'</p>')
            let imgNode = '';
            if(imgUrl != ''){
                imgNode= $('<img class="imgbox" src='+imgUrl+'>')
            }
            else{
                imgNode= $('<img class="imgbox" src="../images/warning.jpg">')
            }
            li.append(rankNode);
            li.append(titleNode);
            li.append(authorNode);
            li.append(dateNode);
            li.append(ratingNode);
            li.append(imgNode);
            recom.append(li);
        }
    });
}
//get list of high ranking novels from nytimes
getList = () =>{
    $.ajax({
        url: "https://api.nytimes.com/svc/books/v3/lists.json?list-name=hardcover-fiction&api-key=E4wRGWAuksZONZv1AB2yvK4rRpsAopKQ", 
        success: function(result){
            let numResults = result.num_results;
            let results = result.results;
            //loop through all results
            for(let i = 0; i< numResults; i++){
                //query for details of each book
                let row = results[i];
                // console.log(row.book_details[0])
                getBook(row.book_details[0].title, row.amazon_product_url, row.rank );
            }
        }
    });
}  
this.getList();