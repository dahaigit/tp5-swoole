<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        var_dump($_GET);
        echo 'index function';
    }

    public function show()
    {
        echo 'show';
    }
}
