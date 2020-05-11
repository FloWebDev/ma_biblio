document.addEventListener('DOMContentLoaded', function() {
    // Formulaire de connexion
    if (document.querySelector('#wrapper i')) {
        document.querySelector('#wrapper i').addEventListener('click', function(e) {
            var inputPassword = document.querySelector('#inputPassword');
    
            // Gestion de l'affichage du mot de passe
            if(inputPassword.type == 'password') {
                inputPassword.type = 'text';
                e.target.classList.remove('fa-eye');
                e.target.classList.add('fa-eye-slash');
            } else {
                inputPassword.type = 'password';
                e.target.classList.remove('fa-eye-slash');
                e.target.classList.add('fa-eye');
            }
        });
    }

    // Formulaire d'inscription et modification
    // Mot de passe
    if (document.querySelector('#wrapper_first_password i')) {
        document.querySelector('#wrapper_first_password i').addEventListener('click', function(e) {
            var inputPassword = document.querySelector('#user_password_first');
    
            // Gestion de l'affichage du mot de passe
            if(inputPassword.type == 'password') {
                inputPassword.type = 'text';
                e.target.classList.remove('fa-eye');
                e.target.classList.add('fa-eye-slash');
            } else {
                inputPassword.type = 'password';
                e.target.classList.remove('fa-eye-slash');
                e.target.classList.add('fa-eye');
            }
        });
    }
    // Confirmation mot de passe
    if (document.querySelector('#wrapper_second_password i')) {
        document.querySelector('#wrapper_second_password i').addEventListener('click', function(e) {
            var inputPassword = document.querySelector('#user_password_second');
    
            // Gestion de l'affichage du mot de passe
            if(inputPassword.type == 'password') {
                inputPassword.type = 'text';
                e.target.classList.remove('fa-eye');
                e.target.classList.add('fa-eye-slash');
            } else {
                inputPassword.type = 'password';
                e.target.classList.remove('fa-eye-slash');
                e.target.classList.add('fa-eye');
            }
        });
    }
});