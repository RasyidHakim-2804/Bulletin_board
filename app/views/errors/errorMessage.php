<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404</title>
</head>

<body>
  <?php if (isset($message) && $code !== 404) : ?>
    <h1><?= $code ?></h1>
    <h3>Message:</h3>
    <p><strong><?= $message ?></strong></p>
  <?php else : ?>
    <h1>404: not found ❌</h1>
  <?php endif ?>
</body>

</html>