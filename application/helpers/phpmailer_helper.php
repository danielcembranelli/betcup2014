<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function send_email($address, $subject, $message) {
    require_once("phpmailer/class.phpmailer.php");

    $mail = new PHPMailer();
    $body = utf8_decode($message);
    $mail->IsSMTP();
    $mail->FromName = utf8_decode("BetCup2014");
    $mail->From = "contato@plantao.com.br";
    $mail->Subject = utf8_decode($subject);
    $mail->AltBody = strip_tags(utf8_decode($message));
    $mail->MsgHTML($body);
    $mail->AddAddress($address);
    if ($mail->Send())
        return 1;
    else
        return 0;
    
//    $mail = new PHPMailer();
//    $body = utf8_decode($message);
//    $mail->IsSMTP();
//    $mail->SMTPAuth = true;
//    $mail->Host = "smtp.betcup2014.com.br";
//    $mail->Port = 587;
//    $mail->Username = "bet@betcup2014.com.br";
//    $mail->Password = "c1a99q2013";
//    $mail->Subject = utf8_decode($subject);
//    $mail->AltBody = strip_tags(utf8_decode($message));
//    $mail->MsgHTML($body);
//    $mail->AddAddress($address);
//    if ($mail->Send())
//        return 1;
//    else
//        return $mail->ErrorInfo;
}

?>