<x-master title="Clienti">

    <x-slot name="action_buttons">
        <button type="button" class="btn btn-success" data-bs-target="#modal_create_client" data-bs-toggle="modal"><i class="fa fa-plus"></i> Aggiungi Cliente</button> <!-- Bottone per aggiungere un cliente -->
    </x-slot>

    <div class="row">
        <div class="col-lg-6">
            <!-- ricerca cliente -->
            <div class="d-flex align-items-center position-relative my-1">
                <i class="fa fa-search fs-4 position-absolute ms-5"></i>
                <input type="text" id="search" class="form-control form-control-solid ps-12" placeholder="Cerca..." >
            </div>
        </div>
    </div>

    <div class="table-responsive p-0 mt-6">
        <table class="table align-middle table-row-dashed gs-2">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="text-uppercase ">Cliente</th>
                <th class=" text-uppercase ">Telefono</th>
                <th class=" text-uppercase ">Email</th>
                <th class=" text-uppercase ">Indirizzo</th>
                <th class="text-end"></th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-800 fs-6" id="clients_table_body">
            </tbody>
        </table>
        <!-- Paginazione -->
        <div id="pagination" class="text-center">
            <!-- I bottoni della paginazione verranno aggiunti qui tramite AJAX -->
        </div>
    </div>

    @include('clients.edit')
    @include('clients.create')


    <x-slot name="customscripts">
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
            const csrfToken = window.Laravel.csrfToken;
        </script>
        <script src="{{ asset('js/clients/index.js') }}" ></script>
        <script src="{{ asset('js/clients/create.js') }}"></script>
        <script src="{{ asset('js/clients/edit.js') }}"></script>
        <script src="{{ asset('js/clients/delete.js') }}"></script>
    </x-slot>

</x-master>
