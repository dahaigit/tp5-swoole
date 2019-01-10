<?php
namespace app\mhl;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require '../../vendor/autoload.php';

class Email
{
    public $mail;
    public function __construct() {
        $this->mail = new PHPMailer(true);
    }

    /**
     * 发送邮件
     * @param $toEmail
     * @author mhl
     */
    public function send($toEmail='2210411072@qq.com')
    {
        $mail = $this->mail;                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'a2210411072@163.com';                 // SMTP username
            $mail->Password = 'mhl12345678';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('a2210411072@163.com', '大海网络');
            $mail->addAddress($toEmail, '大海');     // Add a recipient
//            $mail->addAddress('ellen@example.com');               // Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            //Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = '大海app验证码，打死不要告诉别人！';
            $mail->Body    = '你的验证码为：<b>112233</b>';
            $mail->AltBody = '';

            $mail->send();
        } catch (Exception $e) {
            throw $e;
        }
    }
}

