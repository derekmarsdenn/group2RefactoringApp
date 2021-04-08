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

$msg = '';
// connect to mysql
$pdo = pdo_connect_mysql();

//query that selects all the polls from the db
$stmt = $pdo->query('SELECT * FROM contacts');

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$type = isset($_GET['type']) ?: '';

?>

<?= template_header('Contacts') ?>
<?= loggedIn_nav() ?>


    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= contacts_nav() ?>
    <!-- END LEFT NAV COLUMN-->
        <div class="container column column">
            <?php
            if (isset($_GET['type'])) {
            $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
            }
            ?>
            <h1 class="title">Contacts</h1>
            <p>Welcome! Here are all your contacts.</p>

            <a href="contact-create.php" class="button is-primary is-small">
                <span class="icon"><i class="fas fa-plus-square"></i></span>
                <span>Create Contact</span>
            </a>
            <p>&nbsp;</p>
            <div class="container">
                <table class="table is-bordered is-hoverable">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Phone</td>
                            <td>Title</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td>
                                    <?= $contact['id'] ?>
                                </td>
                                <td>
                                    <?= $contact['name'] ?>
                                </td>
                                <td>
                                    <?= $contact['email'] ?>
                                </td>
                                <td>
                                    <?= $contact['phone'] ?>
                                </td>
                                <td>
                                    <?= $contact['title'] ?>
                                </td>
                                <td>
                                    <a href="contact-update.php?id=<?= $contact['id'] ?>" class="button is-link is-small">
                                        Update
                                    </a>
                                    <a href="contact-delete.php?id=<?= $contact['id'] ?>" class="button is-link is-small">
                                        <span class="icon"><i class="fas fa-trash-alt"></i></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- END PAGE CONTENT -->

<?= template_footer() ?>