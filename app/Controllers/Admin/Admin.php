<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Database\Migrations\inputkas;
use App\Models\AdminModel;
use App\Models\inputmodel;
use App\Models\keluaranmodel;

use App\Models\IncomeModel;
use App\Models\ExpenseModel;


class Admin extends BaseController
{   
    protected $m_admin;
    protected $validation;

    public function __construct()
    {
        $this->m_admin = new AdminModel();
        $this->validation = \Config\Services::validation();
        helper("cookie");
        helper("kasjid_helper");

    }

    public function login()
    {
        $data = [];
        
        // session
        if (get_cookie('cookie_username') && get_cookie("cookie_password")) {
            $username = get_cookie('cookie_username');
            $password = get_cookie('cookie_password');

            $dataAkun = $this->m_admin->getdata($username);

            if ($password != $dataAkun['password']) {
                $err[] = "Akun yang kamu masukkan tidak sesuai";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);

                delete_cookie('cookie_username');
                delete_cookie('cookie_password');
                echo view("admin/v_login", $data); // Display the view here
                return;
            }

            $akun = [
                'akun_username' => $username,
                'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
                'akun_email' => $dataAkun['email']
            ];

            session()->set($akun);
            return redirect()->to('admin/sukses');
        }

        if ($this->request->getMethod() == "post") {
            $rules = [
                'username' => ['rules' => 'required', 'errors' => ['required' => 'Username anda Harus DIISI']],
                'password' => ['rules' => 'required', 'errors' => ['required' => 'Password anda harus DIISI']]
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata("warning", $this->validation->getErrors());
                echo view("admin/v_login", $data); // Display the view here
                return;
            }

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $remember_me = $this->request->getVar('remember_me');

            $dataAkun = $this->m_admin->getdata($username);

            if (!password_verify($password, $dataAkun['password'])) {
                $err[] = "Akun yang anda masukan tidak sesuai.";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
                echo view("admin/v_login", $data); // Display the view here
                return;
            }

            if (!$remember_me == '1') {
                set_cookie("cookie_username", $username, 3600 * 24 * 30);
                set_cookie("cookie_password", $dataAkun['password'], 3600 * 24 * 30);
            }

            $akun = [
                'akun_username' => $dataAkun['username'],
                'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
                'akun_email' => $dataAkun['email']
            ];
            session()->setFlashdata($akun);
            return redirect()->to("admin/sukses")->withCookies();
            
        }

        echo view("admin/v_login", $data);
    }
    function sukses(){
        return redirect()->to('admin/article');
        
       
        // print_r(session()->get());
        // echo "ISIAN COOKIE USERNAME ".get_cookie("cookie_username")." DAN PASSWORD".
        // get_cookie("cookie_password");

    }

    public function logout()
{
    delete_cookie("cookie_username");
    delete_cookie("cookie_password");
    session()->destroy();
    if (session()->get('akun_username') != '') {
        session()->setFlashdata('success', "Anda Berhasil Logout"); // Corrected key
    }
    echo view('admin/v_login'); // Display the view here
}

public function lupapassword()
{
    $err = [];
    if ($this->request->getMethod() == 'post') {
        $username = $this->request->getVar('username');
        if ($username == '') {
            $err[] = "Silahkan masukkan username atau email yang anda punya";
        }
        
        // Hanya memanggil metode getdata jika tidak ada kesalahan sejauh ini
        if (empty($err)) {
            $data = $this->m_admin->getdata($username);
    
            if (empty($data)) {
                $err[] = "Akun yang kamu masukkan tidak terdaftar";
            }
        }
    
        // Memeriksa apakah masih ada kesalahan sebelum mengambil email dan mengirim email
        if (empty($err)) {
            $email = $data['email'];
            $token = md5(date('ymdhis'));

            $link = site_url("admin/resetpassword/?email=$email&token=$token");
            $attachment= "";
            $to =$email;
            $title="Reset password";
            $message= "Berikut ini adalah link untuk melakukan reset password anda";
            $message= "Silahkan klik link berikut ini $link";

            kirim_email($attachment, $to,$title, $message);
        

            $dateUpdate = [
                'email' => $email,
                'token' => $token
            ];


    
            // Memanggil metode updateData untuk menyimpan token ke database
            $this->m_admin->updatedata($dateUpdate);
    
            session()->setFlashdata("success", "Email Untuk Recovery sudah Dikirimkan");
        }
    
        if ($err) {
            session()->setFlashdata("username", $username);
            session()->setFlashdata("warning", $err);
        }
    
        return redirect()->to("admin/lupapassword");
    }
    

    echo view("admin/v_lupapassword");
}
function resetpassword()
{
    $err = [];
    $email = $this->request->getVar('email');
    $token = $this->request->getVar('token');
    if ($email != '' and $token != '') {
        $dataAkun = $this->m_admin->getData($email); //<-- cek di tabel admin
        if ($dataAkun['token'] != $token) {
            $err[] = "Token tidak valid";
        }
    } else {
        $err[] = "Parameter yang dikirimkan tidak valid";
    }

    if ($err) {
        session()->setFlashdata("warning", $err);
    }

    if ($this->request->getMethod() == 'post') {
        $aturan = [
            'password' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Panjang karakter minimum untuk password adalah 5 karakter'
                ]
            ],
            'konfirmasi_password' => [
                'rules' => 'required|min_length[5]|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'min_length' => 'Panjang karakter minimum untuk konfirmasi password adalah 5 karakter',
                    'matches' => 'Konfirmasi password tidak sesuai dengan password yang diisikan'
                ]
            ]
        ];

        if (!$this->validate($aturan)) {
            session()->setFlashdata('warning', $this->validation->getErrors());
        } else {
            $dataUpdate = [
                'email' => $email,
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'token' => null
            ];
            $this->m_admin->updateData($dataUpdate);
            session()->setFlashdata('success', 'Password berhasil direset, silakan login');

            delete_cookie('cookie_username');
            delete_cookie('cookie_password');

            return redirect()->to('admin/login')->withCookies();
        }
    }

    echo view("admin/v_resetpassword");
}
function inputkas(){

    $data = [];

    if ($this->request->getMethod() === 'post') {
        $kasMasjidModel = new inputmodel();

        $data = [
            'tgl_km'    => $this->request->getPost('tgl_km'),
            'uraian_km' => $this->request->getPost('uraian_km'),
            'masuk'     => preg_replace("/[^0-9]/", "", $this->request->getPost('masuk')),
            'keluar'    => 0,
            'jenis'     => 'Masuk',
        ];

        if ($kasMasjidModel->save($data)) {
            // Penyimpanan berhasil
            return redirect()->to(site_url('admin/inputkas'))->with('success', 'Tambah Data Berhasil');

        } else {
            // Penyimpanan gagal
            return redirect()->to(site_url('admin/inputkas'))->with('error', 'Tambah Data Gagal');
        }
    }

    // Jika bukan metode post, tampilkan form
    return view('admin/v_inputkas', $data);

    
}

function pengeluaran(){
    $data = [];

    if ($this->request->getMethod() === 'post') {
        $keluar = $this->request->getPost('keluar');
        $keluar_hasil = preg_replace("/[^0-9]/", "", $keluar);

        $kasMasjidModel = new keluaranmodel();

        $dataToInsert = [
            'tgl_km' => $this->request->getPost('tgl_km'),
            'uraian_km' => $this->request->getPost('uraian_km'),
            'masuk' => 0,
            'keluar' => $keluar_hasil,
            'jenis' => 'Keluar',
        ];

        if ($kasMasjidModel->insert($dataToInsert)) {
            // Redirect atau tampilkan pesan sukses
            return redirect()->to('admin/pengeluaran')->with('success', 'Tambah Data Berhasil');
        } else {
            // Redirect atau tampilkan pesan gagal
            return redirect()->to('admin/pengeluaran')->with('error', 'Tambah Data Gagal');
        }
    }

    // Tampilkan form jika tidak ada data yang disubmit
    return view('admin/v_pengeluaran', $data);
}
public function datakaskeluar()
{
    $keluaranModel = new KeluaranModel();
    $data['records'] = $keluaranModel->findAll(); // Ambil semua data dari tabel keluaran

    return view('admin/v_datakaskeluar', $data);
}
    


function datakasmasuk(){

    $kasMasjidModel = new InputModel();
        $data['data_tabel'] = $kasMasjidModel->findAll();

        return view('admin/v_datakasmasuk', $data);
}


function delete($id)
    {
        $kasMasjidModel = new InputModel();
        $kasMasjidModel->delete($id);

        return redirect()->to(('admin/v_datakaskeluar'))->with('success', 'Data berhasil dihapus');
    }

    
   
    public function rekapkas()
    {
        $data['incomeData'] = $this->getIncomeData();
        $data['expenseData'] = $this->getExpenseData();

        return view('admin/v_rekapkas', $data);
    }

    private function getIncomeData()
    {
        $incomeModel = new IncomeModel();
        $incomeData = $incomeModel->findAll();

        return $incomeData;
    }

    private function getExpenseData()
    {
        $expenseModel = new ExpenseModel();
        $expenseData = $expenseModel->findAll();

        return $expenseData;
    }



function laporankas(){
    echo view('admin/v_laporankas');
}
function index(){
    echo view('admin/index');
}
function about(){
    echo view('admin/about');
}
function contact(){
    echo view('admin/contact');
}
function post(){
    echo view('admin/post');
}


}