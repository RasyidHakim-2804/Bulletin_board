<?php
use Core\Flash;

if (Flash::has('errors')) {
    foreach (Flash::get('errors') as $error) {
     echo $error;
    }
 }


if (Flash::has('message')) {
    echo Flash::get('message');
}
// var_dump($_SESSION);
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
        <form action="message" method="POST">
            <h4>Your message must be 10 to 200 characters long</h4>
            <h4>Spaces at the beginning and at the end of a sentence are not counted</h4>
            <textarea name="message_data" cols="70" rows="3" style="resize:none"></textarea><br />
            <input type="submit" name="submit" value="Submit">
        </form>
        <form action=" ./ " method="GET">
            <button type="submit">Refresh</button>
        </form>
    </div>
    <hr><br><br>

    <!-- show data -->
    <div>
        <table style="width: 70%;">
            <tr>
                <th>ID</th>
                <th>MESSAGE</th>
                <th>CREATED ON</th>
                <th>ACTIONS</th>
            </tr>
            <?php foreach ($row as $data) : ?>
                <tr>
                    <td> <?= $data['id'] ?> </td>
                    <td> <?= $data['body'] ?> </td>
                    <td>
                        <h4> <?= $data['time'] ?></h4>
                    </td>
                    <td>
                        <a href="./message/edit/<?= $data['id']?>">Edit</a>
                        <a href="./message/delete/<?= $data['id']?>">Delete</a>
                    </td>
                <tr>
                <?php endforeach ?>
        </table>

    </div>
</body>

</html>