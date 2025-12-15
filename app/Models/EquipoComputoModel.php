<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoComputoModel extends Model
{
    protected $table            = 'equipo_computo';
    protected $primaryKey       = 'Id_activo';   // Se usará Id_activo como clave primaria

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // IMPORTANTE: Se agrega Id_activo para poder guardarlo y editarlo desde el CRUD
    protected $allowedFields    = [
        'Id_activo',
        'Nom_Activo',
        'Ip_equipo'
    ];

    protected $useTimestamps    = false;

    // Validaciones base
    protected $validationRules = [
        'Id_activo'  => 'required|integer',
        'Nom_Activo' => 'required|max_length[80]',
        'Ip_equipo'  => 'permit_empty|valid_ip'
    ];

    protected $validationMessages = [
        'Id_activo' => [
            'required' => 'El Id_activo es obligatorio.',
            'integer'  => 'El Id_activo debe ser un número entero.'
        ],
        'Nom_Activo' => [
            'required'   => 'El nombre del activo es obligatorio.',
            'max_length' => 'El nombre del activo no puede superar los 80 caracteres.'
        ],
        'Ip_equipo' => [
            'valid_ip'   => 'La dirección IP no tiene un formato válido.'
        ],
    ];

    // ---------------------------------------
    // Métodos de apoyo (opcional)
    // ---------------------------------------

    // Traer equipo por su Id_activo
    public function getByIdActivo($idActivo)
    {
        return $this->where('Id_activo', $idActivo)->first();
    }

    // Si después usas JOIN con tabla activo, aquí puedes habilitarlo
    public function getEquiposConActivo()
    {
        return $this->select('equipo_computo.*')
                    ->findAll();
    }
}
