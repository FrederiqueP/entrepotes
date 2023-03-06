console.log('début tableau.js');

// Sélection de la div d'un groupe
const lesgroupes = document.querySelectorAll('.ungroupe');

// On parcours tous les groupes
// On lit les attributs data-couleur
// On change la couleur du border du groupe avec la couleur de mongroupe 
for (const mongroupe of lesgroupes) {
    mongroupe.style.borderColor = mongroupe.dataset.couleur;
}

//==============================================================

// Sélection de la div voirliste de chaque groupe
const urls = document.querySelectorAll('.voirliste');

// On parcours chaque groupe et on récupère son id dans dataset
for (const url of urls) {
    // ... et on installe un gestionnaire d'événement au click sur chaque liste de potes 
    url.addEventListener('click', async function(event) {
        // Annulation du comportement par défaut du navigateur (envoyer l'internaute vers l'URL du lien)
        event.preventDefault();

        // console.log(url.dataset.idgroupe);
        // console.log(location.href);
        const http = location.href;
        const envoi = http.replace('tableau', 'listepote&idGroupe=' + url.dataset.idgroupe);
        // console.log(envoi);

        fetch(envoi)
        .then(response => response.text()) 
        .then(html => {  
            document.getElementById('pote_'+ url.dataset.idgroupe).innerHTML = html; 
        });

        // Bascule affiche liste ou pas
        document.getElementById('pote_'+ url.dataset.idgroupe).toggleAttribute("hidden");
    });  

}
