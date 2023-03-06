<?php

namespace task2;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//var_dump($_FILES);

$email = $_POST['email'];
$name = $_POST['name'];
$number = $_POST['number'];
$pathFile = mb_strlen($_FILES['file']['name']) != 0
    ? './upload/'.$_FILES['file']['name']
    : null;


if(isset($pathFile)){
    if ($_FILES['file']['error'] != UPLOAD_ERR_OK){
        echo 'Error upload file';
        exit;
    }
}

if (isset($pathFile)){
    move_uploaded_file($_FILES['file']['tmp_name'], $pathFile);
}

if(mb_strlen($email) == 0 || mb_strlen($name) == 0 || mb_strlen($number) == 0){
    echo "Fill in the required fields";
    exit;
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo "Incorrect email";
    exit;
}


$mailer = new PHPMailer(true);

try{

    $mailer->isSMTP();
    $mailer->SMTPAuth = true;

    $mailer->Host = "smtp.yandex.ru";
    $mailer->SMTPSecure = 'tls';
    $mailer->Port = 587;

    $mailer->Username = "MribisuX673@yandex.ru";
    $mailer->Password = "awonaponawonasan";


    $mailer->setFrom("MribisuX673@yandex.ru", $name);
    $mailer->addAddress($email);
    $mailer->Subject = 'Theme';
    $mailer->Body = $number;

    if (isset($pathFile)){
        $mailer->addAttachment($pathFile);
    }

    $mailer->send();

}catch (Exception $e){
    echo $e->errorMessage();
}

echo "Message send";


