@extends('layouts.admin')
@section('header')
    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
@endsection
@section('content')


    <!-- Menu active-->
    <div style="margin: 10px; display: grid; grid-gap: 10px;">
        <a href="/reception/time">reception</a>
        <a href="/doctor/dashboard">doctor</a>
        <a href="/accountant/transactions">accountant</a>
    </div>
    
    <script>
        document.getElementById('admin').classList.add('active');
    </script>
    <div class="row mb-3"><!-- row-->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center"><i class="iconsmind-User text-primary" style="font-size: 50px;"></i></div>
                        <div class="col-md-7 text-right"><h4>{{$users_number}}</h4>Үйлчлүүлэгч</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center"><i class="iconsmind-Management
                            text-primary" style="font-size: 50px;"></i></div>
                        <div class="col-md-7 text-right"><h4>{{$roles}}</h4>Ажилтан</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center"><i class="iconsmind-Alarm text-primary" style="font-size: 50px;"></i></div>
                        <div class="col-md-7 text-right"><h4>{{$appointments}}</h4>Цаг захиалсан</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center"><i class="iconsmind-Hospital
                            text-primary" style="font-size: 50px;"></i></div>
                        <div class="col-md-7 text-right" style="font-size: 8px"><h4>{{$checkins}}</h4>Өнөөдөр хийгдсэн эмчилгээ </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- row end-->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>7 хоногийн ачаалал</h4>
                    <div class="ct-chart ct-golden-section" id="chart1"></div>
                    <script>
                        new Chartist.Line('.ct-chart', {
                            labels: [
                                @for($i=6;$i>=0;$i--)
                                    {{date('d', strtotime('-'.$i.' Days'))}},
                                @endfor
                            ],
                            series: [
                                {{$workloads}}
                            ]
                        }, {
                            fullWidth: true,
                            chartPadding: {
                                right: 40
                            }
                        });

                    </script>
                </div>
            </div>
        </div>
    </div>
        <div class="mb-5"></div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <canvas id="line-chart" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script src="{{asset('js/vendor/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/vendor/chartjs-plugin-datalabels.js')}}"></script>
    <script src="{{asset('js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('js/vendor/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/vendor/progressbar.min.js')}}"></script>
    <script src="{{asset('js/vendor/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/vendor/Sortable.js')}}"></script>

    <script type="text/javascript">
        new Chart(document.getElementById("line-chart"), {
                      type: 'line',
                      data: {
                        labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
                        datasets: [{ 
                            data: [86,114,106,106,107,111,133,221,783,2478],
                            label: "Africa",
                            borderColor: "#3e95cd",
                            fill: false
                          }, { 
                            data: [282,350,411,502,635,809,947,1402,3700,5267],
                            label: "Asia",
                            borderColor: "#8e5ea2",
                            fill: false
                          }
                        ]
                      },
                      options: {
                        title: {
                          display: true,
                          text: 'World population per region (in millions)'
                        }
                      }
                    });

    </script>
@endsection
