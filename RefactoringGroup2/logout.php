<?php
//logout script

session_start();
session_destroy();

//redirect to home
header('Location: index.php');