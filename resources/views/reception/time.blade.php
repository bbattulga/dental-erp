@extends('layouts.reception2')
@section('header')
    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}"/>

     <link rel="stylesheet"
        href="{{asset('js/apps/timetable/bundle.css')}}"/>

    <style>
        body{
            position: relative;
        }
        .hidden {
            opacity: 0;
            background-color: white;
            border: 0px;
        }

        .hidden:hover, .hidden:focus {
            opacity: 0.2;
            background-color: #8f8f8f;
        }

        #timetable-calendar{
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 3;
            color: white;
            width: 300px;
            height: 300px;
        }
        #timetable{
            position: relative;
            width: 100%;
            margin: 0;
            background-color: white;
        }


    </style>
    {{--End css style gh met link file oruulna--}}
@endsection

@section('content')
    <script>
        document.getElementById('receptionTime').classList.add('active');
    </script>

    <div class="row app-row">
        <div class="col-12">
            <div id="timetable"></div>
        </div>
    </div>

@endsection

@section('subcontent')

        <div class="app-menu">
            <div class="p-4">
                <div class="scroll">
                    <div class="card-body">
                        <div class="form-group">
                         <div class="date-inline">
                        </div>
                    </div>

                    <p class="text-muted text-small">Status</p>
                    <ul class="list-unstyled mb-5">
                        <li class="">
                            <a href="#" id="time-total">
                                <i class=""></i>
                                Шар - бүртгэлгүй
                                <span class="float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="" id="time-done"></i>
                                Цагаан - бүртгэлтэй
                                <span class="float-right"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- get selected date by adding onchange handler -->
        <input id="input-date-selected" type="hidden">
@endsection

@section('footer')
    </script> 
    {{--Scriptuudiig include hiiideg heseg--}}
    <script src="{{asset('js/apps/timetable/bundle.js')}}"></script>
    <script src="{{asset('/js/vendor/bootstrap-datepicker.js')}}"></script>
@endsection