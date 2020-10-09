<?php


class MainController extends Controller
{
    public function index()
    {
        $this->view('main/index', ['title' => 'Hello!']);
    }
}
