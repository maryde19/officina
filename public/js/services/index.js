function formatDate(dateStr) {
    let date = new Date(dateStr);
    if (isNaN(date)) return ''; // Se la data non è valida, restituisce una stringa vuota
    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Mesi da 0 a 11, quindi +1
    let year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

function formatCost(cost) {
    return parseFloat(cost/100).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}


// Funzione per caricare interventi con paginazione
function loadServices(page = 1) {
    const search = $('#search').val();
    const client_id = $('#client_id').val();

    $.ajax({
        url: '/api/services?page=' + page, // URL della tua rotta
        type: 'GET',
        data: {
            client_id:client_id,
            search: search,
        },
        success: function(response) {
            // Aggiungi i dati della tabella
            $('#services_table_body').empty(); // Pulisci la tabella prima di aggiungere nuovi dati
            const services = response.data;

            // Aggiungi le righe della tabella
            services.forEach(function(service) {
                let date = formatDate(service.date);
                let cost = formatCost(service.cost);
                const serviceRow = `<tr data-service_id="${service.id}">
                                                    <td>${service.vehicle.brand ?? ''} ${service.vehicle.model ?? ''} <span class="badge badge-secondary fs-7 ms-2">${service.vehicle.license_plate ?? ''}</span></td>
                                                    <td>${service.description}</td>
                                                    <td>€ ${cost}</td>
                                                    <td>${date}</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-danger btn-sm btn-icon delete_service" title="Elimina"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>`;
                $('#services_table_body').append(serviceRow);
            });

            // Gestisci la paginazione
            $('#pagination').html(''); // Pulisci i bottoni della paginazione
            for (let i = 1; i <= response.last_page; i++) {
                const isActive = i === response.current_page ? 'btn-primary' : 'btn-outline-primary'; // Attivo o non attivo
                const paginationButton = `<button class="btn btn-sm ${isActive} rounded pagination-btn ms-1" data-page="${i}">${i}</button>`;
                $('#pagination').append(paginationButton);
            }

            enableTooltip();
        },
        error: function() {
            alert('Errore durante il caricamento degli interventi!');
        }
    });
}


$(document).ready(function() {
    // Carica la prima pagina interventi al caricamento della pagina
    loadServices();

    // Gestisci la paginazione
    $(document).on('click', '.pagination-btn', function() {
        const page = $(this).data('page');
        loadServices(page);
    });

    // Gestisci la ricerca per nome
    $(document).on('keyup', '#search', function() {
        loadServices();
    });
});

