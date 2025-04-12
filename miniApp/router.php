<?php
$router = [
    "profil" => "/pages/profil.php",
    "admin" => "/pages/admin.php",
    "connexion" => "/pages/connexion.php",
    "deconnexion" => "/pages/deconnexion.php",
    "inscription" => "/pages/inscription.php",
    "404" => "/pages/404.php"
];

// Récupérer la page demandée
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : "inscription";

// Vérifier si la page existe
if (isset($router[$page])) {
    include_once __DIR__ . $router[$page];
} else {
    include_once __DIR__ . $router["404"];
}
