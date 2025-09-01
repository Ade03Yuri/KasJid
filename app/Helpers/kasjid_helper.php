<?php

function kirim_email($attachment, $to,$title, $message)
{
    $email = \Config\Services::email();
    $email_pengirim =EMAIL_ALAMAT;
    $email_nama = EMAIL_NAMA;

    $config['protocol'] = 'smtp';
    $config['SMTPHost'] = "smtp.gmail.com";
    $config['SMTPUser'] = $email_pengirim ;
    $config['SMTPPass'] = EMAIL_PASSWORD;
    $config["SMTPPort"] = 465;
    $config["SMTPCrypto"] = "ssl";
    $config["mailType"] = "html";
    
    $email->initialize($config);
    $email->setFrom($email_pengirim, $email_nama);
    $email->setTo($to);

    if($attachment){
        $email->attach($attachment);
    }
    $email->setSubject($title);
    $email->setMessage($message);

    if($email->send()){
        $data =$email->printDebugger(['headers']);
        print_r($data);
        return false;
    }
        else{
            return true;
        }
}


?>