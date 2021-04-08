<?php
require 'config.php';

// We need to start sessions, so you should alwasys start sessions using the below code.
session_start();

// if not logged in redirect to login page
// PASSWORD PROTECTED
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}


//query the database
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);

$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<?= template_header('Profile') ?>
<?= loggedIn_nav() ?>

    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= profile_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <!-- START RIGHT CONTENT COLUMN-->
   
        <div class="container column column">
            <h1 class="title">Profile</h1>
            <p class="subtitle">Your account details are below:</p>
            <table class="table">
                <tr>
                    <td>Username: </td>
                    <td><?=$_SESSION['name']?></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><?= $password ?></td>
                </tr>
                <tr>
                    <td>Email Address: </td>
                    <td><?= $email ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>