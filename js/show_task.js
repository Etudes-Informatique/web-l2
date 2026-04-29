$(function() {
    function formaterDate(dateSql) {
        if (!dateSql || dateSql === "0000-00-00 00:00:00") return "Non définie";
        
        let d = new Date(dateSql);
        let mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
        let jours = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

        let m = d.getMinutes();
        if (m < 10) m = "0" + m;

        return jours[d.getDay()] + " " + d.getDate() + " " + mois[d.getMonth()] + " " + d.getFullYear() + " à " + d.getHours() + ":" + m;
    }

    function refreshTasks(userId) {
        $.ajax({
            url: '../api/get_tasks.php',
            type: 'GET',
            data: { identifiant: userId },
            dataType: 'json',
            success: function(tasks) {

                let container = $('#tasks-container');
                container.empty();

                if (tasks && tasks.length > 0) {
                    tasks.forEach(function(task) {
                        let styleTermine = task.finished == 1 ? "text-decoration: line-through; opacity: 0.6;" : "";
                        let boutonTerminer = task.finished == 0 ? (task.status == "Non Commencé" ? `<button class="btn-start" data-id="${task.id}">Commencer</button>` : `<button class="btn-finish" data-id="${task.id}">Terminer</button>`) : "✅";
                        let deleteTask = `<button class="btn-delete" data-id="${task.id}">Supprimer</button>`;
                        let editTask = task.finished == 1 ? "" : `<button class="btn-edit" data-id="${task.id}">Modifier</button>`;
                        
                        let dateCrea = formaterDate(task.created_at);
                        let dateEcheance = formaterDate(task.deadline);

                        container.append(`
                            <div class="task-card" id="task-${task.id}" style="${styleTermine}">
                                <h3>${task.title}</h3>
                                <p>${task.description}</p>
                                <p><small>Priorité : ${task.priority}</small></p>
                                <p><small>Status : ${task.status}</small></p>
                                <p><small><strong>Créée le :</strong> ${dateCrea}</small></p>
                                <p><small><strong>Échéance :</strong> ${dateEcheance}</small></p>
                                <p>${boutonTerminer} ${deleteTask} ${editTask}</p>
                                <div id="tasks-editor-${task.id}"></div>
                            </div>
                        `);
                    });
                } else {
                    container.html("<p>Aucune tâche à afficher.</p>");
                }
            },
            error: function(xhr) {
                console.error(xhr.status);
            }
        });
    }

    $(document).on('click', '.btn-finish', function() {
        let taskId = $(this).data('id');
        let card = $(this).closest('.task-card');

        $.ajax({
            url: '../api/finish_task.php',
            type: 'POST',
            data: { id: taskId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    card.css({ "text-decoration": "line-through", "opacity": "0.6" });
                    card.find('.btn-finish').replaceWith("✅");
                }
            }
        });
    });

    let currentId = $('#user-info').attr('data-id');

    $(document).on('click', '.btn-delete', function() {
        let taskId = $(this).data('id');
        let card = $(this).closest('.task-card');

        $.ajax({
            url: '../api/delete_task.php',
            type: 'POST',
            data: { id: taskId },
            dataType: 'json',
            success: function(response) {
                refreshTasks(currentId);
            }
        });
    });

    $(document).on('click', '.btn-start', function() {
        let taskId = $(this).data('id');
        let card = $(this).closest('.task-card');

        $.ajax({
            url: '../api/start_task.php',
            type: 'POST',
            data: { id: taskId },
            dataType: 'json',
            success: function(response) {
                refreshTasks(currentId);
            }
        });
    });

    $(document).on('click', '.btn-edit', function() {
        let taskId = $(this).data('id');
        
        let editorDiv = $(`#tasks-editor-${taskId}`); 

        $.ajax({
            url: '../api/get_task_id.php', 
            type: 'GET',
            data: { id: taskId },
            dataType: 'json',
            success: function(task) {
                if (task.error) {
                    alert(task.error);
                    return;
                }

                editorDiv.empty();
                editorDiv.append(`
                    <form class="form-update-task" data-id="${taskId}" style="margin-top:10px; border-top:1px solid #ccc; padding-top:10px;">
                        <input type="text" name="title" value="${task.title}" required style="width:100%;">
                        <textarea name="description" required style="width:100%;">${task.description}</textarea>
                        
                        <select name="priority" style="width:100%;">
                            <option value="Basse" ${task.priority === 'Basse' ? 'selected' : ''}>Basse</option>
                            <option value="Moyenne" ${task.priority === 'Moyenne' ? 'selected' : ''}>Moyenne</option>
                            <option value="Haute" ${task.priority === 'Haute' ? 'selected' : ''}>Haute</option>
                        </select>

                        <select name="status" style="width:100%;">
                            <option value="Non Commencé" ${task.status === 'Non Commencé' ? 'selected' : ''}>Non Commencé</option>
                            <option value="En Cours" ${task.status === 'En Cours' ? 'selected' : ''}>En Cours</option>
                            <option value="Fini" ${task.status === 'Fini' ? 'selected' : ''}>Fini</option>
                        </select>

                        <input type="datetime-local" name="deadline" value="${task.deadline ? task.deadline.replace(' ', 'T').substring(0, 16) : ''}" style="width:100%;">
                        
                        <button type="submit" style="background-color: #28a745; color:white;">Enregistrer</button>
                        <button type="button" onclick="location.reload()">Annuler</button>
                    </form>
                `);
            }
        });
    });

    $(document).on('submit', '.form-update-task', function(e) {
        e.preventDefault();
        
        let taskId = $(this).data('id');
        let formData = $(this).serialize();
        formData += '&id=' + taskId;

        $.ajax({
            url: '../api/edit_task.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    refreshTasks(currentId);
                } else {
                    alert("Erreur lors de la mise à jour : " + response.error);
                }
            },
            error: function() {
                alert("Erreur serveur lors de la modification.");
            }
        });
    });

    if (currentId) {
        refreshTasks(currentId);
    }
});