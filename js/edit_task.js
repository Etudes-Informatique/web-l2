$(document).on('click', '.btn-edit', function() {
    let taskId = $(this).data('id');
    let editorDiv = $(`#tasks-editor-${taskId}`);

    $.ajax({
        url: '../api/categories/get_categories.php',
        type: 'GET',
        dataType: 'json',
        success: function(catResponse) {
            
            $.ajax({
                url: '../api/tasks/get_task_id.php',
                type: 'GET',
                data: { id: taskId },
                dataType: 'json',
                success: function(task) {
                    if (task.error) {
                        alert(task.error);
                        return;
                    }

                    editorDiv.empty().append(`
                        <form class="form-update-task" data-id="${taskId}" style="margin-top:10px; border-top:1px solid #ccc; padding-top:10px;">
                            <input type="text" name="title" value="${task.title}" required style="width:100%;">
                            <textarea name="description" required style="width:100%;">${task.description}</textarea>
                            
                            <label>Priorité :</label>
                            <select name="priority" style="width:100%;">
                                <option value="Basse" ${task.priority === 'Basse' ? 'selected' : ''}>Basse</option>
                                <option value="Moyenne" ${task.priority === 'Moyenne' ? 'selected' : ''}>Moyenne</option>
                                <option value="Haute" ${task.priority === 'Haute' ? 'selected' : ''}>Haute</option>
                            </select>

                            <label>Catégorie :</label><br>
                            <select name="category_id" class="task-category-select" style="width:100%;">
                                <option value="">-- Aucune catégorie --</option>
                            </select>

                            <label>Status :</label><br>
                            <select name="status" style="width:100%;">
                                <option value="Non Commencé" ${task.status === 'Non Commencé' ? 'selected' : ''}>Non Commencé</option>
                                <option value="En Cours" ${task.status === 'En Cours' ? 'selected' : ''}>En Cours</option>
                                <option value="Fini" ${task.status === 'Fini' ? 'selected' : ''}>Fini</option>
                            </select>

                            <label>Échéance :</label><br>
                            <input type="date" name="deadline" value="${task.deadline ? task.deadline.replace(' ', 'T').substring(0, 16) : ''}" style="width:100%;">
                            
                            <button type="submit" style="background-color: #28a745; color:white;">Enregistrer</button>
                            <button type="button" onclick="location.reload()">Annuler</button>
                        </form>
                    `);

                    let select = editorDiv.find('.task-category-select'); 
                    
                    if (catResponse.success) {
                        catResponse.categories.forEach(function(cat) {
                            let isSelected = (task.category_id == cat.id) ? 'selected' : '';
                            select.append(`<option value="${cat.id}" ${isSelected}>${cat.title}</option>`);
                        });
                    }
                }
            });
        },
        error: function() {
            alert("Erreur lors de la récupération des données.");
        }
    });
});