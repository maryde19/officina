// Inizializza FormValidation
const form_create_service = document.getElementById('create_service_form');
const validator_create_service = FormValidation.formValidation(form_create_service, {
    fields: {
        vehicle_id: {
            validators: {
                notEmpty: {
                    message: "Il campo Veicolo è obbligatorio."
                },
                greaterThan: {
                    min: 1,
                    message: "Il Veicolo selezionato non esiste."
                }
            }
        },
        description: {
            validators: {
                notEmpty: {
                    message: "Il campo Descrizione è obbligatorio."
                },
                stringLength: {
                    max: 255,
                    message: "La Descrizione non può superare i 255 caratteri."
                }
            }
        },
        cost: {
            validators: {
                notEmpty: {
                    message: 'Il costo è obbligatorio'
                },
                numeric: {
                    message: 'Inserisci un valore numerico valido'
                },
                greaterThan: {
                    min: 1,
                    message: 'Il costo deve essere maggiore di 1'
                }
            }
        },
        date: {
            validators: {
                notEmpty: {
                    message: 'La data è obbligatoria'
                },
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
$('#create_service_save_button').on('click',function(){
    // Esegui la validazione prima di inviare l'AJAX
    validator_create_service.validate().then(function (status) {
        if (status === 'Valid') {
            //Form data
            const formData = new FormData(form_create_service);
            const data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken},
                url: '/api/services',
                data: data,
                success: function (response) {
                    if (response.success) {
                        loadServices(1);

                        // Nascondi il modal o fai altre azioni
                        $('#modal_create_service').modal('hide');

                        //Reset form
                        // Reset tutti i campi del form
                        $('#create_service_form').trigger('reset');

                        // Reset stati di validazione del validation
                        $('#create_service_form').find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                        $('#create_service_form').find('.invalid-feedback, .valid-feedback').text('');

                        // Reset Select2
                        $('#create_service_form').find('select').val(null).trigger('change');

                        Swal.fire({
                            icon: 'success',
                            title: 'Creazione completata!',
                            text: 'L\'intervento è stato creato correttamente.',
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore!',
                            text: 'Errore durante la creazione dell\'intervento: ' + response.message,
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

$(document).ready(function() {
    let client_id = $('#client_id').val();
    $('#select_vehicle_id').select2({
        ajax: {
            url: '/api/vehicles',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    client_id:client_id,
                };
            },
            processResults: function(data) {
                return {
                    results: data.data.map(item => ({
                        id: item.id,
                        text: 'Targa: ' + item.license_plate
                    }))
                };
            },
            cache: true
        },
        placeholder: 'Seleziona un cliente',
        // minimumInputLength: 1, // Attendi almeno 1 carattere prima di cercare
        language: {
            inputTooShort: function(args) {
                return 'Inserisci almeno ' + args.minimum + ' carattere' + (args.minimum > 1 ? 'i' : '');
            },
            searching: function() {
                return 'Ricerca in corso...';
            },
            noResults: function() {
                return 'Nessun risultato trovato';
            },
            loadingMore: function() {
                return 'Caricamento di altri risultati...';
            }
        },
        minimumResultsForSearch: -1,
    });

    //Picker data
    $('.date_picker').flatpickr({
        dateFormat: "d/m/Y",
        locale: "it",
        allowInput: true,
        defaultDate: '',
        confirmIcon: "<i class='bi bi-check-circle text-success'></i>", // your icon's html, if you wish to override
        confirmText: "OK",
        showAlways: true,
    });

});
