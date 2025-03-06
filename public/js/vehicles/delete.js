$(document).on('click', '.delete_vehicle', function() {
    // Ottieni l'id del veicolo dal data-vehicle_id della riga
    let vehicle_id = $(this).closest('tr').data('vehicle_id');

    // Mostra la finestra di conferma con SweetAlert
    Swal.fire({
        title: 'Sei sicuro?',
        text: "Questa azione è irreversibile!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sì, elimina!',
        confirmButtonColor: 'red',
        cancelButtonText: 'Annulla',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se l'utente conferma, invia una richiesta AJAX per il destroy
            $.ajax({
                url: '/api/vehicles/' + vehicle_id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Aggiungi il token CSRF
                },
                success: function(response) {
                    // Se il veicolo è stato eliminato con successo
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Veicolo eliminato!',
                            text: 'I dati del veicolo sono stati eliminati correttamente.',
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });
                        // Rimuovi la riga dalla tabella
                        $('tr[data-vehicle_id="' + vehicle_id + '"]').remove();
                        // Per ricaricare la lista degli interventi - con la foreign key si eliminano se viene eliminato un veicolo
                        loadServices();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore!',
                            text: 'Si è verificato un errore durante l\'eliminazione del veicolo',
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Errore!',
                        text: 'Si è verificato un errore durante l\'eliminazione del veicolo',
                        timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                        showConfirmButton: false // Nasconde il pulsante "Ok"
                    });
                }
            });
        } else {
            // Se l'utente annulla
            Swal.fire(
                'Annullato',
                'L\'eliminazione è stata annullata.',
                'info'
            );
        }
    });
});
