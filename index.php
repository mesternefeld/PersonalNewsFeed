<?php
  session_start();
  /*if (!isset($_SESSION["user_id"])) {
    header("Location: ./login.php");
  }*/
  if(isset($_GET['logout'])) {
    $_SESSION["user_id"] = "";
    session_destroy();
    header("Location: ./index.php");
  }
  $cookie_name = "lastVisit";
  //mm-dd-yyyy HH:mm:ss
  $cookie_value = date("m-d-y h:i:sa");
  setcookie($cookie_name, $cookie_value);
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Newsflash</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="./css/glyphs.css">    

    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/one-page-wonder.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
		//this forces javascript to conform to some rules, like declaring variables with var
		"use strict";
	  
		
    
		function init(){
			//NHL URL for ESPN RSS feed
			var urlNhl = "http://espn.go.com/espn/rss/nhl/news";
			var urlNfl = "http://espn.go.com/espn/rss/nfl/news";
      var urlMlb = "http://espn.go.com/espn/rss/mlb/news";
			document.querySelector("#loading").innerHTML = "<b>Loading news...</b>";
			$("#content").fadeOut(250);
			//fetch the data
      document.querySelector("#content").innerHTML ="";
			$.get(urlNhl).done(function(data){xmlLoaded(data, "all");}).catch(function(data){xmlLoaded(data);});
      $.get(urlNfl).done(function(data){xmlLoaded(data, "all");}).catch(function(data){xmlLoaded(data);})
      $.get(urlMlb).done(function(data){xmlLoaded(data, "all");}).catch(function(data){xmlLoaded(data);})
    }
		function NHL(obj){
			//NHL URL for ESPN RSS feed
      if (obj.classList.contains("btn-primary")){
        var urlNhl = "http://espn.go.com/espn/rss/nhl/news";
        document.querySelector("#loading").innerHTML = "<b>Loading news...</b>";
        $("#content").fadeOut(250);
        //fetch the data
        $.get(urlNhl).done(function(data){xmlLoaded(data, "nhl");}).catch(function(data){xmlLoaded(data);});
      }
    }
    function NFL(obj){
        //NHL URL for ESPN RSS feed
      if (obj.classList.contains("btn-primary")){
        var urlNfl = "http://espn.go.com/espn/rss/nfl/news";
        document.querySelector("#loading").innerHTML = "<b>Loading news...</b>";
        $("#content").fadeOut(250);
        //fetch the data
        $.get(urlNfl).done(function(data){xmlLoaded(data, "nfl");}).catch(function(data){xmlLoaded(data);})
      }
    }
    function MLB(obj){
      if (obj.classList.contains("btn-primary")){
        //NHL URL for ESPN RSS feed
        var urlMlb = "http://espn.go.com/espn/rss/mlb/news";
        document.querySelector("#loading").innerHTML = "<b>Loading news...</b>";
        $("#content").fadeOut(250);
        //fetch the data
        $.get(urlMlb).done(function(data){xmlLoaded(data, "mlb");}).catch(function(data){xmlLoaded(data);})
      }
    }
		function noAll(){
      if (document.getElementById("all-but").classList.contains("btn-primary")){
        active(document.getElementById("all-but"));
      }
      if (document.getElementById("favs").classList.contains("btn-primary")){
        active(document.getElementById("favs"));
      }
    }
    function yesAll(){
      if (!document.getElementById("all-but").classList.contains("btn-primary")){
        var paras = document.getElementsByClassName("btn-primary");
          while(paras[0]) {
            console.log(paras);
            active(paras[0]);
          }
      }
    }
    function uncheck(obj, title){
      if (!obj.classList.contains("btn-primary")){
        var paras = document.getElementsByClassName(title);
        
        while(paras[0]) {
          console.log(paras);
          paras[0].parentNode.removeChild(paras[0]);
        }
      }
    }

    function star(obj){
      var id = $(obj).closest('div').parent().parent().attr('id');
      console.log(id);
      var entireDiv = document.getElementById(id);
      entireDiv.classList.toggle("favorite");
      console.log(entireDiv.outerHTML);
      var user='<?php echo $_SESSION["user_id"];?>';
      jQuery.getJSON("database.json", function(json) {
        if(user != ''){
          json.forEach(function(element) {
            if(element.name == user){
              console.log(element.favorites);
              element.favorites.push(entireDiv.outerHTML);
              console.log(element.favorites);
            }
          });
          var newData = JSON.stringify(json);
          //console.log(newData);
          jQuery.post('./saveJson.php', {
              newData: newData
          }, function(response){
              // response could contain the url of the newly saved file
          });
        }
        
      });
    }

    function unstar(obj){
      var id = $(obj).closest('div').parent().parent().attr('id');
      console.log(id);
      var entireDiv = document.getElementById(id);
      var user='<?php echo $_SESSION["user_id"];?>';
      jQuery.getJSON("database.json", function(json) {
        if(user != ''){
          json.forEach(function(element) {
            //console.log(element.favorites);
            if(element.name == user){
              for (var i = 0; i < element.favorites.length; i++) { 
                if(element.favorites[i].includes(id)){
                  element.favorites.splice(i, 1);
                  break;
                }
              }
              console.log(element.favorites); 
            }
          });
          var newData = JSON.stringify(json);
          //console.log(newData);
          jQuery.post('./saveJson.php', {
              newData: newData
          }, function(response){
              favorites();
          });
          
        }
        
      });
    }

    function favorites(){
      console.log("hello");
      yesAll();
      if(document.getElementById("all-but").classList.contains("btn-primary")){
        active(document.getElementById("all-but"));
      }
      if (!document.getElementById("favs").classList.contains("btn-primary")){
        active(document.getElementById("favs"));
      }
      var user='<?php echo $_SESSION["user_id"];?>';
      console.log(user);
      document.querySelector("#content").innerHTML ="";
      jQuery.getJSON("./database.json", function(json) {
        if(user != ''){
          json.forEach(function(element) {
            if(element.name == user){
              console.log(element.favorites);
              element.favorites.forEach(function(obj) {
                obj = obj.replace(/star\(this\);/gi, "unstar(this);");
                //console.log(obj);
                document.querySelector("#content").innerHTML += obj;
              });
            }
          });
          
        }
        
      });
    }

		function xmlLoaded(obj, titleGiven){
			console.log(obj);
			var items = obj.querySelectorAll("item");
			
			//parse the data
			var html = "";
      if(document.getElementsByClassName("all").length > 0 && titleGiven != "all"){
        document.querySelector("#content").innerHTML ="";
      }
      //console.log(document.querySelector("#content").innerHTML);
			for (var i=0;i<items.length;i++){
				//get the data out of the item
				var newsItem = items[i];
				var title = newsItem.querySelector("title").firstChild.nodeValue;
				//console.log(title);
				var description = newsItem.querySelector("description").firstChild.nodeValue;
				var link = newsItem.querySelector("link").firstChild.nodeValue;
				var pubDate = newsItem.querySelector("pubDate").firstChild.nodeValue;
				
				//present the item as HTML
				var line = '<div class="' + titleGiven + '" id="' + title + '">';
        line += '<div class="card card-default">';
        line += '<div class="card-header">';
				line += '<h2><a href="#" onclick="star(this);"><span class="glyphicon glyphicon-star-empty"></span></a>  '+title+'</h2>';
        line += '</div><div class="card-block">'
				line += '<p><i><br />'+pubDate+'</i> - <a href="'+link+'" class="btn btn-primary btn-sm rounded-pill" target="_blank">See original</a></p>';
        //title and description are always the same (for some reason) so I'm only including one
				//line += "<p>"+description+"</p>";
				line += "</div></div></div>";
				
				html += line;
			}
			document.querySelector("#content").innerHTML += html;
			document.querySelector("#loading").innerHTML = "";
			$("#content").fadeIn(1000);
		
		}	
    function active(element) {
      element.classList.toggle("btn-primary");
    }
    $(document).ready(function(){
      init();
    });

	</script>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Newsfeed</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
          <?php if (!isset($_SESSION["user_id"])){ ?>
            <li class="nav-item">
              <a class="nav-link" href="./newAccount.php">Sign Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./login.php">LogIn</a>
            </li>
            <?php } ?>
          <?php if (isset($_SESSION["user_id"])){ ?>
            <li class="nav-item">
              <a class="nav-link" href="./index.php?logout">Logout</a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead text-center text-white">
      <div class="masthead-content">
        <div class="container">
          <h1 class="masthead-heading mb-0">Newsflash</h1>
          <h2 class="masthead-subheading mb-0">Welcome to the Feedburner!</h2>
          <h2 class="masthead-subheading mb-0">Last visit: <?php echo $_COOKIE['lastVisit']; ?></h2>
        </div>
      </div>
      <div class="bg-circle-1 bg-circle"></div>
      <div class="bg-circle-2 bg-circle"></div>
      <div class="bg-circle-3 bg-circle"></div>
      <div class="bg-circle-4 bg-circle"></div>
    </header>
    <section>
      <div class="container"><br />
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
              <a class="nav-link btn-primary" id="all-but" onclick="yesAll(); active(this); init(); uncheck(this, 'all');" href="#">All</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onclick="active(this); noAll(); NHL(this); uncheck(this, 'nhl');" href="#">NHL</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onclick="active(this); noAll(); NFL(this); uncheck(this, 'nfl');" href="#">NFL</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onclick="active(this); noAll(); MLB(this); uncheck(this, 'mlb');" href="#">MLB</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="favs" onclick="active(this); favorites(this);" href="#">Favorites</a>
            </li>
          </ul>
        <br /><h1>Newsflash</h1>
        <div id="loading"></div>
        <div id="content">
            
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer class="py-5 bg-black">
      <div class="container">
        <p class="m-0 text-center text-white small">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    

  </body>

</html>
