<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EquipoComputoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EquipoComputo extends BaseController
{
    protected $equipoModel;

    public function __construct()
    {
        $this->equipoModel = new EquipoComputoModel();
        helper(['form', 'url']);
    }

    // public function index()
    // {
    //     $data = [
    //         'equipos' => $this->equipoModel->findAll(),
    //     ];

    //     return view('Panel/EquipoComputo', $data);
    // }
    public function index()
{
    $q = $this->request->getGet('q');

    $builder = $this->equipoModel;
    if ($q) {
        $builder = $builder
            ->groupStart()
                ->like('Id_activo', $q)
                ->orLike('Nom_Activo', $q)
                ->orLike('Ip_equipo', $q)
            ->groupEnd();
    }

    $data = [
        'equipos' => $builder->findAll(),
        'q'       => $q,
    ];

    return view('Panel/EquipoComputo', $data);
}


    public function guardar()
    {
        // Reglas para crear
        $rules = [
            'Id_activo'  => 'required|integer|is_unique[equipo_computo.Id_activo]',
            'Nom_Activo' => 'required|max_length[80]',
            'Ip_equipo'  => 'permit_empty|valid_ip|is_unique[equipo_computo.Ip_equipo]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->equipoModel->insert([
            'Id_activo'  => $this->request->getPost('Id_activo'),
            'Nom_Activo' => $this->request->getPost('Nom_Activo'),
            'Ip_equipo'  => $this->request->getPost('Ip_equipo') ?: null,
        ]);

        return redirect()->to(site_url('equipos'))
            ->with('success', 'Equipo registrado correctamente.');
    }

    public function actualizar($id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound('Equipo no encontrado.');
        }

        $equipo = $this->equipoModel->find($id);

        if (! $equipo) {
            throw PageNotFoundException::forPageNotFound('Equipo no encontrado.');
        }

        // --------- Reglas dinámicas ---------

        // IP: sólo se verifica UNIQUE si cambió
        $ipPost = $this->request->getPost('Ip_equipo');
        $ipRule = 'permit_empty|valid_ip';

        if ($ipPost !== $equipo['Ip_equipo']) {
            $ipRule .= '|is_unique[equipo_computo.Ip_equipo]';
        }

        // Id_activo: sólo se verifica UNIQUE si cambió
        $idActivoPost = $this->request->getPost('Id_activo');
        $idActivoRule = 'required|integer';

        if ($idActivoPost !== $equipo['Id_activo']) {
            $idActivoRule .= '|is_unique[equipo_computo.Id_activo]';
        }

        $rules = [
            'Id_activo'  => $idActivoRule,
            'Nom_Activo' => 'required|max_length[80]',
            'Ip_equipo'  => $ipRule,
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Actualiza usando Id_activo como PK (lo que tienes en el modelo)
        $this->equipoModel->update($id, [
            'Id_activo'  => $idActivoPost,
            'Nom_Activo' => $this->request->getPost('Nom_Activo'),
            'Ip_equipo'  => $ipPost ?: null,
        ]);

        return redirect()->to(site_url('equipos'))
            ->with('success', 'Equipo actualizado correctamente.');
    }

    public function eliminar($id = null)
    {
        if ($id === null || ! $this->equipoModel->find($id)) {
            throw PageNotFoundException::forPageNotFound('Equipo no encontrado.');
        }

        $this->equipoModel->delete($id);

        return redirect()->to(site_url('equipos'))
            ->with('success', 'Equipo eliminado correctamente.');
    }
    public function buscar()
{
    $texto = $this->request->getGet('q');

    $equipos = $this->equipoModel
        ->like('Id_activo', $texto)
        ->orLike('Nom_Activo', $texto)
        ->orLike('Ip_equipo', $texto)
        ->findAll();

    $data = [
        'equipos' => $equipos,
        'q'       => $texto,
    ];

    return view('Panel/EquipoComputo', $data);
}

}
