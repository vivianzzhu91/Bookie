//get recommendation by getting google related search
getRec = () => {
  let currUrl = window.location.href;
  let searchTerm = currUrl.split('=')[1]
  let searchUrl = "https://cors-anywhere.herokuapp.com/https://www.google.com/search?q="+searchTerm+"+book&ie=UTF-8";
  //append content to the page
  $.ajax({
    url:
      searchUrl,
    success: function(result) {
      // console.log(result)
      $("#recContent").html(result);
      //hide the content

      //get rec list
      let check = $(document).find(".AAXrR.lfNb6b")
      if(check.length != 0){
        let rec = check.children()[1];
        let allRec = rec.children;
        let list = [];
        for(let i = 0; i < allRec.length; i++){
          list.push(allRec[i].children[0]);
        }
        
        //clear content
        $("#recContent").html("");
        let rectitle = $("<h4>Recommended Books</h4>");
        $('.rectitle').append(rectitle);
        let ul = $("<ul id='recList' class='pb-4'></ul>");
        //append all rec list to the div
        for(let i = 0; i < list.length; i++){
          
          let old = list[i].href.split('?');
          let sUrl = old[1].split('&');
          let term = sUrl[0].split('=')[1];
          let newUrl = "search_result.php?search=" + term;
          list[i].href = newUrl;
          
          let item = $("<li class='recItem mx-2 my-2'></li>");
          item.append(list[i]);
          ul.append(item);
        }
        $("#recContent").append(ul);
      }
      else{
        //clear content
        $("#recContent").html("");
        $('.rectitle').html("");
      }
      
    }
  });

}

this.getRec();

