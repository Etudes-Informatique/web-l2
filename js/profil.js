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

        let container2 = $('#change_pwd');
        container2.empty();
        let changePwd = `<button id="btn-changepwd" data-id="${userId}">Changer de Mot de Passe</button>`;
        container2.append(`
            <p>${changePwd}</p>
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
                    alert("Votre compte a été supprimé !");
                    window.location.href = '../index.php';
            }
        });
    });

    $(document).on('click', '#btn-changepwd', function() {
        let userId = $(this).data('id');
        let container = $('#change_pwd');
        container.empty();
        container.append(`
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <br>    
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirmation Mot de passe"required>
            <br>
            <input type="submit" value="Changer de mot de passe" data-id="${userId}" id="btn_change_pwd">
            <div id="res-change-pwd"></div>
        `);
    });

    $(document).on('click', '#btn_change_pwd', function() {
        let userId = $(this).data('id');
        let password = $('#password').val();
        let cpassword = $('#cpassword').val();
        $.ajax({
            url: '../api/users/changepwd.php',
            type: 'POST',
            data: { id: userId, password: password, cpassword: cpassword },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let succ = $('#res-change-pwd');
                    succ.empty();
                    succ.append('Votre mot de passe a été changé.');                
                } else {
                    switch (response.error) {
                        case "Champs vides.":
                            let err1 = $('#res-change-pwd');
                            err1.empty();
                            err1.append('Tout les champs n\'ont pas été rempli.');
                            break;
                        case "Les deux mots de passe sont différents.":
                            let err2 = $('#res-change-pwd');
                            err2.empty();
                            err2.append('Les deux mots de passes entrés sont différents');
                            break;
                        case "Le mot de passe ne respecte pas les conditions.":
                            let err3 = $('#res-change-pwd');
                            err3.empty();
                            err3.append('Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.');
                            break;
                        default:
                            alert("Erreur : " + response.error);
                    }
                }
            },
            error: function(xhr) {
                alert("Erreur serveur : " + xhr.status);
            }
        });
    });
});