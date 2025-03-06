// Inizializza FormValidation
const form_create = document.getElementById('create_vehicle_form');
const validator_create = FormValidation.formValidation(form_create, {
    fields: {
        license_plate: {
            validators: {
                notEmpty: {
                    message: "Il campo Targa è obbligatorio."
                },
            }
        }
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
                url: '/api/vehicles',
                data: data,
                success: function (response) {
                    if (response.success) {
                        loadVehicles(1);

                        // Nascondi il modal o fai altre azioni
                        $('#modal_create_vehicle').modal('hide');

                        //Reset form
                        // Reset tutti i campi del form
                        $('#create_vehicle_form').trigger('reset');

                        // Reset stati di validazione del validation
                        $('#create_vehicle_form').find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                        $('#create_vehicle_form').find('.invalid-feedback, .valid-feedback').text('');

                        // Reset Select2
                        $('#create_vehicle_form').find('select').val(null).trigger('change');


                        Swal.fire({
                            icon: 'success',
                            title: 'Creazione completata!',
                            text: 'Il veicolo è stato creato correttamente.',
                            timer: 3000, // L'alert si chiuderà automaticamente dopo 3 secondi
                            showConfirmButton: false // Nasconde il pulsante "Ok"
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore!',
                            text: 'Errore durante la creazione del veicolo: ' + response.message,
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

    // $('#select_client_id').select2({
    //     ajax: {
    //         url: '/api/clients',
    //         dataType: 'json',
    //         delay: 250, // Ritardo per ridurre le chiamate al server
    //         data: function(params) {
    //             return {
    //                 search: params.term, // Passa il termine di ricerca come query string
    //             };
    //         },
    //         processResults: function(data) {
    //             return {
    //                 results: data.data.map(item => ({
    //                     id: item.id,
    //                     text: item.name + ' - ' + item.email + ' - ' + item.phone
    //                 }))
    //             };
    //         },
    //         cache: true
    //     },
    //     placeholder: 'Seleziona un cliente',
    //     minimumInputLength: 1, // Attendi almeno 1 carattere prima di cercare
    //     language: {
    //         inputTooShort: function(args) {
    //             return 'Inserisci almeno ' + args.minimum + ' carattere' + (args.minimum > 1 ? 'i' : '');
    //         },
    //         searching: function() {
    //             return 'Ricerca in corso...';
    //         },
    //         noResults: function() {
    //             return 'Nessun risultato trovato';
    //         },
    //         loadingMore: function() {
    //             return 'Caricamento di altri risultati...';
    //         }
    //     }
    // });

    //Picker solo anno
    $('.year_picker').datepicker({
        format: "yyyy",
        startView: "years",
        minViewMode: "years",
        autoclose: true,
        language: "it",
        defaultDate: new Date(),
        endDate: new Date(),
        container:'body',
        appendTo: '.modal',
    });

});
