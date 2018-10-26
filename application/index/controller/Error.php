<?php
namespace app\index\controller;

class Error 
{
    public function index()
    {
        return error404();
    }

}