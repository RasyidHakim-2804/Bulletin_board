<?php

namespace App\Controllers;


use App\Models\Message;
use App\Helpers\MyString;
use App\Helpers\HelperFunction as Helper;
use Core\Flash;

class MessageController
{
  public function index()
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

    return Helper::view('home', ['row' => $row]);
  }

  //menambah pesan
  public function store()
  {
    $message      = Helper::getPostVariable('message_data') ?? '';
    $fixMessage   = MyString::sanitizeSpaces($message);
    $statusLength = MyString::validateLength($fixMessage, 10, 200);

    $message;
    if ($statusLength !== 'pass') {
      $message = 'sorry your data is to ' . $statusLength . ', the lenght is ' . strlen($fixMessage);
    }

    if ($statusLength === 'pass') {
      (new Message)->create(['body' => $fixMessage]);
      $message = 'your data succes store in database';
    }

    Flash::set('message', $message);

    return Helper::redirect('/');
  }

  public function edit(int $id)
  {
    $data = (new Message)->findFirst($id);

    if ($data === null) Helper::showError();

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
    $request = Helper::getPostVariable();

    $fixMessage   = MyString::sanitizeSpaces($request['body']);
    $statusLength = MyString::validateLength($fixMessage, 10, 200);
    
    if ($statusLength !== 'pass') {

      $message = 'sorry your data is to ' . $statusLength . ', the lenght is ' . strlen($fixMessage);

      Flash::set('message', $message);
      
      Helper::redirect('/message/edit/' . $request['id']);
    }

    if ($statusLength === 'pass') {
      
      (new Message)->updateFirst($request['id'], ['body' => $request['body']]);

      $message = 'Your data has been successfully updated.';
      
      Flash::set('message', $message);

      Helper::redirect('/');
    }
  }

  public function delete($id)
  {
    (new Message)->deleteFirst($id);

    Flash::set('message', 'Your data has been successfully deleted.');
    Helper::redirect('/');
  }
}
