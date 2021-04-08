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
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';

    //insert new poll record into the polls table
    $stmt = $pdo->prepare('INSERT INTO polls VALUES(NULL, ?, ?)');
    $stmt->execute([$title, $desc]);

    $poll_id = $pdo->lastInsertId();

    //get the answers and covert the multiline string to an array, so we can insert an answer
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach ($answers as $answer) {
        if (empty($answers)) continue;
        //add answers to the answers table
        $stmt = $pdo->prepare('INSERT INTO poll_answers VALUES(NULL, ?, ?, 0)');
        $stmt->execute([$poll_id, $answer]);
    }
    $msg = "Poll created successfully!";
    redirect('polls.php', $msg, 'success');
}

?>

<?= template_header('Create Poll') ?>
<?= loggedIn_nav() ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN-->
    <?= polls_nav() ?>
    <!-- END LEFT NAV COLUMN-->
    <!-- START RIGHT CONTENT COLUMN-->
   
        <div class="container column column">
        <h1 class="title">Creat Poll</h1>

        <?php if ($msg) : ?>
            <div class="notification is-success">
                <h2 class="title is-2"><?php echo $msg; ?></h2>
            </div>

        <?php endif; ?>

        <form action="" method="post">
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Poll Title">
                </div>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <input class="input" type="text" name="desc" placeholder="Description...">
                </div>
            </div>
            <div class="field">
                <label class="label">Answers (per line)</label>
                <div class="control">
                    <textarea class="textarea" name="answers" placeholder="Answer..."></textarea>
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