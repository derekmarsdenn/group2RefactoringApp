<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'W01308982';
$DATABASE_PASS = 'Derekcs!';
$DATABASE_NAME = 'W01308982';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
  exit('Failed to connect to MySQL: ' . mysqli_connect_errno());
}

function pdo_connect_mysql() {
  //db connection constants
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'W01308982';
  $DATABASE_PASS = 'Derekcs!';
  $DATABASE_NAME = 'W01308982';

  //db connection
  try {
    return new PDO(
      'mysql:host=' . $DATABASE_HOST . ';dbname=' .
      $DATABASE_NAME .  ';charset=utf8',
      $DATABASE_USER,
      $DATABASE_PASS
    );
  } catch (PDOException $exception) {
    die ('Failed to connect to the database.');
  }
}


function template_header($title = "Page title")
{
echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}


function loggedOut_nav()
{
  echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span>Refactoring Group 2!</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="index.php" class="button">
                  <span class="icon"><i class="fas fa-home"></i></span>
                  <span>Home</span>
                </a>
                <a href="admin.php" class="button">
                  <span class="icon"><i class="fas fa-user-shield"></i></span>
                  <span>Admin</span>
                </a>
                <a href="contact.php" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Contact Us</span>
                </a>
                
                <a href="login.php" class="button">
                  <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                  <span>Login</span>
                </a>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAV -->
    <!-- START MAIN -->
    <section class="section">
        <div class="container">
EOT;
}

function loggedIn_nav()
{
  echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span>Refactoring Group 2!</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="index.php" class="button">
                  <span class="icon"><i class="fas fa-home"></i></span>
                  <span>Home</span>
                </a>
                <a href="admin.php" class="button">
                  <span class="icon"><i class="fas fa-user-shield"></i></span>
                  <span>Admin</span>
                </a>
                <a href="contact.php" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Contact Us</span>
                </a>
                <a href="logout.php" class="button">
                  <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                  <span>Logout</span>
                </a>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAV -->
    <!-- START MAIN -->
    <section class="section">
        <div class="container">
EOT;
}



function admin_nav()
{
  echo <<<EOT
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label"> Admin menu </p>
            <ul class="menu-list">
                <li>
                    <a a href="admin.php" class="is-active">Admin</a>
                </li>
                <li>
                    <a a href="profile.php">Profile</a>
                </li>
                <li>
                    <a href="polls.php">Polls</a>
                <li>
                    <a a href="contacts.php">Contacts</a>
                </li>
            </ul>
        </aside>
    </div>
  EOT;
}

function contacts_nav()
{
  echo <<<EOT
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label"> Admin menu </p>
            <ul class="menu-list">
                <li>
                    <a a href="admin.php">Admin</a>
                </li>
                <li>
                    <a a href="profile.php">Profile</a>
                </li>
                <li>
                    <a href="polls.php">Polls</a>
                <li>
                    <a a href="contacts.php" class="is-active">Contacts</a>
                </li>
            </ul>
        </aside>
    </div>
  EOT;
}

function polls_nav()
{
  echo <<<EOT
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label"> Admin menu </p>
            <ul class="menu-list">
                <li>
                    <a a href="admin.php">Admin</a>
                </li>
                <li>
                    <a a href="profile.php">Profile</a>
                </li>
                <li>
                    <a href="polls.php" class="is-active">Polls</a>
                <li>
                    <a a href="contacts.php" >Contacts</a>
                </li>
            </ul>
        </aside>
    </div>
  EOT;
}

function profile_nav()
{
  echo <<<EOT
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label"> Admin menu </p>
            <ul class="menu-list">
                <li>
                    <a a href="admin.php">Admin</a>
                </li>
                <li>
                    <a a href="profile.php" class="is-active">Profile</a>
                </li>
                <li>
                    <a href="polls.php" >Polls</a>
                <li>
                    <a a href="contacts.php" >Contacts</a>
                </li>
            </ul>
        </aside>
    </div>
  EOT;
}

function template_footer()
{
echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}

function success($message)
{
  echo <<<EOT
    <div class="notification is-success">
      <h2 class="title is-2">
  EOT;
  echo $message;
  echo <<<EOT
      </h2>
    </div>
EOT;
}

function danger($message)
{
  echo <<<EOT
    <div class="notification is-danger">
      <h2 class="title is-2">
  EOT;
  echo $message;
  echo <<<EOT
      </h2>
    </div>
EOT;
}

function warning($message)
{
  echo <<<EOT
    <div class="notification is-warning">
      <h2 class="title is-2">
  EOT;
  echo $message;
  echo <<<EOT
      </h2>
    </div>
EOT;
}

function redirect($location, $msg, $type)
{
  header('Location: ' . $location . '?msg=' . $msg . '&type=' . $type);
}