 <!-- Votre contenu principal ici -->
 </main>

 <script>
     // Script pour le menu mobile
     const mobileMenuButton = document.getElementById('mobile-menu-button');
     const mobileMenu = document.getElementById('mobile-menu');

     mobileMenuButton.addEventListener('click', () => {
         if (mobileMenu.classList.contains('hidden')) {
             mobileMenu.classList.remove('hidden');
             mobileMenu.classList.add('menu-appear');
             mobileMenuButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
         } else {
             mobileMenu.classList.add('hidden');
             mobileMenuButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>';
         }
     });

     // Script pour changer le header au défilement
     window.addEventListener('scroll', () => {
         const header = document.getElementById('main-header');

         if (window.scrollY > 10) {
             header.classList.remove('py-4', 'bg-transparent');
             header.classList.add('py-2', 'bg-white', 'bg-opacity-90', 'shadow-lg', 'backdrop-blur-sm');
         } else {
             header.classList.add('py-4', 'bg-transparent');
             header.classList.remove('py-2', 'bg-white', 'bg-opacity-90', 'shadow-lg', 'backdrop-blur-sm');
         }
     });

     // Script pour s'assurer que les champs de saisie sont cliquables
     document.addEventListener('DOMContentLoaded', function() {
         // Corriger le problème d'input en s'assurant que le header ne bloque pas les inputs
         const inputs = document.querySelectorAll('input, textarea, select');
         inputs.forEach(input => {
             input.style.zIndex = '1000';
             input.style.position = 'relative';

             // S'assurer que les événements sont bien capturés
             input.addEventListener('click', function(e) {
                 e.stopPropagation();
             });

             input.addEventListener('focus', function(e) {
                 e.stopPropagation();
             });
         });
     });
 </script>
 </body>

 </html>