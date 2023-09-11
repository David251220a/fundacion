@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.34.1/dist/apexcharts.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- <link href="{{asset('plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
@endsection

@section('content')

    @livewire('cierre.index-cierre')

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    {{-- <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script> --}}
    <script src="{{asset('plugins/apex/custom-apexcharts.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

        });

        function graficos()
        {
            var ingresosSeries = [];
            var egresosSeries = [];

            var donutChart = {
                chart: {
                    height: 350,
                    type: 'donut',
                    toolbar: {
                        show: false,
                    }
                },
                series: [10, 20, 50, 60], // Usar la serie de datos de ingresos aquí
                labels: ['dale', 'que', 'se', 'puede'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }

            var donut = new ApexCharts(
                document.querySelector("#donut-chart"),
                donutChart
            );

            donut.render();
        }

    </script>

@endsection
