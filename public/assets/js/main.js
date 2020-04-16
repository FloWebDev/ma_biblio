var main = {
    init: function() {
        // Ecouteurs sur les boutons de suppression
        document.querySelectorAll('.btn_delete').forEach(btn => {
            btn.addEventListener('click', main.handleClickToDelete);
        });
    },
    handleClickToDelete: function(e) {
        // Si non confirmation de la suppression, on stoppe le clic de suppression
        if (!confirm('Confirmez la suppression.')) {
            e.preventDefault();
        }
    }
};
document.addEventListener('DOMContentLoaded', main.init);