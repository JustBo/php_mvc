<?php

  namespace App\Controller;

  use Core\BaseController;
  use Core\Request;
  use Core\Auth;

  class AuthController extends BaseController {

    public function show() {
      return $this->view('login');
    }

    public function login(Request $request) {
      $inputs = $request->input();
      if(!Auth::login($inputs['moderator'], $inputs['password'])) {
        $errors = array('Wrong credentials');
        return $this->view('login', compact('inputs', 'errors'));
      }
      return $this->redirect('/otakoyi/book');
    }

    public function logout() {
      Auth::logout();
      return $this->redirect('/otakoyi/book');
    }

  }
