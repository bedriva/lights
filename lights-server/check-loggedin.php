<?php
require_once 'functions.php';

if (is_loggedin()) {

  echo json_response(1);

} else {

  echo json_response(0);

}
