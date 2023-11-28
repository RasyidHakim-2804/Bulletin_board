<?php

namespace App\Controllers;


use App\Models\Message;
use App\Helpers\MyString;
use App\Helpers\HelperFunction as Helper;

class MessageController
{
  public function index($response = null)
  {
    $row    = (new Message)->getAll('DESC');

    //membersihkan data untuk menonaktifkan html tag pada client
    array_walk($row, function (&$value) {
      $time = strtotime($value['time']);
      $time = date("Y-m-d  h:i:sa", $time);

      $value = [
        'id'   => $value['id'],
        'time' => $time,
        'body' => htmlspecialchars($value['body']),
      ];
    });

    if (isset($response)) return Helper::view('home', ['row' => $row, 'response' => $response]);

    return Helper::view('home', ['row' => $row]);
  }

  //menambah pesan
  public function store()
  {
    $message      = Helper::getPostVariable('message_data') ?? '';
    $response     = [];
    $fixMessage   = MyString::sanitizeSpaces($message);
    $statusLength = MyString::validateLength($fixMessage, 10, 200);

    if ($statusLength !== 'pass') {

      $response = [
        'no-valid'     => [
          'statusLength' => $statusLength,
          'length'       => strlen($fixMessage),
        ]
      ];
    }

    if ($statusLength === 'pass') {

      $response = (new Message)->create(['body' => $fixMessage]);
    }

    return $this->index($response);
  }

  public function edit(int $id)
  {
    $data = (new Message)->findFirst($id);

    $time = strtotime($data['time']);
    $time = date("Y-m-d  h:i:sa", $time);

    $data = [
      'id'   => $data['id'],
      'time' => $time,
      'body' => htmlspecialchars($data['body']),
    ];

    // var_dump($value);
    return Helper::view('edit', ['data' => $data]);
  }

  public function update()
  {
    $body = Helper::getPostVariable('body');
    $id   = Helper::getPostVariable('id');

    $result = (new Message)->updateFirst($id, ['body'=> $body]);

    Helper::redirect('/');
  }

  public function delete($id)
  {
    (new Message)->deleteFirst($id);

    Helper::redirect('/');
  }
}
