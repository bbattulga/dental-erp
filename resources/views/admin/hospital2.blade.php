@extends('layouts.admin')
@section('header')

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}"/>
    <link href="{{asset('plugin/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugin/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="{{asset('plugin/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{asset('plugin/switchery/switchery.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
@endsection
@section('content')
    <!-- Menu active-->
    <script>
        document.getElementById('adminReport').classList.add('active');
    </script>
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="{{url('/admin/hospital/by_date')}}">
                @csrf
                <div class="input-group">
                    <a href="#" onclick="$(this).closest('form').submit()" style="color: #8f8f8f">Хугацаа
                        өөрчлөн харах</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input id="date" name="start_date" autocomplete="off" class="form-control datepicker"
                           style="background-color: #f8f8f8; border-color: #f8f8f8; border-bottom-color: #8f8f8f; color: #8f8f8f; padding: 0px"
                           placeholder="Эхлэл"
                           value="@if(!empty($start_date)){{date('m/d/Y', $start_date)}}@else{{date('m/d/Y', strtotime('-30 Days'))}}@endif">&nbsp;&nbsp;&nbsp;<span
                            style="color: #8f8f8f">-&nbsp;&nbsp;&nbsp;</span>
                    <input name="end_date" autocomplete="off" class="form-control datepicker "
                           style="background-color: #f8f8f8; border-color: #f8f8f8; border-bottom-color: #8f8f8f; color: #8f8f8f; padding: 0px"
                           placeholder="Төгсгөл"
                           value="@if(!empty($end_date)){{date('m/d/Y', $end_date)}}@else{{date('m/d/Y')}}@endif">
                    <a href="#" onclick="$(this).closest('form').submit()" style="color: #8f8f8f">үзэх</a>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <form id="monthSearch" action="{{url('/admin/hospital/by_month')}}" method="post">
                @csrf
                <select name="year">
                    @if(!empty($start_date))
                        <option value="{{date('Y', $start_date)}}">{{date('Y', $start_date)}}</option>
                        @for($m = 2019; $m<=2027; $m++)
                            @if($m != date('Y', $start_date))
                                <option value="{{$m}}">{{$m}}</option>
                            @endif
                        @endfor
                    @else
                        <option value="{{date('Y')}}">{{date('Y')}}</option>
                        @for($m = 2019; $m<=2027; $m++)
                            @if($m != date('Y'))
                                <option value="{{$m}}">{{$m}}</option>
                            @endif
                        @endfor
                    @endif
                </select>
                <select name="month" onchange="document.getElementById('monthSearch').submit()">
                    @if(!empty($start_date))
                        <option value="{{date('m', $start_date)}}">{{date('m', $start_date)}}</option>
                        @for($m = 1; $m<=12; $m++)
                            @if($m != date('m', $start_date))
                                <option value="{{$m}}">{{$m}}</option>
                            @endif
                        @endfor
                    @else
                        <option value="{{date('m')}}">{{date('m')}}</option>
                        @for($m = 1; $m<=12; $m++)
                            @if($m != date('m'))
                                <option value="{{$m}}">{{$m}}</option>
                            @endif
                        @endfor
                    @endif


                </select>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Шүдний эмчилгээ оношлогоо</h5>
                    <table class="table">
                        <tr>
                            <td>Үзлэгийн тоо бүгд</td>
                            <td>{{$count}}</td>
                        </tr>
                        <tr>
                            <td>Эрэгтэй</td>
                            <td>{{$count_male}}</td>
                        </tr>
                        <tr>
                            <td>Эмэгтэй</td>
                            <td>{{$count_female}}</td>
                        </tr>
                        <tr>
                            <td>Анхан</td>
                            <td>{{$count_first}}</td>
                        </tr>
                        <tr>
                            <td>Давтан</td>
                            <td>{{$count_again}}</td>
                        </tr>
                        @for($i=0;$i<15;$i++)
                            <tr>
                                <td>{{$i*4}}-{{($i+1)*4}} нас эмэгтэй</td>
                                <td>{{$age_female[$i]}}</td>
                            </tr>
                            <tr>
                                <td>{{$i*4}}-{{($i+1)*4}} нас эрэгтэй</td>
                                <td>{{$age_male[$i]}}</td>
                            </tr>
                        @endfor
                        <tr>
                            <td>60 наснаас дээш эмэгтэй</td>
                            <td>{{$age_female[15]}}</td>
                        </tr>
                        <tr>
                            <td>60 наснаас дээш эрэгтэй</td>
                            <td>{{$age_male[15]}}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Нүүр амын согог засал</h5>
                    <table class="table">
                        <tr>
                            <td>Үзлэгийн тоо</td>
                            <td>{{$treatment_type_2_count}}</td>
                        </tr>
                        <tr>
                            <td>Эрэгтэй</td>
                            <td>{{$treatment_type_2_count_male}}</td>
                        </tr>
                        <tr>
                            <td>Эмэгтэй</td>
                            <td>{{$treatment_type_2_count_female}}</td>
                        </tr>
                        <tr>
                            <td>Анхан</td>
                            <td>{{$treatment_type_2_count_first}}</td>
                        </tr>
                        <tr>
                            <td>Давтан</td>
                            <td>{{$treatment_type_2_count_again}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-5">
                    <h6 class="mb-4">Char title</h6>
                    <div class="chart-container">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script src="{{asset('js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/vendor/Sortable.js')}}"></script>

    <script type="text/javascript">
       if (document.getElementById("productChart")) {
        var productChart = document
          .getElementById("productChart")
          .getContext("2d");
        var myChart = new Chart(productChart, {
          type: "BarWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    stepSize: 100,
                    min: 300,
                    max: 800,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            },
            tooltips: chartTooltip
          },
          data: {
            labels: ["January", "February", "3", "April", "May", "June"],
            datasets: [
              {
                label: "Cakes",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [456, 479, 324, 569, 702, 600],
                borderWidth: 2
              },
              {
                label: "Desserts",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [364, 504, 605, 400, 345, 320],
                borderWidth: 2
              }
            ]
          }
        });
      }
    </script>
@endsection
