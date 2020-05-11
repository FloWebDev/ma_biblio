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

    // Gestion de l'indicateur lié au RepeatedType pour le mot de passe
    if (document.querySelector('#user_password_first') && document.querySelector('#user_password_second')) {
        var yellow = '#F7F46B';
        var green = '#83C951';

        document.querySelector('#user_password_first').addEventListener('keyup', function(e) {
            let value = e.target.value;

            if (value != '' && value.length > 0) {
                e.target.style.backgroundColor = yellow;
                document.querySelector('#user_password_second').style.backgroundColor = yellow;

                if (value.length >= 8 && value == document.querySelector('#user_password_second').value) {
                    e.target.style.backgroundColor = green;
                    document.querySelector('#user_password_second').style.backgroundColor = green;
                }
            }
        });

        document.querySelector('#user_password_second').addEventListener('keyup', function(e) {
            let value = e.target.value;

            if (value != '' && value.length > 0) {
                e.target.style.backgroundColor = yellow;
                document.querySelector('#user_password_first').style.backgroundColor = yellow;

                if (value.length >= 8 && value == document.querySelector('#user_password_first').value) {
                    e.target.style.backgroundColor = green;
                    document.querySelector('#user_password_first').style.backgroundColor = green;
                }
            }
        });
    }
});