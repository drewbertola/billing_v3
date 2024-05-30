const billing = {
    showArchived : false,

    initNav : () => {
        const links = document.querySelectorAll('.nav-link');

        const path = document.location.pathname.substring(1);
        const section = path.replace(/\/.*$/, '');

        links.forEach(function(link) {
            link.classList.remove('active');

            if (link.id === section + 'Nav') {
                link.classList.add('active');
            }
        });
    },

    initShowArchived : () => {
        const showArchivedSwitch = document.getElementById('showArchived');

        if (! showArchivedSwitch) { return; }

        showArchivedSwitch.checked = billing.showArchived;

        billing.updateShowArchived();
    },

    updateShowArchived : () => {
        const rows = document.getElementById('customerTable').querySelectorAll('tr.archived');

        rows.forEach(function(row) {
            if (billing.showArchived) {
                row.classList.remove('d-none');
            } else {
                row.classList.add('d-none');
            }
        });
    },

    toggleShowArchived : () => {
        billing.showArchived = ! billing.showArchived;
        billing.updateShowArchived();
    },
};

document.addEventListener("htmx:load", (e) => {
    billing.initShowArchived();
    billing.initNav();
});
