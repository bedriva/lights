<?php
require_once 'functions.php';

if (is_loggedin()) {

  echo json_response(1, 'User is logged in');
} else {

  echo json_response(0, 'User is not logged in');
}
