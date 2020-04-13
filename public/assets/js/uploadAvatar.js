(function() {
    // Ecouteur au clic sur l'avatar
    document.querySelector('#avatar_profil').addEventListener('click', function() {
        // Action clic sur input file du formulaire
        document.querySelector('#form_avatar').click();
        // Ecouteur sur le changement de valeur de l'input
        document.querySelector('#form_avatar').addEventListener('change', function() {
            // Action soummission du formulaire
            document.querySelector('form#avatar_form').submit();
        })
    })
})();