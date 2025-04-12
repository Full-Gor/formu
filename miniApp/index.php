<?php
ob_start(); // Commence la mise en mémoire tampon de sortie
session_start();
require_once "config/bdd.php";

// reste de votre code...

include_once 'includes/header.php';
include_once 'router.php';
include_once 'includes/footer.php';
ob_end_flush(); // Envoie le contenu mis en mémoire tampon
