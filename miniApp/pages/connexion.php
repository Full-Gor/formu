<?php
// Définir une variable pour le message d'erreur
$error_message = "";
$connection_success = false; // Pour suivre si la connexion a réussi

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['connexion'])) {
        $email = htmlspecialchars($_POST["email"] ?? '');
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            $error_message = "Veuillez remplir tous les champs";
        } else {
            // Vérifier si l'utilisateur existe dans la base de données
            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                // Authentification réussie
                $_SESSION["id"] = $user['id'];
                $_SESSION["prenom"] = $user['prenom'];
                $_SESSION["nom"] = $user['nom'];
                $_SESSION["email"] = $user['email'];
                $_SESSION["connected"] = true;

                $connection_success = true; // Marquer la connexion comme réussie

                // Rediriger vers la page de profil après un court délai
                header("Refresh: 2; URL=profil");
            } else {
                // Authentification échouée
                $error_message = "Email ou mot de passe incorrect";
            }
        }
    }
}

// Pour pré-remplir l'email s'il existe déjà
$formEmail = htmlspecialchars($_POST['email'] ?? '');
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

            <?php if ($connection_success): ?>
                <div class="mb-4 p-2 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    Connexion réussie ! Redirection en cours...
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" value="<?= $formEmail ?>" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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

<!-- Script pour la synthèse vocale en cas de connexion réussie -->
<?php if ($connection_success): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attendre un peu avant de démarrer la synthèse vocale
            setTimeout(function() {
                // Créer un objet de synthèse vocale
                const synth = window.speechSynthesis;
                const utterance = new SpeechSynthesisUtterance("La connexion a bien été établie");

                // Configurer la voix pour qu'elle soit plus robotique
                utterance.rate = 0.9; // Vitesse de parole (0.1 à 10)
                utterance.pitch = 0.8; // Hauteur de la voix (0 à 2)

                // Choisir une voix en français si disponible
                const voices = synth.getVoices();
                const frenchVoices = voices.filter(voice => voice.lang.includes('fr'));
                if (frenchVoices.length > 0) {
                    utterance.voice = frenchVoices[0];
                }

                // Prononcer le message
                synth.speak(utterance);
            }, 500);
        });
    </script>
<?php endif; ?>