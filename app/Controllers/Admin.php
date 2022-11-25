<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;

class Admin extends BaseController
{
  protected $google_client;
  protected $bcrypt;
  protected $bcrypt_version;
  protected $session;
  public function __construct()
  {
    $this->db      = \Config\Database::connect();
    $this->session = session();
    $this->bcrypt = new Bcrypt();
    $this->bcrypt_version = '2a';
    helper('form');
  }
  function get_name($table){
    $query = $this->db->query("SELECT * FROM $table");

    foreach ($query->getFieldNames() as $field) {
      echo '"'.$field.'",';
    }
  }
  public function index(){
    if ($this->_make_sure_is_login()) {
      //code di sini
      if (!empty($this->session->get('login_data'))) {
        $data = $this->session->get('login_data');
      }
      //code end
      //template web strart
      $data['title'] = "Dashboard";
      $data['content'] =  view('admin/content/content_admin.php');
      return view('admin/index.php', $data);
      //template web end
    }else {
      $userModel = new \App\Models\MdlUser();
      $banyak_user = $userModel->countAll();
      $form_validation = \Config\Services::validation();
      if ($banyak_user>0) {
        $data['title'] = "Login";
        if ($this->request->getPost("submit") == "login") {

          $form_validation->setRules([
            'email' => 'required|min_length[4]|max_length[39]',
            'password' => 'required|min_length[4]|max_length[39]'
          ]);
          if ($form_validation->withRequest($this->request)->run()) {
            if ($this->login($_POST["email"], $_POST["password"])!=TRUE) {
              $data['salah'] = "<font color='red'>Username atau password tidak ada!</font>";
              // return redirect()->to(site_url().'admin');
            }else{
              return redirect()->to(site_url().'adm');
            }

          }
        }

        return view('login/index.php', $data);
      }else{
        $data['title'] = "Register";
        //register
        if ($this->request->getPost("submit") == "submit") {

          $form_validation->setRules([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'email' => 'required',
            'password' => 'required|min_length[4]|max_length[39]'
          ]);

          if($form_validation->withRequest($this->request)->run() && $banyak_user == 0){
            $userdata = [
              "nama_depan" => $_POST["nama_depan"],
              "nama_belakang" =>  $_POST["nama_belakang"],
              "username" =>  $_POST["email"],
              "email" =>  $_POST["email"],
              "password" =>  $this->bcrypt->encrypt($_POST["password"],$this->bcrypt_version),
              "level" => 1,
              "status" => 1
            ];
            $userModel->insert($userdata);
            // return redirect()->to($_SERVER['REQUEST_URI'], 'refresh');
            return redirect()->to(site_url().'adm');
          }
        }
        //register
        return view('login/register.php', $data);
      }
    }
  }

    function _make_sure_is_admin(){
    $Mdl_user = new \App\Models\Mdl_user();
    if (isset($_SESSION['auth']) && $this->_make_sure_is_login()) {
      if ($Mdl_user->check_admin_active($_SESSION['auth']['email'])) {
        return TRUE;
      }else{
        return FALSE;
      }
    }else{
      return redirect()->to(base_url('admin'));
    }
  }
  public function login($email,$password){
  $userModel = new \App\Models\MdlUser();
  $admin_data = $userModel->get_cipherpass($email);
  $ip = $_SERVER['REMOTE_ADDR'];
  $riwayat = "ilegal login dari ip : $ip dengan email: $email , password: $password";
  if ($admin_data != NULL) {
    if($this->bcrypt->verify($password, $admin_data['password'])){
      $data_login = [
        'nama' => $admin_data['nama_depan'].' '.$admin_data['nama_belakang'],
        'user' => $admin_data['email'],
        'level' => $admin_data['level'],
        'id' => $admin_data['id'],
        'status'=> TRUE
      ];
      $this->session->set('login_data', $data_login);
      $nama = $this->session->get('login_data')['nama'];
      $login = "$nama berhasil login";
      $this->changelog($login);
      return TRUE;
    }else{
      $this->changelog($riwayat);

      return FALSE;
    }
  }else {
    $this->changelog($riwayat);
    return FALSE;
  }
}
function _make_sure_is_login(){
  if (isset($_SESSION['login_data'])) {
    return TRUE;
  }else{
    return FALSE;
  }
}
  function changelog($riwayat){
    if (isset($_SESSION['auth'])) {
      $nama_admin = $_SESSION['auth']['name'];
      $id_admin = $_SESSION['auth']['id'];
    }else{
      $nama_admin = "Unknown user";
      $id_admin = 0;
    }

    $ip = $_SERVER['REMOTE_ADDR'];
    $changelog = ['nama_admin'=> $nama_admin,
    'ip'=>$ip,
    'created_at'=>date("Y-m-d H:i:s"),
    'updated_at'=>date("Y-m-d H:i:s"),
    'riwayat'=> $riwayat,
  ];
  $builder_changelog = $this->db->table('changelog');
  $builder_changelog->insert($changelog);
  return true;
}
  function logout(){
    Session()->destroy();
    return Redirect()->to('adm');
  }

























}
