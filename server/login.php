<?php
require_once 'functions.php';

if (check_and_do_login($_POST['username'], $_POST['password'])) {
  header('Location: /');
} else {
  if (empty($_GET['error'])) {
    header('Location: lights-admin?error=1');
  }
}
