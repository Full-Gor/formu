<?php
// Définir des variables pour les messages
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['connexion'])) {
        $prenom = htmlspecialchars($_POST["prenom"] ?? '');
        $password = $_POST["password"] ?? '';

        if (empty($prenom) || empty($password)) {
            $error_message = "Veuillez remplir tous les champs";
        } else {
            // Vérifier si l'utilisateur existe dans la base de données
            $sql = "SELECT * FROM utilisateurs WHERE prenom = :prenom";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':prenom' => $prenom]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                // Authentification réussie
                $_SESSION["id"] = $user['id'];
                $_SESSION["prenom"] = $user['prenom'];
                $_SESSION["nom"] = $user['nom'];

                $_SESSION["connected"] = true;

                // Rediriger vers la page de profil
                header("location: profil");
                exit();
            } else {
                // Authentification échouée
                $error_message = "prenom ou mot de passe incorrect";
            }
        }
    }
}

// Pour pré-remplir le prenom s'il existe déjà
$formPrenom = htmlspecialchars($_POST['prenom'] ?? '');
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6 text-center bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">Connexion</h1>

            <?php if ($error_message): ?>
                <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-4">
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prenom</label>
                    <input type="text" id="prenom" value="<?= $formPrenom ?>" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <input type="submit" name="connexion" value="Se connecter" class="w-full px-4 py-2 rounded-md font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:shadow-lg hover:shadow-blue-300 transition-all duration-300 cursor-pointer">
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Vous n'avez pas de compte ?
                    <a href="inscription" class="text-blue-600 hover:underline">Inscrivez-vous</a>
                </p>
            </div>
        </div>
    </div>
</div>