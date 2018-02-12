<?php

  namespace App\Controller;

  use Core\BaseController;
  use Core\Request;
  use App\Model\Book;
  use Core\Helper;
  use Core\Validator;
  use Core\Auth;

  use Gregwar\Captcha\CaptchaBuilder;

  class MainController extends BaseController {

    public function index() {
      $perpage = 5;

      $order = isset($_GET['order']) ? $_GET['order'] : "created";
      $method = isset($_GET['method']) ? $_GET['method'] : "DESC";
      $page = isset($_GET['page']) ? $_GET['page'] : "1";

      $book = new Book();
      $books = $book
        ->all()
        ->order($order, $method)
        ->limit(($page-1)*$perpage, $perpage)
        ->get();
      $count = $book->count();
      $is_logged_in = Auth::is_logged_in();
      return $this->view('home', compact('books', 'count', 'perpage', 'page', 'method', 'order', 'is_logged_in'));
    }

    public function edit($id) {
      $book = new Book();
      $inputs = $book->findOrFail($id);
      $button = "Update";
      return $this->view('form', compact('inputs', 'button'));
      // return $this->view('home', compact('books'));
    }

    public function show() {

      $captcha = new CaptchaBuilder;
      $captcha->build();
      $button = "Create";
      $_SESSION['phrase'] = $captcha->getPhrase();

      return $this->view('form', compact('captcha', 'button'));
    }

    public function store(Request $request) {

      $book = new Book();
      $inputs = $request->input();

      $validator = new Validator;

      $validator->validate($inputs, array(
        'name' => 'required',
        'email' => 'required|email',
        'captcha' => "/^{$_SESSION['phrase']}$/"
      ));

      if (!$validator->is_success()) {

        $captcha = new CaptchaBuilder;
        $captcha->build();

        $_SESSION['phrase'] = $captcha->getPhrase();

        $button = "Create";
        $errors = $validator->getErrors();

        return $this->view('form', compact('errors', 'inputs', 'captcha', 'button'));
      }

      $inputs['IP'] = Helper::getUserIP();
      $inputs['browser'] = Helper::getUserBrowser();

      $stored = $book->store($inputs);

      return $this->redirect('/otakoyi/book');
    }

    public function update(Request $request, $id) {

      $bookm = new Book();
      $inputs = $request->input();
      $book = $bookm->findOrFail($id);

      $validator = new Validator;

      $validator->validate($inputs, array(
        'name' => 'required',
        'email' => 'required|email'
      ));

      if (!$validator->is_success()) {
        $button = "Update";
        $errors = $validator->getErrors();
        return $this->view('form', compact('errors', 'inputs', 'button'));
      }

      $stored = $bookm->update($inputs, $id);
      return $this->redirect('/otakoyi/book');
    }

    public function delete($id) {
      $book = new Book();
      $book->delete($id);
      return $this->redirect('/otakoyi/book');
    }

  }
