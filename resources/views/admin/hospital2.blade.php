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

    <link href="{{asset('js/apps/hospital-tailan/public/build/bundle.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('plugin/switchery/switchery.min.css')}}" rel="stylesheet"/>
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
                    <input id="date-start" name="start_date" class="form-control"
                            type="date"
                           style="background-color: #f8f8f8; border-color: #f8f8f8; border-bottom-color: #8f8f8f; color: #8f8f8f; padding: 0px"
                           placeholder="Эхлэл"
                           value="{{ $start_date }}">
                           &nbsp;&nbsp;&nbsp;<span
                            style="color: #8f8f8f">-&nbsp;&nbsp;&nbsp;</span>
                    <input id="date-end" name="end_date" class="form-control"
                            type="date"
                           style="background-color: #f8f8f8; border-color: #f8f8f8; border-bottom-color: #8f8f8f; color: #8f8f8f; padding: 0px"
                           placeholder="Төгсгөл"
                           value="{{ $end_date }}">
                           &nbsp;&nbsp;&nbsp;
                    <a id="show-datebetween" href="#" onclick="$(this).closest('form').submit()" style="color: #8f8f8f">үзэх</a>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <form id="monthSearch" action="{{url('/admin/hospital/by_month')}}" method="post">
                @csrf
                <select name="year">
                    @if(!empty($start_date))
                        <option value="{{date('Y', strtotime($start_date))}}">{{date('Y', strtotime($start_date))}}</option>
                        @for($m = 2019; $m<=2027; $m++)
                            @if($m != date('Y', strtotime($start_date)))
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
                        <option value="{{date('m', strtotime($start_date))}}">{{date('m', strtotime($start_date))}}</option>
                        @for($m = 1; $m<=12; $m++)
                            @if($m != date('m', strtotime($start_date)))
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

@endsection
@section('footer')
    <script src="{{asset('js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/vendor/Sortable.js')}}"></script>

    <script src="{{asset('js/apps/hospital-tailan/public/build/bundle.js')}}"></script>
@endsection