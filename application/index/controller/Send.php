<?php
namespace app\index\controller;

use app\mhl\Email;
use app\mhl\Util;

class Send
{
    use Util;
    /*
     * 发送邮件，本来是发送短信的，为了免费
     */
    public function index()
    {
        $email = request()->get('email');
        echo $email;
        echo 11;

//        $email = new Email($email);
//        $email->send();
//        $this->response();
    }
}






















