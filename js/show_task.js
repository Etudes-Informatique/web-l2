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
            url: '../api/tasks/get_tasks.php',
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
                                <p><small><em>Catégorie : ${task.category_name || "Aucune"}</em></small></p>
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
            url: '../api/tasks/finish_task.php',
            type: 'POST',
            data: { id: taskId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    card.css({ "text-decoration": "line-through", "opacity": "0.6" });
                    card.find('.btn-finish').replaceWith("✅");
                    refreshTasks(currentId);
                }
            }
        });
    });

    let currentId = $('#user-info').attr('data-id');

    $(document).on('click', '.btn-delete', function() {
        let taskId = $(this).data('id');

        $.ajax({
            url: '../api/tasks/delete_task.php',
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
            url: '../api/tasks/start_task.php',
            type: 'POST',
            data: { id: taskId },
            dataType: 'json',
            success: function(response) {
                refreshTasks(currentId);
            }
        });
    });

    $(document).on('submit', '.form-update-task', function(e) {
        e.preventDefault();
        
        let taskId = $(this).data('id');
        let formData = $(this).serialize();
        formData += '&id=' + taskId;

        $.ajax({
            url: '../api/tasks/edit_task.php',
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