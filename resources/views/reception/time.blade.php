@extends('layouts.reception')
@section('header')
    <link rel="stylesheet" href="{{asset('font/iconsmind/style.css')}}" />
    <link rel="stylesheet" href="{{asset('font/simple-line-icons/css/simple-line-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.contextMenu.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/vendor/select2-bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />

     <link rel="stylesheet"
        href="{{asset('js/apps/timetable/public/build/bundle.css')}}"/>

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
            <div class="mb-2" style="height: 100%;">
                <div id="timetable"></div>
            </div>
        </div>
    </div>
@endsection

@section('content-menu')
        <div class="app-menu">
            <div class="p-4">
                <div class="scroll">
                    <p class="text-muted text-small">Status</p>
                    <ul class="list-unstyled mb-5">
                        <li class="active">
                            <a href="#">
                                <i class="simple-icon-refresh"></i>
                                Pending Tasks
                                <span class="float-right">12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="simple-icon-check"></i>
                                Completed Tasks
                                <span class="float-right">24</span>
                            </a>
                        </li>
                    </ul>

                    <p class="text-muted text-small">Categories</p>
                    <ul class="list-unstyled mb-5">
                        <li>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="category1">
                                <label class="custom-control-label" for="category1">Flexbox</label>
                            </div>
                        </li>
                        <li>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="category2">
                                <label class="custom-control-label" for="category2">Sass</label>
                            </div>
                        </li>
                        <li>
                            <div class="custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="category3">
                                <label class="custom-control-label" for="category3">React</label>
                            </div>
                        </li>
                    </ul>




                    <p class="text-muted text-small">Labels</p>
                    <div>
                        <p class="d-sm-inline-block mb-1">
                            <a href="#">
                                <span class="badge badge-pill badge-outline-primary mb-1">NEW FRAMEWORK</span>
                            </a>
                        </p>

                        <p class="d-sm-inline-block mb-1">
                            <a href="#">
                                <span class="badge badge-pill badge-outline-theme-3 mb-1">EDUCATION</span>
                            </a>
                        </p>
                        <p class="d-sm-inline-block  mb-1">
                            <a href="#">
                                <span class="badge badge-pill badge-outline-secondary mb-1">PERSONAL</span>
                            </a>
                        </p>
                    </div>

                </div>
            </div>
            <a class="app-menu-button d-inline-block d-xl-none" href="#">
                <i class="simple-icon-refresh"></i>
            </a>
        </div>
@endsection

@section('footer')
    {{--Scriptuudiig include hiiideg heseg--}}
    <script src="{{asset('/js/apps/timetable/public/build/bundle.js')}}"></script>
@endsection