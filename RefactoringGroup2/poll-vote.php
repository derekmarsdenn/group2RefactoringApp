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

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);

    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);

        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST['poll_answer'])) {
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
            $stmt->execute([$_POST['poll_answer']]);
            header('Location: poll-result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        $msg = 'Something went wrong! A poll with that ID does not exist.';
        redirect('polls.php', $msg, 'danger');
    }
} else {
    $msg = 'Something went wrong! No ID set.';
    redirect('polls.php', $msg, 'danger');
}


?>

<?= template_header('Poll Vote') ?>
<?= loggedIn_nav() ?>

    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= polls_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <!-- START RIGHT CONTENT COLUMN-->
   
        <div class="container column column">
            <h1 class="title"><?= $poll['title'] ?></h1>
            <h2 class="subtitle"><?= $poll['desc'] ?></h2>
            <div class="section">
                <form action="poll-vote.php?id=<?= $_GET['id'] ?>" method="post">
                    <div class="field">
                        <div class="control">
                            <?php for ($i = 0; $i < count($poll_answers); $i++) : ?>
                                <label class="radio">
                                    <input type="radio" name="poll_answer" value="<?= $poll_answers[$i]['id'] ?>" <?= $i == 0 ? ' checked' : '' ?>>
                                    <?= $poll_answers[$i]['title'] ?>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button" value="Vote" type="submit">Vote</button>
                            <a href="polls.php" class="button is-info">Return to Polls</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>