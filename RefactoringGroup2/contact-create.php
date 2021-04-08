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

// connect to mysql
$pdo = pdo_connect_mysql();

$msg = "";

//check if POST data is not empty
if (!empty($_POST)) {
    
    //check to see if data from form isset
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    //insert new poll record into the polls table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES(NULL, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $title, $created]);

    $msg = "Contact created successfully!";
    redirect('contacts.php', $msg, 'success');
}

?>

<?= template_header('Create Contact') ?>
<?= loggedIn_nav() ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= contacts_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <div class="container column column">
        <h1 class="title">Create Contact</h1>

        <?php if ($msg) : ?>
            <div class="notification is-success">
                <h2 class="title is-2"><?php echo $msg; ?></h2>
            </div>

        <?php endif; ?>

        <form action="" method="post">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="input" type="text" name="name" placeholder="Jon Doe">
                </div>
            </div>
            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" type="text" name="email" placeholder="jondoe@example.com">
                </div>
            </div>
            <div class="field">
                <label class="label">Phone</label>
                <div class="control">
                    <input class="input" type="text" name="phone" placeholder="(888)888-8888">
                </div>
            </div>
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Mr. Sir">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>