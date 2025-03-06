// Funzione per caricare i clienti con paginazione
function loadClients(page = 1) {
    const search = $('#search').val();

    $.ajax({
        url: '/api/clients?page=' + page,
        type: 'GET',
        data: {
            search: search,
        },
        success: function(response) {
            // Aggiungi i dati della tabella
            $('#clients_table_body').empty();
            const clients = response.data;

            // Aggiungi le righe della tabella
            clients.forEach(function(client) {
                const clientRow = `<tr data-client_id="${client.id}">
                                                    <td>${client.name}</td>
                                                    <td>${client.phone ?? ''}</td>
                                                    <td>${client.email ?? ''}</td>
                                                    <td>${client.address ?? ''}</td>
                                                    <td class="text-end">
                                                        <a href="/clients/${client.id}/show" class="btn btn-warning btn-sm btn-icon" title="Visualizza Dettaglio"><i class="fa fa-eye"></i></a>
                                                        <button class="btn btn-primary btn-sm btn-icon edit_client" title="Modifica"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-danger btn-sm btn-icon delete_client" title="Elimina"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>`;
                $('#clients_table_body').append(clientRow);
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
            alert('Errore durante il caricamento dei clienti!');
        }
    });
}

$(document).ready(function() {
    // Carica la prima pagina dei clienti al caricamento della pagina
    loadClients();

    // Gestisci la paginazione
    $(document).on('click', '.pagination-btn', function() {
        const page = $(this).data('page');
        loadClients(page);
    });

    // Gestisci la ricerca per nome
    $(document).on('keyup', '#search', function() {
        loadClients();
    });

});
