<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

      $data['title'] = (isset($_ENV['judul'])? $_ENV['judul']:"");
      $data['content'] = view('home/content/content.php');
      return view('home/index', $data);
  }
    public function post($slug=""){
    $data['title'] = (isset($slug)? $slug:"");
    $data['content'] = view('home/content/post.php');
      return view('home/index', $data);
  }
  function test(){
    return "abcdefghij";
}
}
