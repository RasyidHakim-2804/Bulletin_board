<?php

namespace App\Http\Controllers;

use App\Http\Validator\MessageValidator;
use App\Models\Message;
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
    $message      = Helper::getPostVariable('message_data');

    $validator = new MessageValidator(['body' => $message]);

    if ($validator->validate()) {

      (new Message)->create($validator->getValidRequest());

      Flash::set('message', 'your data succes store in database');

    } else {

      Flash::set('errors', $validator->getErrors());
    }

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

    $request      = Helper::getPostVariable();

    $validator = new MessageValidator($request);

    if ($validator->validate()) {

      (new Message)->update(['id' => $request['id']], $validator->getValidRequest());

      Flash::set('message', 'Your data has been successfully updated.');
      
      Helper::redirect('/');

    } else {

      Flash::set('errors', $validator->getErrors());

      Helper::redirect('/message/edit/' . $request['id']);
    }


  }

  public function delete($id)
  {
    (new Message)->delete($id);

    Flash::set('message', 'Your data has been successfully deleted.');
    Helper::redirect('/');
  }
}
