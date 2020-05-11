var addBookForm = {
    init: function() {
        // Gestion de Select2
        addBookForm.initSelect2();
        $('#search_book').on('select2:select', addBookForm.handleSelect);
        $('#search_book').on('select2:unselect', addBookForm.handleUnselect);
        $('#search_book').on('select2:open', addBookForm.handleOpen);
        // $('#search_book').val(null).trigger("change");

        // Bouton d'action pour ouvrir le formulaire d'ajout manuel
        $('#manual_add_book_action').on('click', addBookForm.handleClickManualAddBook);
        
        // Boutons d'action pour les formulaires d'update
        document.querySelectorAll('.update_book_btn').forEach(btn => {
            btn.addEventListener('click', addBookForm.handleClickBookUpdate);
        });

        // Boutons d'action pour la suppression d'un livre
        document.querySelectorAll('.book_delete_action').forEach(btn => {
            btn.addEventListener('click', addBookForm.handleClickDelete);
        });

        // Action lorsque la modal est fermée
        $('#form_add_book').on('hidden.bs.modal', addBookForm.handleHiddenModal);

        // Utilisation du Mutation Observer
        addBookForm.observe();

    },
    initSelect2: function() {
        // Mise en place du Select2
        $('#search_book').select2({
            placeholder: 'Recherche par titre, auteur',
            allowClear: true,
            width: '100%',
            language: {
                searching: function () {
                    return 'Recherche en cours... Un peu de patience ;-)';
                },
                noResults: function () {
                    return 'Aucun résultat';
                },
                removeAllItems: function() {
                    return 'Supprimer la sélection';
                },
                errorLoading: function() {
                    return 'Les résultats ne peuvent pas être chargés';
                }
            },
            ajax: {
                url: urlAjaxBookApi,
                method: "POST",
                // The number of milliseconds to wait for the user to stop typing before
                // issuing the ajax request.
                delay: 750,
                dataType: "json",
                async: true,
                cache: false,
                headers: {
                    "cache-control": "no-cache"
                  },
                data: function (params) {
                    var query = {
                        search: params.term,
                        fr: document.querySelector('#search_book_fr').checked
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data ? data : ''
                    };
                }
            }
        });
    },
    handleSelect: function (e) {
        // On récupère les données du livre sélectionné
        var bookData = e.params.data;

        $.ajax({
            type: 'POST',
            url: urlAddAutoBook,
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
                    document.querySelector('#content_add_book_form').innerHTML = data.form;

                    // Pour chaque champ, on attribue la valeur
                    for (const field in bookData) {
                        valueBook = bookData[field];
                        if (document.querySelector('#book_' + field)) {
                            document.querySelector('#book_' + field).value = valueBook;
                        }

                        if (field == 'image' && valueBook != null) {
                            document.querySelector('#book_image_form').src = valueBook;
                        }
                    }
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
    handleUnselect: function() {
        // En cas de désélection, on supprime tout le contenu associé au formulaire d'ajout (auto ou manuel)        
        document.querySelector('#content_add_book_form').innerHTML = '';
    },
    handleOpen: function() {
        /**
        * @link https://stackoverflow.com/questions/16310588/how-to-clean-completely-select2-control
        * 
        * To clean completely a select2 (>= v4) component:
        * $('#sel').val(null).empty().select2('destroy')
        * val(null) -> remove select form data
        * empty -> remove select options
        * select2(destroy) -> remove select2 plugin
        *  */
        if ($('#search_book').val() != '') {
            $('#search_book').val(null).empty();
        }
    },
    handleSubmit: function(e) {
        // On stoppe la soumission du formulaire
        e.preventDefault();

        // Gestion du formulaire
        var $form = $(e.currentTarget);
        $.ajax({
            type: 'POST',
            url: e.target.getAttribute('action'),
            data: $form.serialize(),
            dataType:"json",
            async: true,
            cache: false,
            headers: {
                "cache-control": "no-cache"
              },
            success: function(data)
            {
                if(!data.success) {
                    // En cas d'erreur dans la soumission du formulaire
                    if (data.form) {
                        // On réaffiche la view du formulaire contenant les messages d'erreurs
                        document.querySelector('#content_add_book_form').innerHTML = data.form;
                    }
                    if (data.message) {
                        document.querySelector('#add_book_alert').classList.remove('alert-success');
                        document.querySelector('#add_book_alert').classList.add('alert-danger');
                        document.querySelector('#add_book_alert').textContent = data.message;
                        document.querySelector('#add_book_alert').style.display = 'block';
                        $('#add_book_alert').fadeOut(4000);
                    }
                } else {
                    // En cas de succès
                    document.querySelector('#content_add_book_form').innerHTML = ''; // On supprime le formulaire
                    document.querySelector('#add_book_alert').classList.remove('alert-danger');
                    document.querySelector('#add_book_alert').classList.add('alert-success');
                    document.querySelector('#add_book_alert').textContent = 'Livre ajouté';
                    document.querySelector('#add_book_alert').style.display = 'block';
                    $('#add_book_alert').fadeOut(4000);
                }
            },
            fail: function(e) {
                console.log('Erreur Serveur');
                console.log(e);
            }
        });
    },
    handleClickManualAddBook: function() {
        // On affiche le formulaire d'ajout manuel
        $.ajax({
            type: 'POST',
            url: urlAddManualBook,
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
                    document.querySelector('#content_add_book_form').innerHTML = data.form;
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
    handleClickBookUpdate: function(e) {
        // On renseigne le titre et l'image
        document.querySelector('#update_book h2').textContent = e.target.dataset.title.trim();
        document.querySelector('#update_book img').src = e.target.dataset.src.trim();

        // On affiche le formulaire de modfication
        $.ajax({
            type: 'POST',
            url: e.target.dataset.urlUpdate,
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
                    document.querySelector('#content_update_book_form').innerHTML = data.form;
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
    handleUpdateSubmit: function(e) {
        // On stoppe la soumission du formulaire
        e.preventDefault();

        // Gestion du formulaire
        var $form = $(e.currentTarget);
        $.ajax({
            type: 'POST',
            url: e.target.getAttribute('action'),
            data: $form.serialize(),
            dataType:"json",
            async: true,
            cache: false,
            headers: {
                "cache-control": "no-cache"
              },
            success: function(data)
            {
                if(!data.success) {
                    // En cas d'erreur dans la soumission du formulaire
                    if (data.form) {
                        // On réaffiche la view du formulaire contenant les messages d'erreurs
                        document.querySelector('#content_update_book_form').innerHTML = data.form;
                    } else {
                        // DEBUG
                        console.log(data);
                    }
                } else {
                    // En cas de succès, on réactualise la page en cours
                    window.location.reload();
                }
            },
            fail: function(e) {
                console.log('Erreur Serveur');
                console.log(e);
            }
        });
    },
    handleClickDelete: function(e) {
        // On renseigne le titre et l'url permettant la suppression du livre
        document.querySelector('#content_delete_book_form h4').textContent = e.target.dataset.title;
        document.querySelector('#delete_confirmation_btn').href = e.target.dataset.urlDelete;
    },
    observe: function() {
        /**
         * MutationObserver 
         * @link https://developer.mozilla.org/fr/docs/Web/API/MutationObserver
         */ 

        // Selectionne le noeud dont les mutations seront observées
        var targetNode = document.querySelector('#book_modals');

        // Options de l'observateur (quelles sont les mutations à observer)
        var config = { attributes: true, childList: true, subtree: true };

        // Créé une instance de l'observateur lié à la fonction de callback
        var observer = new MutationObserver(mutationsList => {
            // Fonction callback à éxécuter quand une mutation est observée
            for(var mutation of mutationsList) {
                if (mutation.type == 'childList') {
                    // console.log('Un noeud enfant a été ajouté ou supprimé.');
                    if (document.querySelector('#book_info_form')) {
                        console.log('THERE1');
                        document.querySelector('#book_info_form').addEventListener('submit', addBookForm.handleSubmit);
                    }
                    if (document.querySelector('#book_update_form')) {
                        console.log('THERE2');
                        document.querySelector('#book_update_form').addEventListener('submit', addBookForm.handleUpdateSubmit);
                    }
                }
            }
        });

        // Commence à observer le noeud cible pour les mutations précédemment configurées
        observer.observe(targetNode, config);
    },
    handleHiddenModal: function() {
        // if (document.querySelector('#add_first_book')) {
            // On recharge la page uniquement si aucun livre n'était précédemment enregistré
            // window.location.reload();
        // }
        // Si la modal est fermé, on réactualise sur la page en cours
        window.location.reload();
    },
};

document.addEventListener('DOMContentLoaded', addBookForm.init);

// Important de le faire sur le DOMContentLoaded, sinon risque de multiplication 
// des écouteurs dans init si on clique plusieurs fois sur le bouton sans aucun rechargement de page
// document.querySelectorAll('[data-target="#form_add_book"]').forEach(btn => {
//     btn.addEventListener('click', addBookForm.init);
// });
