<?php
require_once 'functions.php';

if (check_and_do_login($_POST['username'], $_POST['password'])) {

  header('Location: index');

} else {

  header('Location: login?error=1');

}
