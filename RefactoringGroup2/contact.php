<?php
require 'config.php';

//additional php code for this page goes here
$msg = '';

if (isset($_POST['email'], $_POST['name'], $_POST['subject'], $_POST['msg'])) {
    var_dump($_POST);
    
    $to = 'derekcmarsden@gmail.com';
    $from = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['msg'];
    $headers = 'From: ' . $_POST['email'] . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);

    // update response
    $msg = 'Message Sent!';
    redirect('index.php', $msg, 'success');
}
?>

<?= template_header('Home') ?>
<?php
if (!isset($_SESSION['loggedin'])) {
    loggedOut_nav();
}else{
    loggedIn_nav();
}
?>
<?php
if (isset($_GET['type'])) {
    $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
}
?>
    <section class="section">
        <div class="container">

            <h1 class="title">
                Contact us
            </h1>
            

            <form action="" method="post">
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left">
                        <input name="email" class="input" type="email" placeholder="e.g. alexsmith@gmail.com">
                        <span class="icon is-small is-left">
                            <i class="fas fa-at"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input name="name" class="input" type="text" placeholder="e.g Alex Smith">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Message Subject</label>
                    <div class="control">
                        <input name="subject" class="input" type="text" placeholder="Example">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Message</label>
                    <div class="control">
                        <textarea name="msg" class="textarea" placeholder="Textarea"></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-link">
                            <span class="icon">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span>
                                Send Message
                            </span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>


<?= template_footer() ?>