
// Mostra la modale per modificare un cliente
$(document).on('click', '.edit_client', function () {
    // Seleziona la riga (tr) che contiene il bottone cliccato
    let row = $(this).closest('tr'); // Usa closest per trovare la riga
    let client_id = row.data('client_id'); // Ottieni l'id del cliente dalla riga
    let name = row.find('td').eq(0).text(); // Ottieni il nome dalla prima colonna
    let phone = row.find('td').eq(1).text(); // Ottieni il telefono dalla seconda colonna
    let email = row.find('td').eq(2).text(); // Ottieni l'email dalla terza colonna
    let address = row.find('td').eq(3).text(); // Ottieni l'indirizzo dalla quarta colonna

    // Imposta i valori nel form del modal
    $('#modal_edit_client').find('input[name="client_id"]').val(client_id);
    $('#modal_edit_client').find('input[name="name"]').val(name);
    $('#modal_edit_client').find('input[name="phone"]').val(phone);
    $('#modal_edit_client').find('input[name="email"]').val(email);
    $('#modal_edit_client').find('input[name="address"]').val(address);

    // Mostra il modal
    $('#modal_edit_client').modal('toggle');
});

// Inizializza FormValidation
const form = document.getElementById('edit_client_form');
const validator = FormValidation.formValidation(form, {
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: 'Il nome è obbligatorio'
                },
                stringLength: {
                    min: 3,
                    message: 'Il nome deve essere lungo almeno 3 caratteri'
                }
            }
        },
        email: {
            validators: {
                emailAddress: {
                    message: "Inserisci un'email valida"
                }
            }
        },
    },
    plugins: {
        aria: new FormValidation.plugins.Aria(),
        trigger: new FormValidation.plugins.Trigger(),
        // Bootstrap Framework Integration
        bootstrap: new FormValidation.plugins.Bootstrap5(),
        // Validate fields when clicking the Submit button
        submitButton: new FormValidation.plugins.SubmitButton()
    }
});

// Gestisci il click del pulsante "Salva"
$('#edit_save_button').on('click',function(){
    // Esegui la validazione prima di inviare l'AJAX
    validator.validate().then(function (status) {
        if (status === 'Valid') {
            //Form data
            const formData = new FormData(form);
            const data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });
            var client_id = $('#client_id').val();

            console.log('qui')
            $.ajax({
                type: 'PUT',
                headers: {'X-CSRF-TOKEN': csrfToken},
                url: '/api/clients/' + client_id,
                data: data,
                success: function (response) {
                    if (response.success) {
                        // Se l'aggiornamento è riuscito, aggiorna la UI
                        const clientRow = document.querySelector(`tr[data-client_id="${client_id}"]`);
                        clientRow.querySelector('td:nth-child(1)').textContent = response.result.name;
                        clientRow.querySelector('td:nth-child(2)').textContent = response.result.phone;
                        clientRow.querySelector('td:nth-child(3)').textContent = response.result.email;
                        clientRow.querySelector('td:nth-child(4)').textContent = response.result.address;

                        // Nascondi il modal o fai altre azioni
                        $('#modal_edit_client').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Modifica completata!',
                            text: 'I dati del cliente sono stati aggiornati correttamente.',
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore!',
                            text: 'Errore durante la modifica del cliente: ' + response.message,
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });
                    }
                }
            });
        } else {
            console.log('Il form non è valido');
        }
    });
});
