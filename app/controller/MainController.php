<?php

namespace Controller;

use App\System\Library\Controller;

class MainController extends Controller
{
    public function index()
    {
        $this->view('main/index', ['title' => 'Hello!']);
    }
}
