<?php

use function App\Helpers\get_session;
use function App\Helpers\unset_session;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ERROR</title>
</head>
<body>
  <h1>ERROR</h1>
  <h2><?= get_session('error') ?></h2>
</html>