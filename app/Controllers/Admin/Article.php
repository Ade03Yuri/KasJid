<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Article extends BaseController{
    function index(){
        $data=[];
        $data['templateJudul'] = "Halaman Article";
        echo view('admin/v_article',$data);
    }
}
