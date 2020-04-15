var addBookForm = {
    init: function() {
        console.log('addBookForm');

        $('#search_book').select2({
            placeholder: 'Les Misérables Victor Hugo',
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
                    console.log('ajax');
                    var query = {
                        search: params.term,
                        fr: document.querySelector('#search_book_fr').checked
                    }

                    console.log(query);

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    console.log('DATA');
                    console.log(data);
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data ? data : null
                    };
                }
            }
        });

        // document.querySelector('#add_book').addEventListener('click', function() {
        //     console.log('click');
        //     document.querySelector('#search_book').click();
        // });
    },
};

document.addEventListener('DOMContentLoaded', addBookForm.init);
