<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;

class AboutController extends Controller
{
    /**
     * Affiche la page À propos
     */
    public function index(): void
    {
        $this->render('about/about', [
            'title' => 'À Propos - SparkleLoop',
        ]);
    }
}