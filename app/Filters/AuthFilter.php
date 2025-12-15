<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si el usuario NO ha iniciado sesión
        if (!session()->get('isLoggedIn')) {

            // Crear mensaje de alerta
            session()->setFlashdata('error', 'Debes iniciar sesión para acceder.');

            // Redirigir al login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada después
    }
}
