$(function() {
    function showAccountDetail(userId) {
        $.ajax({
            url: '../api/tasks/get_tasks.php',
            type: 'GET',
            data: { identifiant: userId },
            dataType: 'json',
            success: function(tasks) {

                let container_stats = $('#stats');
                container_stats.empty();

                container_stats.append(`
                    <p>Nombre de Tâche : ${tasks.length}</p>
                    <p>Nombre de Tâche commencé : ${tasks.filter((t) => t.status == "En Cours").length}
                    <p>Nombre de Tâche Terminé : ${tasks.filter((t) => t.finished == 1).length}
                `);
            },
            error: function(xhr) {
                console.error(xhr.status);
            }
        });


        let container = $('#delete_account');
        container.empty();
        let deleteAccount = `<button class="btn-delete" data-id="${userId}">Supprimer votre compte</button>`;
        container.append(`
            <p>${deleteAccount}
            <br><small>Attention : Cette action est irreversible, toutes les données lié à ce compte seront supprimées.</small></p>
        `)
    }

    let currentId = $('#user-info').attr('data-id');
    if (currentId) {
        showAccountDetail(currentId);
    }

    $(document).on('click', '.btn-delete', function() {
        let userId = $(this).data('id');

        $.ajax({
            url: '../api/users/delete_account.php',
            type: 'POST',
            data: { id: userId },
            dataType: 'json',
            success: function(response) {
                refreshCategories(currentId);
            }
        });
    });
});