<?php
/*
 * This class will handle mail system, which requires php mail() enabled
 * NOTE: It is better using PHPMailer, since it provide a secure protocol (SMTPS),
 *  PHP.mail() will only send unencrypted message.
 * And I was trying to use PHPMailer lib for sending mails to user, but this lib doesn't work on sandcastle,
 * since sandcastle disabled the 'httpd_can_network_connect'.
 */
function sendMail($email, $msg, $id) {
    $subject = "Ticket REQ-" . $id . " has been created.";
    $message = '<html><body>';
    $message .= '<p>Hello,</p>';
    $message .= '<p>Your Ticket <strong>REQ-' . $id . '</strong> has been created</p>';
    $message .= '<p>-----------------------------------------</p>';
    $message .= '<i>' . $msg . '</i>';
    $message .= '<p>-----------------------------------------</p>';
    $message .= '<p>The ticket has been assigned and an agent will be in contact with you. </p>';
    $message .= '</body></html>';

    $headers = "Reply-To: work@johnzhou.info\n";
    $headers .= "Return-Path: work@johnzhou.info\n";
    $headers .= "Organization: Brock University\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-Mailer: PHP \n";
    mail($email, $subject, $message, $headers);
}

function sendReplyMail($email, $msg, $reply, $reply_by, $id, $status) {
    $subject = "Ticket REQ-" . $id . " has been replied";
    $message = '<html><body>';
    $message .= '<p>Hello,</p>';
    $message .= '<p>Your Ticket <strong>REQ-' . $id . '</strong> has been replied by <strong>' . $reply_by .
        '</strong> and mark as <strong>' . $status . '</strong></p>';
    $message .= '<p>-----------------------------------------</p>';
    $message .= '<p>' . $reply . '</p>';
    $message .= '<p>-----------------------------------------</p>';
    $message .= '<p>Your message:</p>';
    $message .= '<i>' . $msg . '</i>';
    $message .= '</body></html>';

    $headers = "Reply-To: work@johnzhou.info\n";
    $headers .= "Return-Path: work@johnzhou.info\n";
    $headers .= "Organization: Brock University\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-Mailer: PHP \n";
    mail($email, $subject, $message, $headers);
}