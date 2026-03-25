<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage de l'email
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    
    // Page depuis laquelle le formulaire a été soumis
    $source = isset($_POST["source_page"]) ? htmlspecialchars($_POST["source_page"]) : "Site Web";

    // Vérification de la validité de l'email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Paramètres de l'email
        $to = "benjamin@ansamb.re";
        $subject = "[benjaminpayet.fr] Nouveau contact ou prospect !";
        $message = "Félicitations, vous avez reçu un nouvel email depuis votre site web.\n\n";
        $message .= "Email récolté : " . $email . "\n";
        $message .= "Depuis la page : " . $source . "\n";
        
        $headers = "From: noreply@benjaminpayet.fr\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        
        // Envoi de l'email
        if(mail($to, $subject, $message, $headers)) {
            // Retour sur la page avec un message de succès
            $referer = explode('?', $_SERVER['HTTP_REFERER'])[0];
            header("Location: " . $referer . "?status=success#newsletter");
        } else {
            $referer = explode('?', $_SERVER['HTTP_REFERER'])[0];
            header("Location: " . $referer . "?status=error#newsletter");
        }
        exit;
    } else {
        $referer = explode('?', $_SERVER['HTTP_REFERER'])[0];
        header("Location: " . $referer . "?status=invalid#newsletter");
        exit;
    }
} else {
    // Si on accède au fichier directement sans le formulaire
    header("Location: /index.html");
    exit;
}
?>
