// Inizializza FormValidation
const form_create = document.getElementById('create_client_form');
const validator_create = FormValidation.formValidation(form_create, {
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
$('#create_save_button').on('click',function(){
    // Esegui la validazione prima di inviare l'AJAX
    validator_create.validate().then(function (status) {
        if (status === 'Valid') {
            //Form data
            const formData = new FormData(form_create);
            const data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken},
                url: '/api/clients',
                data: data,
                success: function (response) {
                    if (response.success) {
                        loadClients(1);

                        // Nascondi il modal o fai altre azioni
                        $('#modal_create_client').modal('hide');

                        //Reset form
                        // Reset tutti i campi del form
                        $('#create_client_form').trigger('reset');

                        // Reset stati di validazione del validation
                        $('#create_client_form').find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                        $('#create_client_form').find('.invalid-feedback, .valid-feedback').text('');

                        Swal.fire({
                            icon: 'success',
                            title: 'Creazione completata!',
                            text: 'I dati del cliente sono stati creati correttamente.',
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore!',
                            text: 'Errore durante la creazione del cliente: ' + response.message,
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
