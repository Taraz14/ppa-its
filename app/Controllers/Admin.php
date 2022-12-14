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
    $this->uri = service('uri');
    helper('form');
  }
  function get_name($table){
    $query = $this->db->query("SELECT * FROM $table");

    foreach ($query->getFieldNames() as $field) {
      echo '"'.$field.'",';
    }
  }
  public function index(){

    $form_validation = \Config\Services::validation();
    $userModel = new \App\Models\MdlUser();
    $banyak_user = 0;
    if ($this->_make_sure_is_login()) {
     $data['title'] = "Dashboard";
     $data['title_desc'] = "Dashboard";
     $data['uri1'] = $this->uri->getSegment(1);
     $data['uri2'] = $this->uri->getSegment(2);
     $profile['profile'] = $userModel->get()->getResultArray();
     $data['content'] = view('admin/content/dashboard.php', $profile);
     return view('admin/index', $data);
   }else{

    if ($this->request->getPost("submit") == "submit") {
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $secret = $_ENV['recaptchaSecretKey'];
      $response = $this->request->getPost("token_generate");
      $request = file_get_contents($url.'?secret='.$secret.'&response='.$response);
      $result = json_decode($request);

      $form_validation->setRules([
        'email' => 'required|min_length[4]|max_length[39]',
        'password' => 'required|min_length[4]|max_length[39]'
      ]);
      if ($form_validation->withRequest($this->request)->run()) {
        if ($result->success) {
          $email = $_POST['email'];
          $password = $_POST['password'];
          $user = $userModel->get_cipherpass($email);

          if ($user['password'] != NULL || $user['password'] != '' ) {
            if ($user !=NULL && $this->bcrypt->verify($password, $user['password'])) {
              $data_user = [
                'id' => $user['id'],
                'nama_depan'=> $user['nama_depan'],
                'nama_belakang'=> $user['nama_belakang'],
                'name'=> $user['nama_depan']." ".$user['nama_belakang'],
                'email'=> $user['email'],
                'picture'=> $user['profile_picture']
              ];
                    // Session()->destroy();
              $userModel->where(array("email"=> $email, 'deleted_at'=>NULL));
              $profile = $userModel->get()->getResultArray();
              $this->session->set('profile', $profile);
              $this->session->set('login_data', $data_user);
              return redirect()->to('/adm');
            }else{
              $this->session->setFlashdata('login_error', "Login Failed: Incorrect username or password");
            }
          }else{
            $this->session->setFlashdata('login_error', "Password tidak ada: Silakan login dengan google account");

          }

        }
      }else{
        $this->session->setFlashdata('login_error', "Login Failed: minimal 4 karakter");
      }
    }
    $data['error'] = "";
    $google_client = new \Google_Client();

      $google_client->setClientId($_ENV['ClientID']); //Define your ClientID

      $google_client->setClientSecret($_ENV['ClientSecret']); //Define your Client Secret Key

      $google_client->setRedirectUri("http://development.sl/adm"); //Define your Redirect Uri

      $google_client->addScope('email');

      $google_client->addScope('profile');
      $data['login_link'] = $google_client->createAuthUrl();
      if (isset($_GET['code'])) {
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
        if(isset($token['access_token'])){
          $google_client->setAccessToken($token['access_token']);
          $Oauth = new \Google_Service_Oauth2($google_client);
          $userInfo = $Oauth->userinfo->get();
          Session()->auth = $userInfo;


          if ($userInfo) {
            if ($userModel->where(array('email' => $userInfo['email'],'deleted_at'=>NULL))->countAllResults() > 0) {
              //login
              $data_user_select = $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->get()->getResultArray()[0];
              if (($data_user_select['nama_depan'] != $userInfo['givenName']) or ($data_user_select['profile_picture'] != $userInfo['picture'])) {
                $data_sync['nama_depan'] = $userInfo['givenName'];
                $data_sync['nama_belakang'] = $userInfo['familyName'];
                $data_sync['profile_picture'] = $userInfo['picture'];
                $userModel->set($data_sync);
                $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL));
                $userModel->update();
              }
              $userModel->where(array("email"=> $_SESSION['auth']['email'],'deleted_at'=>NULL));
              $profile = $userModel->get()->getResultArray();
              $this->session->set('profile', $profile);
              $riwayat = "User ".$userInfo['name']." berhasil login kembali";
              $this->changelog($riwayat);

              // if ( $profile[0]['status'] == 1) {
              //   if ( $profile[0]['level'] == 3) {

              //   }else{
              //     $this->session->setFlashdata('login_error', "Anda bukan Administrator, silakan hubungi Administrator untuk meminta halaman login");
              //   }
              // }else{
              //   $this->session->setFlashdata('login_error', "User tidak aktif, silakan hubungi Administrator");
              // }
              $this->session->set('login_data', $data_user_select);

            }else{
              //register
              if ($userModel->countAllResults() == 0) {
                $data_baru['email'] = $userInfo['email'];
                $data_baru['nama_depan'] = $userInfo['givenName'];
                $data_baru['nama_belakang'] = $userInfo['familyName'];
                $data_baru['profile_picture'] = $userInfo['picture'];
                $data_baru['status'] = 1;
                $data_baru['level'] = 1;
                $userModel->insert($data_baru);
                $riwayat = "User ".$userInfo['name']." berhasil terdaftar sebagai Administrator";
                $this->changelog($riwayat);
                $this->session->set('login_data', $data_baru);

              }else{
                // $data_baru['email'] = $userInfo['email'];
                // $data_baru['nama_depan'] = $userInfo['givenName'];
                // $data_baru['nama_belakang'] = $userInfo['familyName'];
                // $data_baru['profile_picture'] = $userInfo['picture'];
                // $data_baru['status'] = 0;
                // $data_baru['level'] = 0;
                // $userModel->insert($data_baru);
                // $riwayat = "User ".$userInfo['name']." berhasil terdaftar sebagai User(belum terverifikasi)";
                // $this->changelog($riwayat);
                $riwayat = "User ".$userInfo['name']." Login gagal, (user tidak terdaftar)";
                $this->session->setFlashdata('login_error', "unauthorized google account.");

              }
            }
          }

          return redirect()->to('/adm');
        }
      }
      $auth = Session()->auth;
      $data['reCaptcha3Key'] = $_ENV['recaptchaSiteKey'];
      if ($userModel->countAllResults() == 0) {
        return view('login/register', $data);
      }else{
        return view('login/index', $data);

      }
    }
  }

  function _make_sure_is_admin(){
    $Mdl_user = new \App\Models\MdlUser();
    if (isset($_SESSION['auth']) && $this->_make_sure_is_login()) {
      if ($Mdl_user->check_admin_active($_SESSION['auth']['email'])) {
        return TRUE;
      }else{
        return FALSE;
      }
    }else{
      return redirect()->to(base_url('adm'));
    }
  }
    function _make_sure_is_operator(){
    $Mdl_user = new \App\Models\MdlUser();
    if (isset($_SESSION['auth']) && $this->_make_sure_is_login()) {
      if ($Mdl_user->check_operator_active($_SESSION['auth']['email'])) {
        return TRUE;
      }else{
        return FALSE;
      }
    }else{
      return redirect()->to(base_url('adm'));
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
public function administrator(){
  if ($this->_make_sure_is_login()) {
    $data['title'] = "Administrator";
    $data['title_desc'] = "Manage administrator website";
    $data['uri1'] = $this->uri->getSegment(1);
    $data['uri2'] = $this->uri->getSegment(2);
    $profile['profile'] = $_SESSION['profile'][0];
      //code

      //code
    $data['content'] = view('admin/content/administrator.php', $profile);
    return view('admin/index', $data);
  }else{
      return redirect()->to(base_url('adm'));

  }
}
public function categories(){
  if ($this->_make_sure_is_login()) {
    $data['title'] = "Categories";
    $data['title_desc'] = "Manage Categories menu";
    $data['uri1'] = $this->uri->getSegment(1);
    $data['uri2'] = $this->uri->getSegment(2);
    $profile['profile'] = $_SESSION['profile'][0];
      //code

      //code
    $data['content'] = view('admin/content/categories.php', $profile);
    return view('admin/index', $data);
  }else{
      return redirect()->to(base_url('adm'));
    
  }
}
public function categories_data(){
  if ($this->_make_sure_is_admin()) {
    $serverside_model = new \App\Models\MdlDatatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
      //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
      //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    //"id","categories","updated_at","deleted_at","created_at"
    $column_order = array(NULL,'categories.categories','categories.id');
    $column_search = array('categories.categories');
    $order = array('categories.id' => 'desc');
    $list = $list_data->get_datatables('categories', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->categories;
      $row[] = $lists->id;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('categories', $where),
      "recordsFiltered" => $list_data->count_filtered('categories', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }else{
    return redirect()->to(site_url().'adm');
  }
}

public function data_administrator(){
  if ($this->_make_sure_is_admin()) {
    $serverside_model = new \App\Models\MdlDatatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $level = $_POST['level'];
    if ($level == "all") {
      $where = ['id !=' => 0, 'deleted_at'=>NULL];
    }else{
      $where = ['level' => $level,];
    }
      //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
      //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'user.nama_depan','user.profile_picture','user.level','user.status','user.id');
    $column_search = array('user.nama_depan','user.nama_belakang','user.email','user.id');
    $order = array('user.id' => 'desc');
    $list = $list_data->get_datatables('user', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->nama_depan;
      $row[] = $lists->nama_belakang;
      $row[] = $lists->email;
      $row[] = $lists->id;
      $row[] = $lists->level;
      $row[] = $lists->status;
      $row[] = $lists->profile_picture;
      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('user', $where),
      "recordsFiltered" => $list_data->count_filtered('user', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }else{
    return redirect()->to(site_url().'adm');
  }
}

public function client(){
  if ($this->_make_sure_is_login()) {
    $data['title'] = "Dashboard";
    $profile['profile'] = $_SESSION['profile'][0];
    $data['content'] = view('admin/content/user.php', $profile);
    return view('admin/index', $data);
  }
}
function reset_password(){
  if ($this->_make_sure_is_admin()) {
    $db      = \Config\Database::connect();
    $builder = $db->table('user');
    $form_validation = \Config\Services::validation();
    $form_validation->setRules([
      'password' => 'required|min_length[4]|max_length[39]'
    ]);
    if ($form_validation->withRequest($this->request)->run()) {

      $id = $_POST["id"];
      $password = $_POST["password"];
      $builder->set('password', $this->bcrypt->encrypt($password, $this->bcrypt_version));
      $builder->where('id', $id);
      if ($builder->update()) {
        $riwayat = "Mengubah password Admin id: $id menjadi $password";
        $this->changelog($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR, gagal mengubah password', 'code' => 4)));
      }

    }else{
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'ERROR, Password harus lebih dari 4 karakter, max 39', 'code' => 5)));
    }
  }
} 

function ubah_level_user(){
  if ($this->_make_sure_is_admin()) {
      // code...

    $id = $_POST['id'];
    $level = $_POST['level'];
    $data_level = array('level' => $level );
    $mdl = new \App\Models\MdlUser();
    $mdl->set($data_level);
    $mdl->where('id',$id);
    $mdl->update();
    if ($mdl->affectedRows()>0) {
      $riwayat = "Mengubah status user id: $id dengan level $level ";
      $this->changelog($riwayat);
      header('HTTP/1.1 200 OK');
    }else {
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
    }
  }else{
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ADMIN privilege is required', 'code' => 2)));
  }
}
function ubah_status_user(){
  if ($this->_make_sure_is_admin()) {
      // code...

    $id = $_POST['id'];
    $status = $_POST['status'];
    $data_status = array('status' => $status );
    $mdl = new \App\Models\MdlUser();
    $mdl->set($data_status);
    $mdl->where('id',$id);
    $mdl->update();
    if ($mdl->affectedRows()>0) {
      $riwayat = "Mengubah status user id: $id dengan status $status ";
      $this->changelog($riwayat);
      header('HTTP/1.1 200 OK');
    }else {
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
    }
  }else{
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ADMIN privilege is required', 'code' => 2)));
  }
}
function hapus_user(){
  if ($this->_make_sure_is_admin()) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $mdl = new \App\Models\MdlUser();
    $mdl->where('id',$id);
    $mdl->delete();
    if ($mdl->affectedRows()!=0) {
      $riwayat = "Menghapus user $nama";
      $this->changelog($riwayat);
      header('HTTP/1.1 200 OK');
    }else {
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
    }
  }else{
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ADMIN privilege is required', 'code' => 2)));
  }
}
function tambah_admin(){
  if ($this->_make_sure_is_admin()) {
    $userInfo = $_SESSION['auth'];
    $userModel = new \App\Models\MdlUser();
    $userdata = [
      "email" =>  $_POST["email"],
      "password" =>  $this->bcrypt->encrypt($_POST["password"],$this->bcrypt_version),
      "level" => 2,
      "status" => 1
    ];
    if ($userModel->createNewUser($userdata)) {
      $riwayat = "User ".$userInfo['name']." menambahkan user: ".$_POST['email']."sebagai Admin";
      header('HTTP/1.1 200 OK');
    }else{
      $riwayat = "User ".$userInfo['name']." gagal menambahkan user: ".$_POST['email'];
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'User exist, gagal menambahkan data.', 'code' => 3)));
    }
    $this->changelog($riwayat);
  }
}


















}
