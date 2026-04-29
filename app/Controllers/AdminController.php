<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin;

class AdminController extends BaseController
{
    public function login()
    {
        // Affiche la vue de connexion
        return view('login'); // <-- Juste 'login', pas 'login.html' ni 'login.php'
    }

    public function authenticate()
    {
        $session = session();
        $model = new Admin();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('mot_de_passe'); // Adaptez avec le name de votre input

        $admin = $model->where('email', $email)->first();

        if ($admin) {
            // Comparaison simple pour l'exemple. 
            // En production, utilisez password_verify() avec des mots de passe hashés.
            if ($password === $admin['mot_de_passe']) {
                $sessionData = [
                    'id_admin'  => $admin['id_admin'],
                    'nom'       => $admin['nom'],
                    'prenom'    => $admin['prenom'],
                    'email'     => $admin['email'],
                    'isLoggedIn' => true,
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard'); // Redirige vers le tableau de bord
            } else {
                $session->setFlashdata('error', 'Mot de passe incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email introuvable.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}