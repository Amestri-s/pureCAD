<?php
    //Title of the page
    $pageTitle = "Home";
    require "require/head.php";

    $secretKey = "6LcYo8wZAAAAADxFGLVTIQWmj28Pt2nAFF7jeAa5";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_GET['action'] == "register"){

            //Username validation
            $sql = "SELECT id FROM users WHERE username = ?";
            if($stmt = mysqli_prepare($link, $sql)){
              mysqli_stmt_bind_param($stmt, "s", $param_username);
              $param_username = trim($_POST["username"]);
              if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                  $username_err = "Username already taken";
                  $error = true;
                }
              }
            }
            echo mysqli_error($link);
            //Password validation
            if(empty(trim($_POST["password"]))){
              $password_err = "Please enter a password";
              $error = true;
            }else if(strlen(trim($_POST['password'])) < 6){
              $password_err = "Password must have at least 6 characters";
              $error = true;
            }else{
              $password = trim($_POST["password"]);
            }
            //Confirm password validation
            if(empty(trim($_POST["confirmPassword"]))){
              $confirmPassword_err = "Please confirm your password";
              $error = true;
            }else{
              $confirmedPassword = trim($_POST["confirmPassword"]);
              if(empty($password_err) && ($password != $confirmedPassword)){
                $confirmPassword_err = "Password did not match";
                $error = true;
              } 
            }
            //Captcha validation
            if(!empty($_POST['g-recaptcha-response'])){
              $verifyToken = $_POST['g-recaptcha-response'];
              $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".urlencode($secretKey)."&response=".urlencode($verifyToken));
              $responseData = json_decode($response, true);
              if($responseData["success"]){
                if(empty($error)){
                  $SQL = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                  if($stmt = mysqli_prepare($link, $SQL)){
                    mysqli_stmt_bind_param($stmt, "sss", $paramUsername, $paramEmail, $paramPassword);
                    $paramUsername = $param_username;
                    $paramEmail = trim($_POST['email']);
                    $paramPassword = password_hash($password, PASSWORD_DEFAULT);
                    if(mysqli_stmt_execute($stmt)){
                      header("location: /pureCAD");
                    }else{
                      echo("Something went wrong. Please contact us if this error persists.");
                    }
                  }
                }
              }else{
                $error = true;
                $captchaError = "Captcha failed, try again. Error: ".$responseData["error-codes"];
              }
            }else{
              $error = true;
              $captchaError = "Please complete the captcha";
            }
            echo mysqli_error($link);

        }else if($_GET['action'] == "login"){
          $username = trim($_POST["username"]);
          $password = trim($_POST["password"]);
          $sql = "SELECT id, username, password, selectedCommunity FROM users WHERE username = ?";
          if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_param($stmt, $id, $username, $hashedPassword, $selectedCommunity);
                if(password_verify($password, $hashedPassword)){
                  session_start();
                  $_SESSION['userID'] == $id;
                  header("Location: /pureCAD");
                }
              }
            }
          }
        }
    }
?>
<div class="p-2 row d-flex justify-content-center">
  <div class="card p-2 m-1 col-md-4">
    <h1 class="display-5 ">Get <br><strong class="text-primary">Started</strong></h1><br>
    <?php
        if(isset($_SESSION['userID'])){
            if(!($communityDetails = "NO COMMUNITY SELECTED")){
                echo '<button class="btn btn-primary" data-toggle="modal" data-target="#logInModal">Patrol ('.$communityDetails['name'].')</button>';
            }
            echo '
            <button class="btn btn-primary" data-toggle="modal" data-target="#signUpModal">Settings</button>
            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password</button>';
        }else{
            echo '
            <button class="btn btn-primary" data-toggle="modal" data-target="#logInModal">Sign In</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#signUpModal">Sign Up</button>
            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password</button>';
        }
    ?>
  </div>
  <div class="card p-2 m-1 col-md-6">
    <h1 class="display-5 "><?php if(isset($userDetails['username'])){echo 'Welcome, '.$userDetails['username'].', to';}else{echo 'About';}?><br><strong class="text-primary">PureCAD</strong></h1><br>
    <?php
        if(isset($userDetails['username'])){
            echo ('<p class="p-2 blue lighten-5"><strong class="badge bg-primary">Name</strong><br>'.$optionsArray['communityName'].'</p>
                  <p class="p-2 blue lighten-5"><strong class="badge bg-primary">Description</strong><br>'.$optionsArray['communityDesc'].'</p>
                  <p class="p-2 blue lighten-5"><strong class="badge bg-primary">Members</strong><br>'.$noOfUsers.'</p>');
        }else{
            echo ('<p class="p-2 blue lighten-5"><strong class="badge bg-primary">Easy to use</strong><br>PureCAD ofers a hassle-free experience by providing a UI designed and inspired by roelplayers, for roleplayers. Signing up a community is simple and done within minutes of purchase. Accessing a community is as simple as entering a code. We also offer an in-house support team, experienced wiith the CAD, should you run into any issues.</p>
                  <p class="p-2 blue lighten-5"><strong class="badge bg-primary">Reliable</strong><br>We strive to guarantee 99.9% uptime where possible meaning you can roleplay, any time.</p>
                  <p class="p-2 blue lighten-5"><strong class="badge bg-primary">Robust</strong><br>Unlike competitors, PureCAD is built with nothing but pure code, removing inefficiencies from software like Bubble.</p>
                  <p class="p-2 blue lighten-5"><strong class="badge bg-primary">Responsive</strong><br>Would you like to use PureCAD on your phone? You sure can. PureCAD is designed to work on as many devices as possible. If you find a device it can not run on, open a ticket.</p>');
        }

    ?>
  </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="loginModal">Log In</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="text-center border border-light p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?action=login" method="post">
            <input name="username" type="username" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Username" required>
            <input name="password" type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password" required>
            <button class="btn btn-primary" type="submit">Sign in</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="signUpModal">Sign  Up</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
          if(isset($error)){
            if($error == true){
              if(isset($username_err)){echo '<div class="alert alert-danger" role="alert">'.$username_err.'</div>';}
              if(isset($password_err)){echo '<div class="alert alert-danger" role="alert">'.$password_err.'</div>';}
              if(isset($confirmPassword_err)){echo '<div class="alert alert-danger" role="alert">'.$confirmPassword_err.'</div>';}
              if(isset($captchaError)){echo '<div class="alert alert-danger" role="alert">'.$captchaError.'</div>';}
            }
          }
        ?>
        <form class="border border-light p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?action=register" method="post">
            <label>Enter a username</label>
            <input name="username" type="username" id="username" class="form-control mb-4" placeholder="Username" maxlength="24" required>
            <label>Enter your email</label>
            <input name="email" type="email" id="email" class="form-control mb-4" placeholder="E-mail" maxlength="70" required>
            <label>Enter a strong password</label>
            <input name="password" type="password" id="password" class="form-control mb-4" placeholder="Password" maxlength="30" required>
            <label>Confirm the password</label>
            <input name="confirmPassword" type="password" id="confirmPassword" class="form-control mb-4" placeholder="Password" maxlength="30" required>
            <div class="g-recaptcha" data-sitekey="6LcYo8wZAAAAAL5kfji_zZuQ54xIteE-9bBIF7YH"></div>
            <button class="btn blue-gradient" type="submit">Sign up</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
  require "require/footer.php";
  if(isset($error)){
    if($error == true){
      echo'<script>
            $(document).ready(function(){
              $("#signUpModal").modal'."('show')".';
            });
          </script>';
    }
  }
?>