<x-master title="Dashboard">
    <div class="row">

        <!-- clienti -->
        <div class="col-lg-6 mb-6">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $clients_count }}</span>
                        </div>

                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Clienti registrati</span>
                    </div>

                    <div>
                        <i class="fa fa-users fs-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- veicoli -->
        <div class="col-lg-6 mb-6">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $vehicles_count }}</span>
                        </div>

                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Veicoli registrati</span>
                    </div>

                    <div>
                        <i class="fa fa-car-alt fs-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-lg-6">
            <div class="card ">
                <div id="chart"></div>
            </div>
        </div>

        <div class="col-lg-6 ">
            <div class="d-flex flex-column w-100 justify-content-between h-100">
                <div class="card h-30 mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="d-flex align-items-center">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $services_today }}</span>
                            </div>

                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Interventi programmati per oggi</span>
                        </div>

                        <div>
                            <i class="fa fa-calendar-alt fs-2x text-danger"></i>
                        </div>
                    </div>
                </div>
                <div class="card h-30 mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="d-flex align-items-center">
                                <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">€</span>

                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ number_format($services_cost_month/100,2,',','.') }}</span>
                            </div>

                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Costo interventi di questo mese</span>
                        </div>

                        <div>
                            <i class="fa fa-chart-line fs-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="card h-30 ">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="d-flex align-items-center">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $services_month }}</span>
                            </div>

                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Interventi programmati questo mese</span>
                        </div>

                        <div>
                            <i class="fa fa-users-gear fs-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-6">
            <div class="">
                <div id="calendar"></div>
            </div>
        </div>
    </div>


    <x-slot name="customscripts">
        <script>
            let data = {!! json_encode($monthly_data) !!};
            var options = {
                series: [{
                    name: 'Costo',
                    data: data
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return val;
                        }
                    }

                },
                title: {
                    text: 'Costo interventi per mese',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Mostra solo la vista mese
                    locale: 'it',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listWeek' // Mantieni solo Mese e Lista
                    },
                    buttonText: {
                        today: 'Oggi',
                        month: 'Mese',
                        list: 'Lista'
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: "/api/calendar",
                            type: "GET",
                            dataType: "json",
                            data: {
                                data_da: fetchInfo.startStr,
                                data_a: fetchInfo.endStr
                            },
                            success: function(data) {
                                successCallback(data);
                            },
                            error: function(xhr, status, error) {
                                console.error("Errore nel recupero degli eventi:", error);
                                failureCallback(error);
                            }
                        });
                    },
                    eventColor: '#007bff',
                });

                calendar.render();
            });
        </script>
    </x-slot>
</x-master>
