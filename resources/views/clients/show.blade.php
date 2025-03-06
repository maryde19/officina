<x-master title="">

    <x-slot name="action_buttons">

    </x-slot>

    <!-- id client per js -->
    <input type="hidden" id="client_id" value="{{ $client->id }}" />
    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap align-items-center gap-5">

                <!-- icona -->
                <div class="h-100">
                    <div class="w-125px h-125px bg-light-primary rounded rounded-2 d-flex justify-content-center align-items-center">
                        <i class="fa fa-user text-primary fs-4x"></i>
                    </div>
                </div>

                <!-- info -->
                <div class="h-100 flex-grow-1 align-items-center d-flex">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2 w-100">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $client->name }}</a>
                            </div>

                            <div class="d-flex flex-wrap flex-column fw-semibold fs-6 pe-2">
                                @if($client->phone != null)
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="fa fa-phone me-3"></i>
                                        {{ $client->phone }}
                                    </a>
                                @endif
                                @if($client->email != null)
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="fa fa-envelope-open me-3"></i>
                                        {{ $client->email }}
                                    </a>
                                @endif
                                @if($client->address != null)
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                        <i class="fa fa-map-location-dot me-3"></i>
                                        {{ $client->address }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('clients.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Indietro</a>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mt-6">
                <!-- item -->
                <li class="nav-item mt-2">
                    <a id="tab_vehicles" class="nav-link text-active-primary ms-0 me-10 py-5 active cursor-pointer">
                        Veicoli
                    </a>
                </li>

                <!-- item -->
                <li class="nav-item mt-2">
                    <a id="tab_services" class="nav-link text-active-primary ms-0 me-10 py-5 cursor-pointer">
                        Interventi
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6">
            <!-- ricerca cliente -->
            <div class="d-flex align-items-center position-relative my-1">
                <i class="fa fa-search fs-4 position-absolute ms-5"></i>
                <input type="text" id="search" class="form-control form-control-solid ps-12" placeholder="Cerca..." >
            </div>
        </div>
    </div>

    <!-- veicoli -->
    <div id="list_vehicles">
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div><h1>Veicoli</h1></div>
                    <div>
                        <button type="button" class="btn btn-success" data-bs-target="#modal_create_vehicle" data-bs-toggle="modal"><i class="fa fa-plus"></i> Aggiungi Veicolo</button> <!-- Bottone per aggiungere un cliente -->
                    </div>
                </div>
                <div class="table-responsive p-0 mt-6">
                    <table class="table align-middle table-row-dashed gs-2">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class=" text-uppercase ">Marca</th>
                            <th class=" text-uppercase ">Modello</th>
                            <th class=" text-uppercase ">Anno</th>
                            <th class=" text-uppercase ">Targa</th>
                            <th class="text-end"></th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-800 fs-6" id="vehicles_table_body">
                        </tbody>
                    </table>
                    <!-- Paginazione -->
                    <div id="pagination" class="text-center">
                        <!-- I bottoni della paginazione verranno aggiunti qui tramite AJAX -->
                    </div>
                </div>
                @include('vehicles.create')

            </div>
        </div>
    </div>

    <!-- services -->
    <div id="list_services" class="d-none">
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div><h1>Interventi</h1></div>
                    <div>
                        <button type="button" class="btn btn-success" data-bs-target="#modal_create_service" data-bs-toggle="modal"><i class="fa fa-plus"></i> Aggiungi Intervento</button> <!-- Bottone per aggiungere un cliente -->
                    </div>
                </div>
                <div class="table-responsive p-0 mt-6">
                    <table class="table align-middle table-row-dashed gs-2">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class=" text-uppercase ">Veicolo</th>
                            <th class=" text-uppercase ">Descrizione</th>
                            <th class=" text-uppercase ">Costo</th>
                            <th class=" text-uppercase ">Data</th>
                            <th class="text-end"></th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-800 fs-6" id="services_table_body">
                        </tbody>
                    </table>
                    <!-- Paginazione -->
                    <div id="pagination" class="text-center">
                        <!-- I bottoni della paginazione verranno aggiunti qui tramite AJAX -->
                    </div>
                </div>
                @include('services.create')
            </div>
        </div>
    </div>


    <x-slot name="customscripts">
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
            const csrfToken = window.Laravel.csrfToken;
        </script>

        <!-- switch tab -->
        <script>
            $(document).on('click','#tab_vehicles', function (){
               $('#list_vehicles').removeClass('d-none');
               $('#list_services').addClass('d-none');
               $(this).addClass('active');
               $('#tab_services').removeClass('active')
            });

            $(document).on('click','#tab_services', function (){
                $('#list_services').removeClass('d-none');
                $('#list_vehicles').addClass('d-none');
                $(this).addClass('active');
                $('#tab_vehicles').removeClass('active')
            });
        </script>

        <!-- vehicles -->
        <script src="{{ asset('js/vehicles/index.js') }}" ></script>
        <script src="{{ asset('js/vehicles/create.js') }}"></script>
        <script src="{{ asset('js/vehicles/delete.js') }}"></script>

        <!-- services -->
        <script src="{{ asset('js/services/index.js') }}" ></script>
        <script src="{{ asset('js/services/create.js') }}"></script>
        <script src="{{ asset('js/services/delete.js') }}"></script>


    </x-slot>

</x-master>
