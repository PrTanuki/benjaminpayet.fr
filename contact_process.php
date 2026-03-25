<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message_client = htmlspecialchars(trim($_POST["message"]));
    
    // Vérification basique
    if (!empty($nom) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $to = "benjamin@ansamb.re";
        $subject = "[Blueprint] Nouveau contact : " . $nom;
        
        $message = "Une nouvelle transmission a été initialisée depuis benjaminpayet.fr !\n\n";
        $message .= "📋 NOM : " . $nom . "\n";
        $message .= "✉️ EMAIL : " . $email . "\n";
        $message .= "🎯 BRIEF / MESSAGE :\n" . $message_client . "\n";
        
        $headers = "From: benjamin@ansamb.re\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        
        // Envoi
        if(mail($to, $subject, $message, $headers)) {
            // Redirection vers contact avec popup de succès
            header("Location: /contact.html?status=success");
        } else {
            header("Location: /contact.html?status=error");
        }
        exit;
    } else {
        header("Location: /contact.html?status=invalid");
        exit;
    }
} else {
    // Si on accède au script sans envoyer le formulaire
    header("Location: /contact.html");
    exit;
}
?>
