<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
require '../../../constantes.php';

// DECLARA UNA VARIABLE DE RESPUESTA
$response = array(
    'status' => 0,
    'message' => ''
);

// VALIDA EL CAMPO NOMBRE
if (!empty(trim($_POST['nombre']))) {
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING);
} else {
    $response['message'] .= 'El campo nombre es requerido. </br>';
}

// VALIDA EL CAMPO EMAIL
if (!empty(trim($_POST['email'])) || filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
} else {
    $response['message'] .= 'El campo email es requerido. </br>';
}

// VALIDA EL CAMPO TELEFONO
if (!empty(trim($_POST['telefono'])) || filter_var(trim($_POST['telefono']), FILTER_VALIDATE_INT) || strlen(trim($_POST['telefono'])) == 8) {
    $telefono = "+569".filter_var(trim($_POST['telefono']), FILTER_SANITIZE_NUMBER_INT);
} else {
    $response['message'] .= 'El campo telefono es requerido. </br>';
}

// VALIDA EL CAMPO AREA DE DESEMPEÑO
if (!empty(trim($_POST['area']))) {
    $area = filter_var(trim($_POST['area']), FILTER_SANITIZE_STRING);
    switch ($area) {
        case "Administrativa": break;
        case "Clínica": break;
        default:
            $response['message'] .= 'El Area de desempeño: '.$area.' es inválida. </br>';
            break;
    }
} else {
    $response['message'] .= 'El campo Area de desempeño es requerido. </br>';
}

// CUERPO DEL MENSAJE
if($response['message'] == ''){

    $mail = new PHPMailer(); // PHPMailer

    // VALIDA ADJUNTO
    if($mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name'])){
        try {
            // 0 -> Sin mensajes de debug
            // 1 -> Diálogo de cliente a servidor
            // 2 -> Diálogo de cliente a servidor y viceversa
            // 3 -> Códigos de estado de cada fase de la conexión, además del diálogo entre cliente y servidor/servidor y cliente
            // 4 -> Devuelve a bajo nivel toda la traza de la conversación entre cliente y servidor SMTP
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = EMAIL_USER;
            $mail->Password = EMAIL_USER_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //MENSAJE A ENVIAR
            $mail->setFrom(EMAIL_USER, 'Notificacion InverSalud');
            $mail->addAddress(EMAIL_INVERSALUD_FINANZAS);
            $mail->addCC($email);
            $mail->isHTML(true);

            //ASUNTO
            $mail->Subject = 'Solicitud de postulacion: '.$area;

            //CUERPO
            $mail->ChartSet = 'utf-8';
            $mail->Body = "<b>Nombre: </b>".$nombre."<br>" . "<b>Email: </b>".$email."<br>" . "<b>Telefono: </b>".$telefono."<br>" . "<b>Area de desempeño: </b>".$area;

            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );

            //ENVIAR E-MAIL
            if($mail->send()) {
                $response['status'] = 1;
                $response['message'] .= 'Mensaje enviado.';
                echo json_encode($response);
            } else {
                $response['message'] .= 'No se pudo enviar el mensaje... '.$mail->ErrorInfo;
            }
        } catch (Exception $exception) {
            $response['message'] .= 'Algo salio mal, excepcion: ' . $exception->getMessage();
        }
    } else {
        $response['message'] .= 'Error al adjuntar el archivo. </br>';
    }
}

// Return response
echo json_encode($response);
?>