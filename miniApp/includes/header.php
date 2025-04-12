<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/styles.css" />
    <!-- Ajout de Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Script pour les animations -->
    <style>
        /* Animations personnalisées */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-item-hover:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            transition: width 0.3s ease;
        }

        .nav-item-hover:hover:after {
            width: 80%;
        }

        .menu-appear {
            animation: fadeIn 0.3s ease forwards;
        }

        /* S'assurer que les champs input sont cliquables */
        input,
        textarea,
        select,
        button {
            pointer-events: auto !important;
        }

        /* Correction pour éviter les problèmes de z-index */
        .fixed {
            z-index: 999;
        }
    </style>
</head>

<body>
    <header id="main-header" class="fixed w-full z-50 transition-all duration-500 py-4 bg-transparent">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent transition-transform duration-300 hover:scale-105">

                    </a>
                </div>



                <!-- Navigation pour bureau -->
                <nav class="hidden md:block">
                    <ul class="flex space-x-1">
                        <?php if (isset($_SESSION['connected']) && $_SESSION['connected']) { ?>
                            <li class="relative">
                                <a href="profil" class="nav-item-hover px-4 py-2 rounded-full font-medium text-gray-700 hover:text-blue-600 transition-all duration-300 flex items-center">
                                    Profil
                                </a>
                            </li>
                            <li class="relative">
                                <a href="admin" class="nav-item-hover px-4 py-2 rounded-full font-medium text-gray-700 hover:text-blue-600 transition-all duration-300 flex items-center">
                                    Admin
                                </a>
                            </li>
                            <li class="relative">
                                <a href="deconnexion" class="nav-item-hover px-4 py-2 rounded-full font-medium text-gray-700 hover:text-blue-600 transition-all duration-300 flex items-center">
                                    Déconnexion
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="relative">
                                <a href="connexion" class="px-4 py-2 rounded-full font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:shadow-lg hover:shadow-blue-300 transition-all duration-300 flex items-center">
                                    Connexion
                                </a>
                            </li>
                            <li class="relative">
                                <a href="inscription" class="nav-item-hover px-4 py-2 rounded-full font-medium text-gray-700 hover:text-blue-600 transition-all duration-300 flex items-center">
                                    Inscription
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>

                <!-- Bouton de menu mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu mobile -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 bg-white rounded-lg shadow-lg overflow-hidden">
                <ul class="py-2">

                    <li>
                        <a href="/pages/profil.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-300">
                            Profil
                        </a>
                    </li>
                    <li>
                        <a href="/pages/admin.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-300">
                            admin
                        </a>
                    </li>
                    <?php if (isset($_SESSION['connected']) && $_SESSION['connected']) { ?>
                        <li>
                            <a href="/pages/deconnexion.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-300">
                                Déconnexion
                            </a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="/pages/connexion.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-300">
                                Connexion
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </header>

    <main>