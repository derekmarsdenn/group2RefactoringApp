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
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);

        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total_votes = 0;

        foreach ($poll_answers as $poll_answer) {
            $total_votes += $poll_answer['votes'];
        }
    } else {
        redirect('polls.php', 'The poll with that id does not exist.', 'danger');
    }
}else{
    redirect('polls.php', 'No poll ID specified.', 'danger');
}

?>

<?= template_header('Poll Results') ?>
<?= loggedIn_nav() ?>

    <!-- START PAGE CONTENT -->
    <div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= polls_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <!-- START RIGHT CONTENT COLUMN-->
   
        <div class="container column column">
            <h1 class="title">Poll Results</h1>
            <h2 class="subtitle"><?= $poll['title'] ?> (Total Votes: <?= $total_votes ?>)</h2>
            <div class="container">
                <?php foreach ($poll_answers as $poll_answer) : ?>
                    <p><?= $poll_answer['title'] ?> (<?= $poll_answer['votes'] ?> votes) </p>
                    <progress class="progress is-primary is-large" 
                                value="<?= @round(($poll_answer['votes'] / $total_votes) * 100) ?>" 
                                max="<?= $total_votes * 2 ?>"></progress>
                <?php endforeach ?>
            </div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <a href="polls.php" class="button is-info">Return to Polls</a>
        </div>
        
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>