var addBookForm = {
    init: function() {
        $('#search_book').select2({
            placeholder: 'Les Misérables Victor Hugo',
            allowClear: true,
            width: '100%',
            language: {
                searching: function () {
                    return "Recherche en cours... Un peu de patience ;-)";
                }
            },
            ajax: {
                url: '/book-search',
                method: "POST",
                // The number of milliseconds to wait for the user to stop typing before
                // issuing the ajax request.
                delay: 750,
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

        // setTimeout(() => {
        //     $('#search_book').select2('open');
        // }, 200);

        $('#search_book').on('select2:select', addBookForm.handleSelect);
        $('#search_book').on('select2:unselect', addBookForm.handleUnselect);
        $('#book_info_form').on('submit', addBookForm.handleSubmit);
    },
    handleSelect: function (e) {
        // On récupère les données du livre sélectionné
        let data = e.params.data;

        // On affiche le formulaire d'information du livre
        document.querySelector('#book_info_form').style.display = 'block';

        // Pour chaque champ, on attribue la valeur
        for (const field in data) {
            valueBook = data[field];

            if (document.querySelector('#' + field)) {
                document.querySelector('#' + field).value = valueBook;
            }

            if (field == 'image' && valueBook != null) {
                document.querySelector('#book_image_form').src = valueBook;
            }
        }
    },
    handleUnselect: function() {
        // Suppression des données dans tous les inputs
        document.querySelectorAll('#book_info_form input').forEach(input => {
            input.value = '';
        });
        // Suppression des données dans tous les textareas
        document.querySelectorAll('#book_info_form textarea').forEach(textarea => {
            textarea.value = '';
        });
        // On cache le formulaire d'information
        document.querySelector('#book_info_form').style.display = 'none';
    },
    handleSubmit: function(e) {
        // On stoppe la soumission du formulaire
        e.preventDefault();
        console.log('submit');
    }
};

// document.addEventListener('DOMContentLoaded', addBookForm.init);
document.querySelectorAll('[data-target="#form_add_book"]').forEach(btn => {
    btn.addEventListener('click', addBookForm.init);
});
