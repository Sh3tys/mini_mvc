<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;

class ConnectController extends Controller
{
    public function login(): void
    {
        $this->render('connect/login', [
            'title' => 'Connexion',
        ]);
    }

        public function logout(): void
    {
        $this->render('connect/logout', [
            'title' => 'Déconnexion',
        ]);
    }

}