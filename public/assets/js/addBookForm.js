var addBookForm = {
    init: function() {
        console.log('addBookForm');
        $('#search_book').select2({
            placeholder: 'Les Misérables Victor Hugo',
            width: '100%',
            ajax: {
                url: '/book-search',
                data: function (params) {
                    console.log('ajax');
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    console.log(query);

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    console.log(data);
                    return {
                        results: data
                    };
                }
            }
        });

    },
};

document.addEventListener('DOMContentLoaded', addBookForm.init);
