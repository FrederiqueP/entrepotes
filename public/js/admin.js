// Sélection de tous les boutons de suppression
const deleteButtons = document.querySelectorAll('.delete-user-button');

// On parcours les boutons...
for (const button of deleteButtons) {

    // ... et on installe un gestionnaire d'événement au click sur chaque bouton 
    button.addEventListener('click', async function(event) {

        // Annulation du comportement par défaut du navigateur (envoyer l'internaute vers l'URL du lien)
        event.preventDefault();

        // Si l'internaute confirme la suppression
        if (window.confirm('Êtes-vous certain de vouloir supprimer cet utilisateur ?')) {
            
            /*
            // On récupère l'URL du lien dans l'attribut href de l'élément cliqué
            const url = event.currentTarget.href;

            // On redirige l'internaute vers cette URL
            window.location.assign(url);
            */

            // Désormais on va lancer une requête AJAX pour faire la suppression !

            // 1°) Récupérer l'URL à interroger en AJAX avec l'attribut data "ajax"
            const urlAjax = event.currentTarget.dataset.ajax;

            // 2°) Lancer la requête AJAX avec fetch()
            const response = await fetch(urlAjax);
            const data = await response.json();

            /**
             * Je récupère ici les données envoyées par le serveur en PHP avec : echo json_encode(['id' => $idArticle]);
             * Je vais donc récupérer un objet avec la propriété id qui contient l'id de l'article supprimé
             */

            // 3°) Lors de la réception de la réponse, on construit l'id de l'élément <tr> à supprimer et on le supprime
            const idTr = `user-${data.id}`; 
            document.getElementById(idTr).remove();
        }
    });
}