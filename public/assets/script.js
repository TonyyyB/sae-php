// Fermer toutes les listes déroulantes si on clique en dehors
document.addEventListener('click', function (event) {
    const dropdowns = document.querySelectorAll('.checkbox-list');
    const buttons = document.querySelectorAll('.dropdown-button');
    if(event.target.classList.contains('dropdown-button')) {
        if(event.target.nextElementSibling.classList.contains('active')) {
            event.target.nextElementSibling.classList.remove('active');
        }else{
            dropdowns.forEach(dropdown => dropdown.classList.remove('active'));
            event.target.nextElementSibling.classList.toggle('active');
        }
        return;
    }else if(event.target.closest('.checkbox-list')) {
        return;
    }
    dropdowns.forEach(dropdown => dropdown.classList.remove('active'));
});

function clearFilters(){
    document.querySelectorAll('.checkbox-list input').forEach(input => {
        input.checked = false;
    });
    document.querySelectorAll('.checkbox-list').forEach(list => {
        list.classList.remove('active');
    });
}