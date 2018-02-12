<?php
  //file where you can register custom routes

  $routes->get('', 'MainController@index');
  $routes->get('book', 'MainController@index');
  $routes->get('book/new', 'MainController@show');
  $routes->post('book/new', 'MainController@store');

  $routes->get('login', 'AuthController@show');
  $routes->post('login', 'AuthController@login');

  if(Core\Auth::is_logged_in()) {
    $routes->get('book/{id}', 'MainController@edit');
    $routes->post('book/{id}', 'MainController@update');
    $routes->get('book/{id}/delete', 'MainController@delete');
    $routes->get('logout', 'AuthController@logout');
  }
