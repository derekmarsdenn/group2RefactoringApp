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

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);

$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

//additional php code for this page goes here

?>

<?= template_header('Home') ?>
<?= loggedIn_nav() ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= admin_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <!-- START RIGHT CONTENT COLUMN-->
   
    <div class="container column column">
        <?php
            if (isset($_GET['type'])) {
                $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
            }
        ?>
        <table class="table">
            <tr>
                <td>Your account details:</td>
            </tr>
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
    <!-- END RIGHT CONTENT COLUMN-->
</div>


<?= template_footer() ?>