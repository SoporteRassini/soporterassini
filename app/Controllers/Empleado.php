<?php

namespace App\Controllers;

use App\Models\EmpleadoModel;

class Empleado extends BaseController
{
    protected $empleadoModel;
    protected $session;

    public function __construct()
    {
        $this->empleadoModel = new EmpleadoModel();
        $this->session       = session();
        helper(['form']);
    }

    public function index()
    {
        $data = [
            'empleados' => $this->empleadoModel->findAll(),
            'empleadoEdit' => null, // para formulario vacío (alta)
        ];

        return view('Panel/CRUD_empleado', $data);
    }

    public function store()
    {
        $validationRules = [
            'Nombres'    => 'required|min_length[2]',
            'ApellidoP'  => 'required|min_length[2]',
            'ApellidoM'  => 'required|min_length[2]',
            'UserName'   => 'required|min_length[3]|is_unique[empleado.UserName]',
            'Correo'     => 'permit_empty|valid_email|is_unique[empleado.Correo]',
            'Password'   => 'required|min_length[6]',
            'Password2'  => 'required|matches[Password]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('Password');
        $data = [
            'Nombres'      => $this->request->getPost('Nombres'),
            'ApellidoP'    => $this->request->getPost('ApellidoP'),
            'ApellidoM'    => $this->request->getPost('ApellidoM'),
            'UserName'     => $this->request->getPost('UserName'),
            'Correo'       => $this->request->getPost('Correo') ?: null,
            'PasswordHash' => hash('sha256', $password), // igual que en MariaDB SHA2(,256)
        ];

        $this->empleadoModel->insert($data);

        $this->session->setFlashdata('success', 'Empleado registrado correctamente.');
        return redirect()->to(site_url('empleado'));
    }

    public function edit($id)
    {
        $empleado = $this->empleadoModel->find($id);

        if (!$empleado) {
            $this->session->setFlashdata('error', 'Empleado no encontrado.');
            return redirect()->to(site_url('empleado'));
        }

        $data = [
            'empleados'   => $this->empleadoModel->findAll(),
            'empleadoEdit'=> $empleado,
        ];

        return view('Panel/CRUD_empleado', $data);
    }

    public function update($id)
    {
        $empleado = $this->empleadoModel->find($id);
        if (!$empleado) {
            $this->session->setFlashdata('error', 'Empleado no encontrado.');
            return redirect()->to(site_url('empleado'));
        }

        $rules = [
            'Nombres'   => 'required|min_length[2]',
            'ApellidoP' => 'required|min_length[2]',
            'ApellidoM' => 'required|min_length[2]',
            'UserName'  => "required|min_length[3]|is_unique[empleado.UserName,Id_Empleado,{$id}]",
            'Correo'    => "permit_empty|valid_email|is_unique[empleado.Correo,Id_Empleado,{$id}]",
        ];

        // Si el usuario quiere cambiar contraseña
        $password     = $this->request->getPost('Password');
        $password2    = $this->request->getPost('Password2');

        if (!empty($password) || !empty($password2)) {
            $rules['Password']  = 'required|min_length[6]';
            $rules['Password2'] = 'required|matches[Password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'Nombres'   => $this->request->getPost('Nombres'),
            'ApellidoP' => $this->request->getPost('ApellidoP'),
            'ApellidoM' => $this->request->getPost('ApellidoM'),
            'UserName'  => $this->request->getPost('UserName'),
            'Correo'    => $this->request->getPost('Correo') ?: null,
        ];

        // Solo actualizar contraseña si se capturó una nueva
        if (!empty($password)) {
            $dataUpdate['PasswordHash'] = hash('sha256', $password);
        }

        $this->empleadoModel->update($id, $dataUpdate);

        $this->session->setFlashdata('success', 'Empleado actualizado correctamente.');
        return redirect()->to(site_url('empleado'));
    }

    public function delete($id)
    {
        $empleado = $this->empleadoModel->find($id);
        if (!$empleado) {
            $this->session->setFlashdata('error', 'Empleado no encontrado.');
            return redirect()->to(site_url('empleado'));
        }

        $this->empleadoModel->delete($id);
        $this->session->setFlashdata('success', 'Empleado eliminado correctamente.');
        return redirect()->to(site_url('empleado'));
    }

    public function buscar(){
        $texto = $this->request->getGet('q');

    $empleado = $this->empleadoModel
        ->like('Nombres', $texto)
        ->orLike('UserName', $texto)
        ->orLike('ApellidoP', $texto)
        ->orlike('ApellidoM', $texto)
        ->findAll();

    $data = [
        'empleado' => $empleado,
        'q'       => $texto,
    ];

    return view('Panel/CRUD_empleado', $data);
    }
}
