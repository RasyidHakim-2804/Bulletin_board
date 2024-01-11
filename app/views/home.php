<?php
use Core\Flash;

if (Flash::has('errors')) {
    foreach (Flash::get('errors') as $error) {
        echo "<div class='error'>". $error ."</div><br><br>";
    }
}


if (Flash::has('message')) {
    echo "<div class='success'>". Flash::get('message') ."</div>";
}
// var_dump($_SESSION);

function convertTime($time){
    $time = strtotime($time);
    return date("Y-m-d  h:i:sa", $time);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Board</title>
    <style>
        th,td {
            padding: 15px;
        }

        table,th,td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .error {
            display: inline-block;
            background: red;
            padding: 5px;
            color: white;
        }

        .success {
            display: inline-block;
            background: green;
            padding: 5px;
            color: white;
        }

        .btn-blue {
            display: inline-block;
            background: blue;
            text-decoration: none;
            color: white;
            padding: 5px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .btn-red {
            display: inline-block;
            background: red;
            text-decoration: none;
            color: white;
            padding: 5px;
            margin-left: 5px;
            margin-right: 5px;
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
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td> <?= $row['id'] ?> </td>
                    <td> <?= htmlspecialchars($row['body']) ?> </td>
                    <td>
                        <h4> <?= convertTime($row['time']) ?></h4>
                    </td>
                    <td>
                        <a class="btn-blue" href="./message/edit/<?= $row['id']?>">Edit</a>
                        <a class="btn-red" href="./message/delete/<?= $row['id']?>">Delete</a>
                    </td>
                <tr>
                <?php endforeach ?>
        </table>

    </div>
</body>

</html>