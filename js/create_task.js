$(function() {
    if ($('#open-task-popup').length === 0) {
        $('#tasks-create2').append('<button id="open-task-popup">➕ Nouvelle Tâche</button>');
    }

    $('body').append(`
        <div id="task-modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
            <div style="background:#fff; margin:10% auto; padding:20px; width:400px; border-radius:8px; position:relative;">
                <span id="close-task-popup" style="position:absolute; right:15px; top:10px; cursor:pointer; font-size:20px;">&times;</span>
                <h2>Créer une tâche</h2>
                <form id="form-create-task">
                    <p><input type="text" id="task-title" placeholder="Titre" required style="width:100%;"></p>
                    <p><textarea id="task-description" placeholder="Description" required style="width:100%;"></textarea></p>
                    
                    <p>
                        <label>Catégorie :</label><br>
                        <select id="task-category" style="width:100%;">
                            <option value="">-- Aucune catégorie --</option>
                        </select>
                    </p>

                    <p>
                        <label>Priorité :</label><br>
                        <select id="task-priority" style="width:100%;">
                            <option value="Basse">Basse</option>
                            <option value="Moyenne">Moyenne</option>
                            <option value="Haute">Haute</option>
                        </select>
                    </p>
                    <p><label>Échéance :</label><br>
                       <input type="date" id="task-deadline" style="width:100%;"></p>
                    <button type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    `);

    $('#open-task-popup').on('click', function() {

        $.ajax({
            url: '../api/categories/get_categories.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("Réponse API catégories :", response);
                if (response.success) {
                    let select = $('#task-category');
                    select.find('option:not(:first)').remove();
                    
                    response.categories.forEach(function(cat) {
                        select.append(`<option value="${cat.title}">${cat.title}</option>`);
                    });
                } else {
                    console.error("L'API a répondu false :", response.error);
                }
                $('#task-modal').show();
            },
            error: function(xhr, status, error) {
                console.error("Erreur AJAX critique :");
                console.error("Statut :", status);
                console.error("Réponse du serveur :", xhr.responseText);
                
                $('#task-modal').show();
                alert("Note : Impossible de charger les catégories (voir console).");
            }
        });
    });

    $('#close-task-popup').on('click', function() { $('#task-modal').hide(); });

    $(document).on('submit', '#form-create-task', function(e) {
        e.preventDefault();

        let dataToSend = {
            title: $('#task-title').val(),
            description: $('#task-description').val(),
            priority: $('#task-priority').val(),
            deadline: $('#task-deadline').val(),
            category_id: $('#task-category').val() 
        };

        $.ajax({
            url: '../api/tasks/create_task.php',
            type: 'POST',
            data: dataToSend,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload(); 
                } else {
                    alert("Erreur : " + response.error);
                }
            }
        });
    });
});