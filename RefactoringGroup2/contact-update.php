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

if (isset($_GET['id'])) {
    // get contact from db
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$contact){
        $msg = 'Something went wrong! Contact doesn\'t exist with that id.';
        redirect('contacts.php', $msg, 'danger');
    }

    if(!empty($_POST)) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$_GET['id'], $name, $email, $phone, $title, $created, $_GET['id']]);
        $msg = 'Updated successfully!';
        redirect('contacts.php', $msg, 'success');
        
    }
} else {
    $msg = 'Something went wrong! No ID was specified.';
    redirect('contacts.php', $msg, 'danger');
}

?>

<?= template_header('Contact Update') ?>
<?= loggedIn_nav() ?>

    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= contacts_nav() ?>
    <!-- END LEFT NAV COLUMN-->
        <div class="container column column">
            <h1 class="title">Contact Update</h1>
            <form action="contact-update.php?id=<?=$contact['id']?>" method="post">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input type="text" name="name" class="input" value="<?=$contact['name']?>" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input type="text" name="email" class="input" value="<?=$contact['email']?>" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Phone</label>
                    <div class="control">
                        <input type="text" name="phone" class="input" value="<?=$contact['phone']?>" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Title</label>
                    <div class="control">
                        <input type="text" name="title" class="input" value="<?=$contact['title']?>" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input type="submit" class="button" value="Update">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>