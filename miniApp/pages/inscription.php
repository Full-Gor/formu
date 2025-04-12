<?php
// Définir des variables pour les messages
$error_message = "";
$success_message = "";

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['inscription'])) {
    // Récupération et nettoyage des données du formulaire
    $prenom = htmlspecialchars($_POST['prenom'] ?? '');
    $nom = htmlspecialchars($_POST['nom'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validation de base
    if (empty($prenom) || empty($nom) || empty($password)) {
        $error_message = "Tous les champs sont obligatoires";
    } elseif ($password !== $password_confirm) {
        $error_message = "Les mots de passe ne correspondent pas";
    } elseif (strlen($password) < 6) {
        $error_message = "Le mot de passe doit contenir au moins 6 caractères";
    } else {
        // Vérifier si l'utilisateur existe déjà
        $check_sql = "SELECT id FROM utilisateurs WHERE prenom = :prenom AND nom = :nom";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom
        ]);

        if ($check_stmt->rowCount() > 0) {
            $error_message = "Cet utilisateur existe déjà";
        } else {
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertion dans la base de données
            $insert_sql = "INSERT INTO utilisateurs (prenom, nom, mot_de_passe) VALUES (:prenom, :nom, :mot_de_passe)";
            $insert_stmt = $pdo->prepare($insert_sql);

            try {
                $insert_stmt->execute([
                    ':prenom' => $prenom,
                    ':nom' => $nom,
                    ':mot_de_passe' => $hashed_password
                ]);

                // Inscription réussie
                $success_message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";

                // Rediriger vers la page de connexion après 2 secondes
                header("Refresh: 2; URL=connexion");
            } catch (PDOException $e) {
                $error_message = "Erreur lors de l'inscription : " . $e->getMessage();
            }
        }
    }
}

// Variables pour conserver les valeurs du formulaire en cas d'erreur
$formNom = htmlspecialchars($_POST['nom'] ?? '');
$formPrenom = htmlspecialchars($_POST['prenom'] ?? '');
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6 text-center bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">Inscription</h1>

            <?php if ($error_message): ?>
                <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="mb-4 p-2 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-4">
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input type="text" id="prenom" value="<?= $formPrenom ?>" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" id="nom" value="<?= $formNom ?>" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <input type="submit" name="inscription" value="S'inscrire" class="w-full px-4 py-2 rounded-md font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:shadow-lg hover:shadow-blue-300 transition-all duration-300 cursor-pointer">
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="connexion" class="text-blue-600 hover:underline">Connectez-vous</a>
                </p>
            </div>
        </div>
    </div>
</div>