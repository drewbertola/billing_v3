const billing = {
    customEventsAdded : false,
    showArchived : false,
    customers : [],
    methods : [],

    initCustomEvents : () => {
        if (billing.customEventsAdded) { return; }

        document.body.addEventListener('save-error', (e) => {
            const modal = new bootstrap.Modal(document.getElementById(e.detail.modal));
            modal.show();

            const errorList = document.getElementById('saveResult');
            errorList.innerHTML = '';

            document.querySelectorAll('.bg-input-error').forEach((item) => {
                item.classList.remove('bg-input-error');
            });

            Object.keys(e.detail.errorMessages).forEach((key) => {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.classList.add('list-group-item-danger');
                li.textContent = e.detail.errorMessages[key];
                errorList.appendChild(li);
                document.getElementById(key).classList.add('bg-input-error');
            });
        });

        document.body.addEventListener('line-item-update', (e) => {
            document.getElementById('amount')
                .value = billing.formatMoney(e.detail.amount);
            document.getElementById('invoiceAmount' + e.detail.id)
                .innerHTML = billing.formatMoney(e.detail.amount);
        });

        document.body.addEventListener('open-edit', (e) => {
            const interval = setInterval(() => {
                const modal = document.getElementById(e.detail.invoiceOrPayment + 'Modal');
                const modalBody = modal.querySelector('.modal-body');

                if (typeof e.detail.customers !== 'undefined') {
                    billing.customers = e.detail.customers;
                }

                if (typeof e.detail.methods !== 'undefined') {
                    billing.methods = e.detail.methods;
                }

                fetch(
                    '/' + e.detail.invoiceOrPayment
                    + 's/edit/' + e.detail.id + '/' + e.detail.customerId
                )
                .then(response => { return response.text(); })
                .then(html => {
                    modalBody.innerHTML = html;
                    htmx.process(modalBody);

                    const customerName = document.getElementById('customerName');
                    const method = document.getElementById('method');

                    if (customerName) {
                        billing.initCustomerCompletions();
                    }

                    if (method) {
                        billing.initMethodCompletions();
                    }

                    new bootstrap.Modal(modal).show();
                });

                clearInterval(interval);
            }, 250);
        });

        document.body.addEventListener('completions', (e) => {
            if (typeof e.detail.customers !== 'undefined') {
                billing.customers = e.detail.customers;
            }

            if (typeof e.detail.methods !== 'undefined') {
                billing.methods = e.detail.methods;
            }
        });

        document.body.addEventListener('htmx:afterSwap', (e) => {
            const customerName = document.getElementById('customerName');
            const method = document.getElementById('method');

            if (customerName) {
                billing.initCustomerCompletions();
            }

            if (method) {
                billing.initMethodCompletions();
            }
        });

        billing.customEventsAdded = true;
    },

    initCustomerCompletions : () => {
        const customerId = document.getElementById('customerId');

        const customerCompletions = new autoComplete({
            selector: '#customerName',
            threshold: 0,
            data: {
                src: billing.customers,
                keys: ['name'],
            },
            resultsList: {
                maxResults: 20
            },
            events: {
                input: {
                    selection: (event) => {
                        const selection = event.detail.selection.value;
                        customerCompletions.input.value = selection.name;
                        customerId.value = selection.id;
                    },
                    focus: () => {
                        customerCompletions.start();
                    },
                }
            }
        });
    },

    initMethodCompletions : () => {
        const methodCompletions = new autoComplete({
            selector: '#method',
            threshold: 0,
            data: {
                src: billing.methods
            },
            resultsList: {
                maxResults: 20
            },
            events: {
                input: {
                    selection: (event) => {
                        const selection = event.detail.selection.value;
                        methodCompletions.input.value = selection;
                    },
                    focus: () => {
                        methodCompletions.start();
                    },
                }
            }
        });
    },

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

    formatMoney : (amount) => {
        const USDollar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        return USDollar.format(amount);
    }
};

document.addEventListener("htmx:load", (e) => {
    billing.initShowArchived();
    billing.initNav();
    billing.initCustomEvents();
});
