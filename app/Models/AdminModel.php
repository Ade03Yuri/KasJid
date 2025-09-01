<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = "admin";
    protected $primaryKey = "email";
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'token'];

    public function getdata($parameter)
    {
        $builder = $this->table($this->table);
        $builder->where('username', $parameter);
        $builder->orWhere('email', $parameter);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function updatedata($data)
    {
        $builder = $this->table($this->table);
        if ($builder->save($data)) { // Change 'save' to 'update'
            return true;
        } else {
            return false;
        }
    }
}
