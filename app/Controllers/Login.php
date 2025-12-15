<?php

namespace App\Controllers;

use App\Models\EmpleadoModel;

class Login extends BaseController
{
    public function index()
    {
        $request  = service('request');
        $username = $request->getCookie('remember_username'); 
        $remember = !empty($username);

        return view('Panel/Login', [
            'username' => $username,
            'remember' => $remember
        ]);
    }

    public function auth()
    {
        $session = session();
        $model   = new EmpleadoModel();

        $login    = $this->request->getPost('username'); // usuario o correo
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        if (empty($login) || empty($password)) {
            $session->setFlashdata('error', 'Debes ingresar usuario o correo y contraseña.');
            return redirect()->back()->withInput();
        }

        // Buscar por UserName O por Correo
        $empleado = $model
            ->groupStart()
                ->where('UserName', $login)
                ->orWhere('Correo', $login)
            ->groupEnd()
            ->first();

        if (!$empleado) {
            $session->setFlashdata('error', 'Usuario/correo o contraseña incorrectos.');
            return redirect()->back()->withInput();
        }

        // Comparar contraseña (SHA-256)
        $hash = hash('sha256', $password);

        if ($hash !== $empleado['PasswordHash']) {
            $session->setFlashdata('error', 'Usuario/correo o contraseña incorrectos.');
            return redirect()->back()->withInput();
        }

        // ==============================
        //   OBTENER ROL DEL EMPLEADO
        // ==============================
        $db = \Config\Database::connect();

        $tecnico = $db->table('tecnico')
            ->select('tecnico.Id_Rol, rol.Tipo_Rol')
            ->join('rol', 'rol.Id_Rol = tecnico.Id_Rol')
            ->where('tecnico.Id_Empleado', $empleado['Id_Empleado'])
            ->get()
            ->getRowArray();

        // Construir nombre completo con las columnas de la BD
        $nombreCompleto = $empleado['Nombres'] . ' ' . $empleado['ApellidoP'] . ' ' . $empleado['ApellidoM'];

        // Guardar sesión (mantengo lo que ya tenías y agrego rol)
        $sessionData = [
            'idEmpleado'     => $empleado['Id_Empleado'],
            'userName'       => $empleado['UserName'],
            'nombreCompleto' => $nombreCompleto,
            'isLoggedIn'     => true,

            // Nuevos datos de rol
            'rol_id'         => $tecnico['Id_Rol']   ?? null,
            'rol_nombre'     => $tecnico['Tipo_Rol'] ?? null, // 'Administrador' u 'operador'
        ];

        $session->set($sessionData);

        // Manejo de "Recuérdame"
        if ($remember) {
            setcookie('remember_username', $login, time() + 60*60*24*30, "/");
        } else {
            setcookie('remember_username', '', time() - 3600, "/");
        }

        // SweetAlert de bienvenida
        session()->setFlashdata('success', 'Bienvenido de nuevo, ' . $nombreCompleto);

        // Redirigir al panel
        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        setcookie('remember_username', '', time() - 3600, "/");
        return redirect()->to('/login');
    }
}
