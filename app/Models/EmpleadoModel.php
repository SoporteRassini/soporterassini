<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpleadoModel extends Model
{
    protected $table      = 'empleado';
    protected $primaryKey = 'Id_Empleado';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'Nombres',
        'ApellidoP',
        'ApellidoM',
        'UserName',
        'Correo',
        'PasswordHash'
    ];
}
