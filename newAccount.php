<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  session_start();	
  $message="";
  if (isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
  }

  if(!empty($_POST["login"])) {
  
    $file = (string)file_get_contents('./database.json', FILE_USE_INCLUDE_PATH);
    $json = json_decode($file, true);
      foreach ($json as $value) {
          if (in_array($_POST['user_name'], $value)) {
              $message = "Username already exists!";
              break;
          }
      }
      if($message == ""){
        $myFile = "./database.json";
        $arr_data = array(); // create empty array

        try
        {
          //Get form data
          $clean = array();
          $formdata = array(
              'name'=> $_POST['user_name'],
              'password'=> $_POST['password'],
              'favorites' => $clean
          );
          //Get data from existing json file
          $jsondata = file_get_contents($myFile);

          // converts json data into array
          $arr_data = json_decode($jsondata, true);
          //echo $arr_data;
          // Push user data to array
          array_push($arr_data,$formdata);

            //Convert updated array to JSON
          $jsondata = (string)json_encode($arr_data, 128);
          //echo $jsondata;
          //write json data into data.json file
          
          file_put_contents($myFile, $jsondata);
          
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
      }
  } 
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
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/one-page-wonder.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
      <div class="container">
        <a class="navbar-brand" href="./index.php">Newsfeed</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="./login.php">Log In</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead text-center text-white">
      <div class="masthead-content">
        <div class="container">
          <h1 class="masthead-heading mb-0">Newsflash</h1>
          <h2 class="masthead-subheading mb-0">Will Rock Your Socks Off</h2>
          <a href="#" class="btn btn-primary btn-xl rounded-pill mt-5">Learn More</a>
        </div>
      </div>
      <div class="bg-circle-1 bg-circle"></div>
      <div class="bg-circle-2 bg-circle"></div>
      <div class="bg-circle-3 bg-circle"></div>
      <div class="bg-circle-4 bg-circle"></div>
    </header>

    <section>
        <br />
        <div class="container">
            <form action="" method="post" id="frmLogin">
            <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>	
            <div class="field-group">
              <div><label for="login">Username</label></div>
              <div><input name="user_name" type="text" class="input-field form-control"></div>
            </div>
            <div class="field-group">
              <div><label for="password">Password</label></div>
              <div><input name="password" type="password" class="input-field form-control"> </div>
            </div>
            <div class="field-group">
              <div><input type="submit" name="login" value="Continue" class="form-submit-button btn btn-primary btn-sm rounded-pill mt-5"></span></div>
            </div>     
          </form><br />
          <a href="./login.php" class="btn btn-primary btn-sm rounded-pill">Already have an account?</a>
          </div>
          <br />
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-black">
      <div class="container">
        <p class="m-0 text-center text-white small">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
