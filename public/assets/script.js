// Fonction pour afficher/masquer le conteneur
function toggleContainer() {
    const container = document.getElementById('container');
    container.classList.toggle('active');
}

// Fonction pour afficher/masquer une liste déroulante spécifique
function toggleDropdown(button) {
    const list = button.nextElementSibling;
    list.classList.toggle('active');
}

// Fermer toutes les listes déroulantes si on clique en dehors
document.addEventListener('click', function (event) {
    const dropdowns = document.querySelectorAll('.checkbox-list');
    const buttons = document.querySelectorAll('.dropdown-button');
    if (![...buttons].some(button => button.contains(event.target))) {
        dropdowns.forEach(dropdown => dropdown.classList.remove('active'));
    }
});
