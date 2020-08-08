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

    <style>
        .ct-point {
            stroke-width: 0.4rem;
            cursor: pointer;
        }

        .ct-line{
            stroke-width: 0.16rem;
        }
    </style>
@endsection
@section('content')
    <!-- Menu active-->
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
    </div>

    @php
        function moneyFormat($amount){
        $b = $amount/1000000000;
        $m = $amount/1000000;
        if ($b>=1){
            return $b . ' тэрбум ₮';
        }
        return $m . ' сая ₮';
    }
    @endphp

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <label>Хугацаа сонгох</label>
                            <div class="input-daterange input-group mb-3" id="datepicker" data-date-format="yyyy-mm-dd">
                                <input id="input-start-date" type="text" class="input-sm form-control" name="start" placeholder="Start" value="{{ $start_date }}"/>
                                <span class="input-group-addon">

                                </span>
                                <input id="input-end-date" type="text" class="input-sm form-control" name="end" placeholder="End" value="{{ $end_date }}">
                                <span class="input-group-addon" style="margin-left: 5px;">
                                    <button class="btn btn-primary mh-2"
                                        onclick="handleSelectDate($('#input-start-date').val(), $('#input-end-date').val())">үзэх</button>
                                </span>
                            </div>
                            <div class="mb-5"></div>
                        <div class="row">
                            <div class="col-lg-6 mb-5">
                                <h6>Ачаалал</h6>
                                <h7 class="mb-3" style="float: left;">Нийт - {{ $total_workload }} хүн</h7>
                                <div id="workload-chart" class="chart-container">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <h6>Орлого (сая ₮)</h6>
                                <h7 class="mb-3" style="float: left;">Нийт - {{ moneyFormat($total_revenue) }}</h7>
                                <div id="revenue-chart" class="chart-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <input type="hidden" id="input-dates" value="{{$dates}}">
    <input type="hidden" id="input-workloads" value="{{$workloads}}">
    <input type="hidden" id="input-revenues" value="{{$revenues}}">

@endsection
@section('footer')
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
    <script src="{{asset('js/dore.script.js')}}"></script>


    <script type="text/javascript">


        function revenueFormat(revStr){
            let rev = parseInt(revStr);
            let million = rev / Math.pow(10, 6);
            let rest = rev%Math.pow(10, 6);
            return `${million}`;
        }

        let workloads = JSON.parse($('#input-workloads').val());
        console.log('workloads');
        console.log(workloads);
        let revenues = JSON.parse($('#input-revenues').val());
        console.log('revenues');
        console.log(revenues);
        let lbl = JSON.parse($('#input-dates').val());
        lbl.push('');
        console.log(lbl);

        let xlabels = [lbl[0], lbl[parseInt(lbl.length/4)], lbl[parseInt(lbl.length/2)], lbl[parseInt(lbl.length/1.5)], lbl[lbl.length-2]];
        function dateFormat(dateStr){
            for(let i=0; i<xlabels.length; i++){
                if (!dateStr.localeCompare(xlabels[i])){
                    return dateStr.slice(5, dateStr.length);
                }
            }
            return '';
        }

       new Chartist.Line('#workload-chart', {
                            labels: lbl,
                            series: [workloads]
                        }, {
                            fullWidth: true,
                            chartPadding: {
                                right: 10
                            },
                            axisX: {
                                  labelInterpolationFnc: function(value) {
                                    // Will return Mon, Tue, Wed etc. on medium screens
                                    return dateFormat(value);
                                  }
                                },
                        }).on('draw', function(data){
                            if (data.type === "point") {
                                    data.element._node.setAttribute("title", "Үйлчүүлсэн: " + data.value.y);
                                    data.element._node.setAttribute("data-chart-tooltip", "chart2");
                                }
                        });
         $("#workload-chart").tooltip({
            selector: '[data-chart-tooltip="chart2"]',
            container: "body",
            html: true
        });


        new Chartist.Line('#revenue-chart', {
                            labels: lbl,
                            label: 'y',
                            series: [revenues]
                        }, {
                            high: Math.max.apply(null, revenues),
                            axisY: {
                                axisTitle: 'сая ₮',
                                  labelInterpolationFnc: function(value) {
                                    // Will return Mon, Tue, Wed etc. on medium screens
                                    return revenueFormat(value);
                                  }
                                },
                            axisX: {
                                  labelInterpolationFnc: function(value) {
                                    // Will return Mon, Tue, Wed etc. on medium screens
                                    return dateFormat(value);
                                  }
                                },
                            fullWidth: true,
                            chartPadding: {
                                right: 10
                            }
                        }).on('draw', function(data){
                            if (data.type === "point") {
                                    data.element._node.setAttribute("title", "Орлого: " + data.value.y + '₮');
                                    data.element._node.setAttribute("data-chart-tooltip", "chart2");
                            }
                        })

        $("#revenue-chart").tooltip({
            selector: '[data-chart-tooltip="chart2"]',
            container: "body",
            html: true
        });

        function handleSelectDate(startDate, endDate){
            console.log(startDate, endDate);
            window.location.href = `/admin/dashboard/${startDate}/${endDate}`;
        }

    </script>
@endsection
