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

$type = isset($_GET['type']) ?: '';
$msg = isset($_GET['msg']) ?: '';

// connect to mysql
$pdo = pdo_connect_mysql();

//query that selects all the polls from the db
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers
                     FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id
                     GROUP BY p.id');

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Polls') ?>
<?= loggedIn_nav() ?>

    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= polls_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <!-- START RIGHT CONTENT COLUMN-->
   
        <div class="container column column">
        <?php
        if (isset($_GET['type'])) {
        $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
        }
        ?>
            <h1 class="title">Polls</h1>
            <p>Welcome! View our list of polls below.</p>

            <a href="poll-create.php" class="button is-primary is-small">
                <span class="icon"><i class="fas fa-plus-square"></i></span>
                <span>Create Poll</span>
            </a>
            <p>&nbsp;</p>
            <div class="container">
                <table class="table is-bordered is-hoverable">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Title</td>
                            <td>Answers</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($polls as $poll): ?>
                            <tr>
                                <td>
                                    <?= $poll['id'] ?>
                                </td>
                                <td>
                                    <?= $poll['title'] ?>
                                </td>
                                <td>
                                    <?= $poll['answers'] ?>
                                </td>
                                <td>
                                    <a href="poll-vote.php?id=<?= $poll['id'] ?>" class="button is-link is-small" title="View Poll">
                                        <span class="icon"><i class="fas fa-eye"></i></span>
                                    </a>
                                    <a href="poll-delete.php?id=<?= $poll['id'] ?>" class="button is-link is-small">
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