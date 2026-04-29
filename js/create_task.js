$(function() {
    if ($('#open-popup').length === 0) {
        $('#tasks-create2').append('<button id="open-popup">➕ Nouvelle Tâche</button>');
    }

    $('body').append(`
        <div id="task-modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
            <div style="background:#fff; margin:10% auto; padding:20px; width:400px; border-radius:8px; position:relative;">
                <span id="close-popup" style="position:absolute; right:15px; top:10px; cursor:pointer; font-size:20px;">&times;</span>
                <h2>Créer une tâche</h2>
                <form id="form-create-task">
                    <p><input type="text" id="title" placeholder="Titre" required style="width:100%;"></p>
                    <p><textarea id="description" placeholder="Description" required style="width:100%;"></textarea></p>
                    <p>
                        <select id="priority" style="width:100%;">
                            <option value="Basse">Basse</option>
                            <option value="Moyenne">Moyenne</option>
                            <option value="Haute">Haute</option>
                        </select>
                    </p>
                    <p><label>Échéance (facultatif) :</label><br>
                       <input type="datetime-local" id="deadline" style="width:100%;"></p>
                    <button type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    `);

    $('#open-popup').on('click', function() { $('#task-modal').show(); });
    $('#close-popup').on('click', function() { $('#task-modal').hide(); });

    $('#form-create-task').on('submit', function(e) {
        e.preventDefault();

        let dataToSend = {
            title: $('#title').val(),
            description: $('#description').val(),
            priority: $('#priority').val(),
            deadline: $('#deadline').val()
        };

        $.ajax({
            url: '../api/create_task.php',
            type: 'POST',
            data: dataToSend,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#task-modal').hide();
                    location.reload(); 
                } else {
                    console.log("Debug retour PHP:", response.debug);
                    alert("Erreur : " + response.error);
                }
            },
            error: function(xhr) {
                console.error("Erreur serveur :", xhr.status);
            }
        });
    });
});