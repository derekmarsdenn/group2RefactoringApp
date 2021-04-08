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
$msg = '';

if (isset($_GET['id'])) {
    //select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        die ('Contact does not exist with that ID.');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            //output message
            $msg = 'You have deleted the contact.';
            redirect('contacts.php', $msg, 'danger');
        exit;
        } else {
            $msg = 'Contact was not deleted.';
            redirect('contacts.php', $msg, 'warning');
        }
    }

} else {
    die ('No ID specified.');
}

?>

<?= template_header('Delete Contact') ?>
<?= loggedIn_nav() ?>

    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= contacts_nav() ?>
    <!-- END LEFT NAV COLUMN-->
        <div class="container column column">
            <h1 class="title">Delete Contact</h1>

            <?php if ($msg) : ?>
                <div class="notification is-success">
                    <h2 class="title is-2"><?php echo $msg; ?></h2>
                </div>
            <?php endif; ?>

            <h2 class="subtitle">Are you sure you want to delete: <?=$contact['name']?></h2>
            <a href="contact-delete.php?id=<?=$contact['id']?>&confirm=yes" class="button is-success">Yes</a>
            <a href="contact-delete.php?id=<?=$contact['id']?>&confirm=no" class="button is-danger">No</a>
        </div>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>