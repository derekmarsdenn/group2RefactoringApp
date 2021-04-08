<?php
require 'config.php';

//additional php code for this page goes here

if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        //bind param
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            redirect('register.php', 'Username exists, please choose another!', 'danger');
        } else {
            if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $uniqid = uniqid();
                $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
                $stmt->execute();
                //send confirmation email
                $from = 'derekmarsden@mail.weber.edu';
                $subject = 'Account Activation';
                $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n"
                        . 'X-Mailer: PHP/' . phpversion() . "\r\n"
                        . 'MIME-Version: 1.0' . "\r\n"
                        . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
                $activate_link = 'http://icarus.cs.weber.edu/~dm08982/web3400/RefactoringGroup2/activate.php?email='. $_POST['email'] . '&code=' . $uniqid;
                $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
                echo "<a href='$activate_link'>Click here to activate your account!</a>";
            } else {
                redirect('register.php', 'Could not prepare statement!', 'danger');
            }
        }
        $stmt->close();
    } else {
        redirect('register.php', 'Could not prepare statement!', 'danger');
    }

    $con->close();

} 

?>

<?= template_header('Register') ?>
<?= loggedOut_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Register</h1>
<form action="register.php" method="post">
    <div class="field">
        <p class="control has-icons-left">
            <input name="username" class="input" type="text" placeholder="Username" required>
            <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </p>
    </div>
    <div class="field">
        <p class="control has-icons-left">
            <input name="password" class="input" type="password" placeholder="Password" required>
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
        </p>
    </div>
    <div class="field">
        <p class="control has-icons-left">
            <input name="email" class="input" type="email" placeholder="e.g. JonDoe@email.com" required>
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
        </p>
    </div>
    <div class="field">
        <p class="control">
            <button class="button is-success">
                Register
            </button>
        </p>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>