<?php
// var_dump($_POST);

require 'config.php';


?>

<?= template_header('Home') ?>
<?= loggedOut_nav() ?>
<?php
if (isset($_GET['type'])) {
    $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
}
?>
<!-- START PAGE CONTENT -->
<h1 class="title">Login</h1>
<form action="authenticate.php" method="post">
    <div class="field mr-5 ml-5">
    <label for="username">Username</label>
        <p class="control has-icons-left">
            <input name="username" class="input" type="text" placeholder="Username" required>
            <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </p>
    </div>
    <div class="field mr-5 ml-5">
    <label for="password">Password</label>
        <p class="control has-icons-left">
            <input name="password" class="input" type="password" placeholder="Password" required>
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
        </p>
    </div>
    
    <div class="field mr-5 ml-5">
        <p class="control">
            <button class="button is-success is-fullwidth">
                Login
            </button>
        </p>
    </div>
</form>
<p>&nbsp;</p>
<div class="ml-5">
    <p>Don't have an account?</p>
    <a href="register.php" class="button is-light is outlined">Sign Up</a>
    </div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>