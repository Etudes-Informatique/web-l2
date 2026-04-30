$(function() {
    if ($('#open-category-popup').length === 0) {
        $('#category-create').append('<button id="open-category-popup">➕ Nouvelle Catégorie</button>');
    }

    $('body').append(`
        <div id="category-modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
            <div style="background:#fff; margin:10% auto; padding:20px; width:400px; border-radius:8px; position:relative;">
                <span id="close-category-popup" style="position:absolute; right:15px; top:10px; cursor:pointer; font-size:20px;">&times;</span>
                <h2>Créer une Catégorie</h2>
                <form id="form-create-category">
                    <p><input type="text" id="category-title" placeholder="Nom" required style="width:100%;"></p>
                    <button type="submit">Créer</button>
                </form>
            </div>
        </div>
    `);

    $('#open-category-popup').on('click', function() { $('#category-modal').show(); });
    $('#close-category-popup').on('click', function() { $('#category-modal').hide(); });

    $(document).on('submit', '#form-create-category', function(e) {
        e.preventDefault();

        let dataToSend = {
            title: $('#category-title').val(),
        };

        $.ajax({
            url: '../api/categories/create_category.php',
            type: 'POST',
            data: dataToSend,
            dataType: 'json',
            success: function(response) {
                console.log("Réponse reçue :", response);
                if (response.success) {
                    location.reload(); 
                } else {
                    alert("Erreur : " + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Détails erreur :", xhr.responseText);
                alert("Erreur critique (voir console)");
            }
        });
    });
});