$(document).ready(function() {
    function formaterDate(dateSql) {
        if (!dateSql || dateSql === "0000-00-00 00:00:00") return "Non définie";
        
        let d = new Date(dateSql);
        let mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
        let jours = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

        let m = d.getMinutes();
        if (m < 10) m = "0" + m;

        return jours[d.getDay()] + " " + d.getDate() + " " + mois[d.getMonth()] + " " + d.getFullYear() + " à " + d.getHours() + ":" + m;
    }

    function getFilters() {
        return {
            query: $('#search-input').val().trim(),
            priority: $('#priority-selector').val(),
            status: $('#status-selector').val(),
        };
    }

    $('#search-input, #priority-selector, #status-selector').on('input change', function() {
        let filter = getFilters();
        let $resultsContainer = $('#search-results');

        if (filter.query.length < 2) {
            $resultsContainer.empty();
            return;
        }
        
        $.ajax({
            url: '../api/tasks/getTask_byFilter.php',
            type: 'GET',
            data: { q: filter.query, p: filter.priority, s: filter.status },
            dataType: 'json',
            success: function(data) {
                $resultsContainer.empty();

                if (data.length === 0) {
                    $resultsContainer.html('<div>Aucun résultat</div>');
                    return;
                }

                $.each(data, function(index, item) {
                    let styleTermine = item.finished == 1 ? "text-decoration: line-through; opacity: 0.6;" : "";
                    let boutonTerminer = item.finished == 0 ? (item.status == "Non Commencé" ? `<button class="btn-start" data-id="${item.id}">Commencer</button>` : `<button class="btn-finish" data-id="${item.id}">Terminer</button>`) : "✅";
                    let deleteTask = `<button class="btn-delete" data-id="${item.id}">Supprimer</button>`;
                    let editTask = item.finished == 1 ? "" : `<button class="btn-edit" data-id="${item.id}">Modifier</button>`;

                    let dateCrea = formaterDate(item.created_at);
                    let dateEcheance = formaterDate(item.deadline);

                    $resultsContainer.append(`
                                <div class="task-card" id="task-${item.id}" style="${styleTermine}">
                                <h3>${item.title}</h3>
                                <p>${item.description}</p>
                                <p><small>Priorité : ${item.priority}</small></p>
                                <p><small>Status : ${item.status}</small></p>
                                <p><small><strong>Créée le :</strong> ${dateCrea}</small></p>
                                <p><small><strong>Échéance :</strong> ${dateEcheance}</small></p>
                                <p>${boutonTerminer} ${deleteTask} ${editTask}</p>
                                <p><small><em>Catégorie : ${item.category_name || "Aucune"}</em></small></p>
                                <div id="tasks-editor-${item.id}"></div>
                            </div>
                    `);
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX (jQuery):', error);
            }
        });
    });
});


$(document).on('click', '.btn-ad-search', function() {
    let container = $('#more-search');
    container.empty();
    let firstSelect = `
    <select name="Priorité" id="priority-selector">
        <option value="">--Choissiez une priorité--</option>
        <option value="Basse">Basse</option>
        <option value="Moyenne">Moyenne</option>
        <option value="Haute">Haute</option>
    </select>`
    let secondSelect = `
    <select name="Status" id="status-selector">
        <option value="">--Choissiez un Status--</option>
        <option value="Non Commencé">Non Commencé</option>
        <option value="En Cours">En Cours</option>
        <option value="Terminé">Terminé</option>
    </select>`
    container.append(`${firstSelect} ${secondSelect}`);
});