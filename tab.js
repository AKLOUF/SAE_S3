function openTab(evt, tabName) {
    // cacher tous les contenus
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(c => c.style.display = 'none');

    // retirer la classe active des boutons
    const buttons = document.querySelectorAll('.tab-button');
    buttons.forEach(b => b.classList.remove('active'));

    // afficher le contenu sélectionné
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.classList.add('active');
}

// Récupère tous les onglets
const tabs = document.querySelectorAll('.nav-tabs .nav-link');
tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        // Retire la classe active de tous les onglets
        tabs.forEach(t => t.classList.remove('active'));
        // Ajoute la classe active à l'onglet cliqué
        this.classList.add('active');
        // Optionnel : gérer l'affichage du contenu correspondant
        const target = this.getAttribute('href');
        const tabContents = document.querySelectorAll('.tab-content .tab-pane');
        tabContents.forEach(content => content.classList.remove('active', 'show'));
                const activeContent = document.querySelector(target);
        if (activeContent) {
            activeContent.classList.add('active', 'show');
        }
    });
});