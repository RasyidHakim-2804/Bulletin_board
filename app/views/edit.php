<?php
use Core\Flash;

if (Flash::has('errors')) {
   foreach (Flash::get('errors') as $error) {
    echo $error;
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Board</title>
    <style>
        th,
        td {
            padding: 15px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div>
        <form action="/Bulletin_board/message/update" method="POST">
            <input type="hidden" name="id" value="<?=$data['id']?>">
            <h4>Your message must be 10 to 200 characters long</h4>
            <h4>Spaces at the beginning and at the end of a sentence are not counted</h4>
            <textarea name="body" cols="70" rows="3" style="resize:none"><?= $data['body'] ?></textarea><br />
            <input type="submit" name="submit" value="Submit">
            <button type="reset">Reset</button>
        </form>
    </div>
    <hr><br><br>

</body>

</html>