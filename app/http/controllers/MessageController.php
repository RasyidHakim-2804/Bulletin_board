<?php

namespace App\Http\Controllers;

use App\Http\Validator\MessageValidator;
use App\Models\Message;
use App\Helpers\HelperFunction as Helper;
use Core\Flash;
use Core\Controller;

class MessageController extends Controller
{
  public function index()
  {
    $rows    = (new Message)->getAll('DESC');

    return Helper::view('home', ['rows' => $rows]);
  }

  //menambah pesan
  public function store()
  {
    $message      = $_POST['message_data'];

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
    $message = (new Message)->findFirst($id);

    if ($message === null) return Helper::showError(404, 'Page not found');

    // var_dump($value);
    return Helper::view('edit', ['message' => $message]);
  }

  public function update()
  {

    $request   = $_POST;

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
