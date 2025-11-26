<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/contact', [
            'title' => 'Page de contact',
        ]);
    }
}
