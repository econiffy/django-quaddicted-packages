
<?php

include './lib.php';

$data = json_decode(file_get_contents('php://input'), true); // если вам нужен объект, то не указывайте второй параметр в json_decode()