var contact = {
    init: function() {
        // Affichage du formulaire de contact
        contact.displayForm();
        // Utilisation de MutationObserver
        contact.observe();
    },
    displayForm: function() {
        // On affiche le formulaire d'ajout manuel
        $.ajax({
            type: 'POST',
            url: urlContact,
            data: {},
            dataType: "json",
            async: true,
            cache: false,
            headers: {
                "cache-control": "no-cache"
                },
            success: function(data)
            {
                if (data.form) {
                    // On ajoute la view du formulaire dans la DIV prévue à cet effet
                    document.querySelector('#contact_form_container').innerHTML = data.form;
                } else {
                    // DEBUG
                    console.log(data);
                }
            },
            fail: function(e) {
                console.log('Erreur Serveur');
                console.log(e);
            }
        });
    },
    handleSubmit: function(e) {
        // On stoppe la soumission du formulaire
        e.preventDefault();

        // Gestion du formulaire de contact
        var $form = $(e.currentTarget);
        console.log($form);
        $.ajax({
            type: 'POST',
            url: e.target.getAttribute('action'),
            data: $form.serialize(),
            dataType: "json",
            async: true,
            cache: false,
            headers: {
                "cache-control": "no-cache"
            },
            success: function(data)
            {
                console.log(data);
                if(!data.success) {
                    // En cas d'erreur dans la soumission du formulaire
                    if (data.form) {
                        // On réaffiche la view du formulaire contenant les messages d'erreurs
                        document.querySelector('#contact_form_container').innerHTML = data.form;
                    } else {
                        // DEBUG
                        console.log(data);
                    }
                } else {
                    // En cas de succès
                    // window.location.reload();
                    console.log(document.querySelector('#contact_flash_message div').style.display);
                    document.querySelector('#contact_flash_message div').style.display = 'block';
                    document.querySelector('#contact_flash_message div').textContent = 'Message envoyé avec succès.';
                    $('#contact_flash_message div').fadeOut(10000);
                    contact.displayForm();
                }
            },
            fail: function(e) {
                console.log('Erreur Serveur');
                console.log(e);
            }
        });
    },
    observe: function() {
        /**
         * MutationObserver
         * @link https://developer.mozilla.org/fr/docs/Web/API/MutationObserver
         */
        // Selectionne le noeud dont les mutations seront observées
        var targetNode = document.getElementById('contact_form_container');

        // Options de l'observateur (quelles sont les mutations à observer)
        var config = { attributes: true, childList: true, subtree: true };

        // Créé une instance de l'observateur lié à la fonction de callback
        var observer = new MutationObserver((mutationsList) => {
            // Fonction callback à éxécuter quand une mutation est observée
            for(var mutation of mutationsList) {
                if (mutation.type == 'childList') {
                    if (document.querySelector('#contact_form_container form')) {
                        document.querySelector('#contact_form_container form').addEventListener('submit', contact.handleSubmit);
                    }
                }
            }
        });

        // Commence à observer le noeud cible pour les mutations précédemment configurées
        observer.observe(targetNode, config);
    }
};

document.addEventListener('DOMContentLoaded', contact.init);