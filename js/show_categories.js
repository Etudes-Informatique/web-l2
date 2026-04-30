$(function() {
    function refreshCategories(userId) {
        $.ajax({
            url: '../api/categories/get_categories.php',
            type: 'GET',
            data: { identifiant: userId },
            dataType: 'json',
            success: function(categories) {
                categories = categories.categories;

                let container = $('#categories-container');
                container.empty();

                if (categories && categories.length > 0) {
                    categories.forEach(function(category) {
                        let deleteCategory = `<button class="btn-delete" data-id="${category.id}">Supprimer</button>`;
                        //TODO: let editCategory = `<button class="btn-edit" data-id="${category.id}">Modifier</button>`;

                        container.append(`
                            <div class="task-card" id="category-${category.id}">
                                <h3>${category.title}</h3>
                                <p>${deleteCategory}</p>
                                <div id="categories-editor-${category.id}"></div>
                            </div>
                        `);
                    });
                } else {
                    container.html("<p>Aucune catégorie à afficher.</p>");
                }
            },
            error: function(xhr) {
                console.error(xhr.status);
            }
        });
    }

    let currentId = $('#user-info').attr('data-id');

    $(document).on('click', '.btn-delete', function() {
        let categoryId = $(this).data('id');

        $.ajax({
            url: '../api/categories/delete_categories.php',
            type: 'POST',
            data: { id: categoryId },
            dataType: 'json',
            success: function(response) {
                refreshCategories(currentId);
            }
        });
    });

    if (currentId) {
        refreshCategories(currentId);
    }
});