<html lang="en">


<?php
    //Creating connection for the variable $link
    require "mysqlConnection.php";
    //Grabbing member data, if logged in, and populating session variables
    if(isset($_SESSION['userID'])){
        $sql = mysqli_query($link, "SELECT * FROM users WHERE id=".$_SESSION['userID']);
        $userDetails = mysqli_fetch_array($sql);
        $selectedCommunity = $userDetails['selectedCommunity'];
    }

    //Query for grabbing community info, if one is selected
    if(isset($selectedCommunity)){
        if(!($selectedCommunity == 0)){
            $sql = mysqli_query($link, "SELECT * FROM communities WHERE id=".$selectedCommunity);
            $communityDetails = $mysqli_fetch_array($sql);
        }else{
            $communityDetails['name'] = "NO COMMUNITY SELECTED";
        }
    }
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo($pageTitle.' | PureCAD'); ?></title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">

  <meta property="og:title" content="<?php echo $optionsArray['communityName']; ?>">
  <meta property="og:site_name" content="<?php echo $optionsArray['communityName']; ?>">
  <meta property="og:url" content="https://scfr.site/scfr">
  <meta property="og:description" content="The aim of Pure CAD is to provide an intuitive CAD that users enjoy.">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php echo $optionsArray['communityLogo']; ?>">
  <link rel="stylesheet" type="text/css" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/><script src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script><script>window.addEventListener("load", function(){window.wpcc.init({"border":"thin","corners":"small","colors":{"popup":{"background":"#cff5ff","text":"#000000","border":"#5e99c2"},"button":{"background":"#5e99c2","text":"#ffffff"}}})});</script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
      <a class="navbar-brand" href="#">PureCAD</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
        aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">CAD</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Support</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-top dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>