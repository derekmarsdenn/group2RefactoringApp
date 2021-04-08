<?php
// var_dump($_POST);

require 'config.php';

session_start();

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill in username and password fields!');
}

//prepare sql 
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    //bind param
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();

    //store result
    $stmt->store_result();
    //more stuff here
    //authenticate user
    if ($stmt->num_rows > 0){
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            //echo "Welcome " . $_SESSION['name']; 
            header('Location: admin.php');
        } else {
            $msg = 'Incorrect password.';
            redirect('login.php', $msg, 'danger');
        }
    } else {
        $msg = 'Incorrect username.';
        redirect('login.php', $msg, 'danger');
    }
    
    $stmt->close();
}