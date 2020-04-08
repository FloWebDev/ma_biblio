document.addEventListener('DOMContentLoaded', function() {
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
});