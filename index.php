<?php
    //Title of the page
    $pageTitle = "Home";

    require "require/head.php";
    require "require/footer.php";
?>
<div class="p-2 row d-flex justify-content-center">
  <div class="card p-2 m-1 col-md-2">
    <h1 class="display-5 ">Get <br><strong class="text-primary">Started</strong></h1><br>
    <a class="btn blue-gradient" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" selected="false">Sign In</a>
    <a class="btn blue-gradient" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" selected="false">Sign Up</a>
    <a class="btn btn-outline-primary btn-sm" id="forgot-tab" data-toggle="tab" href="#forgot" role="tab" aria-controls="forgot" selected="false">Forgot Password</a>
  </div>
  <div class="card p-2 m-1 col-md-4">
    <h1 class="display-5 ">Community <br><strong class="text-primary">Info</strong></h1><br>
    <p class="p-2 blue lighten-5"><strong class="badge blue-gradient">Name</strong><br> <?php echo $optionsArray['communityName']; ?></p>
    <p class="p-2 blue lighten-5"><strong class="badge blue-gradient">Description</strong><br> <?php echo $optionsArray['communityDesc']; ?></p>
    <p class="p-2 blue lighten-5"><strong class="badge blue-gradient">Members</strong><br> <?php echo $noOfUsers; ?></p>
  </div>
</div>
<div class="p-2 row d-flex justify-content-center">
    <div class="tab-content" id="indexTabContent">
        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
            <p>Login</p>
        </div>
        <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
            <p>Signup</p>
        </div>
        <div class="tab-pane fade" id="forgot" role="tabpanel" aria-labelledby="forgot-tab">
            <p>Forgot</p>
        </div>
    </div>
</div>