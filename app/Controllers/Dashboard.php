<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        return view('dashboard', [
            'title' => 'SysInfo — Tableau de bord',
            'activePage' => 'dashboard',
        ]);
    }
}
