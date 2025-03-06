// Funzione per caricare i veicoli con paginazione
function loadVehicles(page = 1) {
    const search = $('#search').val();
    const client_id = $('#client_id').val();

    $.ajax({
        url: '/api/vehicles?page=' + page, // URL della tua rotta
        type: 'GET',
        data: {
            client_id:client_id,
            search: search,
        },
        success: function(response) {
            // Aggiungi i dati della tabella
            $('#vehicles_table_body').empty(); // Pulisci la tabella prima di aggiungere nuovi dati
            const vehicles = response.data;

            // Aggiungi le righe della tabella
            vehicles.forEach(function(vehicle) {
                const vehicleRow = `<tr data-vehicle_id="${vehicle.id}">
                                                    <td>${vehicle.brand ?? ''}</td>
                                                    <td>${vehicle.model ?? ''}</td>
                                                    <td>${vehicle.year ?? ''}</td>
                                                    <td><span class="badge badge-secondary fs-7">${vehicle.license_plate}</span></td>
                                                    <td class="text-end">
                                                        <button class="btn btn-danger btn-sm btn-icon delete_vehicle" title="Elimina"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>`;
                $('#vehicles_table_body').append(vehicleRow);
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
            alert('Errore durante il caricamento dei veicoli!');
        }
    });
}


$(document).ready(function() {
    // Carica la prima pagina dei veicoli al caricamento della pagina
    loadVehicles();

    // Gestisci la paginazione
    $(document).on('click', '.pagination-btn', function() {
        const page = $(this).data('page');
        loadVehicles(page);
    });

    // Gestisci la ricerca per nome
    $(document).on('keyup', '#search', function() {
        loadVehicles();
    });
});

