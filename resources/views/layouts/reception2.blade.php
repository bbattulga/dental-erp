    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Diverse Solutions</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--<link rel="stylesheet" href="{{asset('font/iconsmind/style.css')}}" />--}}
        {{--<link rel="stylesheet" href="{{asset('font/simple-line-icons/css/simple-line-icons.css')}}" />--}}

        {{--<link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}" />--}}
        {{--<link rel="stylesheet" href="{{asset('css/vendor/perfect-scrollbar.css')}}" />--}}
        {{--<link rel="stylesheet" href="{{asset('css/main.css')}}" />--}}
        {{--<link rel="stylesheet" href="{{asset('css/dore.light.blue.min.css')}}" />--}}
        <link rel="stylesheet" href="{{asset('font/iconsmind/style.css')}}" />
        <link rel="stylesheet" href="{{asset('font/simple-line-icons/css/simple-line-icons.css')}}" />

        <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{asset('css/vendor/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('css/main.css')}}" />
        <link rel="stylesheet" href="{{asset('css/dore.light.orange.min.css')}}" />
        @yield('header')
    </head>

    <body id="app-container" class="menu-sub-hidden show-spinner">
        <nav class="navbar fixed-top">
            <div class="d-flex align-items-center navbar-left">
                <a href="#" class="menu-button d-none d-md-block">
                    <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                        <rect x="0.48" y="0.5" width="7" height="1" />
                        <rect x="0.48" y="7.5" width="7" height="1" />
                        <rect x="0.48" y="15.5" width="7" height="1" />
                    </svg>
                    <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                        <rect x="1.56" y="0.5" width="16" height="1" />
                        <rect x="1.56" y="7.5" width="16" height="1" />
                        <rect x="1.56" y="15.5" width="16" height="1" />
                    </svg>
                </a>
    
                <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                        <rect x="0.5" y="0.5" width="25" height="1" />
                        <rect x="0.5" y="7.5" width="25" height="1" />
                        <rect x="0.5" y="15.5" width="25" height="1" />
                    </svg>
                </a>
    
                {{--Search box--}}
    
    
                {{--<div class="search">--}}
                {{--<form action="{{url('/reception/search')}}" method="get" role="search">--}}
                {{--@csrf--}}
                {{--<input placeholder="Хайх..." name="key" autocomplete="off">--}}
                {{--<span class="search-icon">--}}
                {{--<i class="simple-icon-magnifier"></i>--}}
                {{--</span>--}}
                {{--</form>--}}
                {{--</div>--}}

                <div class="search" data-search-path="Layouts.Search.html?q=">
                <input id="dore-admin-search" placeholder="Search...">
                <span class="search-icon">
                    <i class="simple-icon-magnifier"></i>
                </span>
            </div>
    
            </div>
    
    
            <a class="navbar-logo">
                <span class="d-none d-xs-block"><img style="width: 55%; height: auto;max-width: 100px;"
                        src="{{asset('img/logo-black.png')}}"></span>
                <span class="logo-mobile d-block d-xs-none"></span>
            </a>
    
            <div class="navbar-right">
              
    
    
                <div class="header-icons d-inline-block align-middle">
                   
    
    
                    <div class="position-relative d-inline-block">
                        <button class="header-icon btn btn-empty" type="button" id="notificationButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="simple-icon-bell"></i>
                            <span class="count">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right mt-3 scroll position-absolute"
                            id="notificationDropdown">
                            
                            <!--
                            <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                               <p class="font-weight-bold">Өвчтөний нэр </p>
                                <div class="pl-3 pr-2">
                                    <a href="#">
                                        <p class="font-weight-small mb-1">2 цаг захиалсан байна!</p>
                                        <p class="text-muted mb-0 text-small">09.04.2018 - 12:45-13:45</p>
                                    </a>
                                </div>
                            </div>
                            -->
    
                        </div>
                    </div>
    
                    <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                        <i class="simple-icon-size-fullscreen"></i>
                        <i class="simple-icon-size-actual"></i>
                    </button>
    
                </div>
    
                <div class="user d-inline-block">
                @php
                    $user = \Illuminate\Support\Facades\Auth::user();
                @endphp
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="name">{{$user->name}}</span>
                    <span>
                        <img alt="Profile Picture" src="{{$user->profile_pic}}" />
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3">
                    <a class="dropdown-item" href="#">Account</a>
                    <a class="dropdown-item" href="#">Features</a>
                    <a class="dropdown-item" href="{{url('/logout')}}">Sign out</a>
                </div>
            </div>
    
    
    
            </div>
        </nav>
    <div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled" data-link="time">
                    <li id="receptionTime">
                        <a href="{{url('/reception/time')}}">
                            <i class="iconsmind-Alarm"></i> Цаг
                        </a>
                    </li>
                    <li id="receptionPayment">
                        <a href="{{url('/reception/payment')}}">
                            <i class="iconsmind-Money-2"></i> Төлбөр
                        </a>
                    </li>
                    <li id="receptionUser">
                        <a href="{{url('/reception/user')}}">
                            <i class="iconsmind-Administrator"></i> Үйлчлүүлэгч
                        </a>
                    </li>
                    <li id="receptionShifts">
                        <a href="{{url('/reception/shifts')}}">
                            <i class="iconsmind-Calendar-3"></i> Ээлж
                        </a>
                    </li>
                    <li id="receptionLease">
                        <a href="{{url('/reception/lease')}}">
                            <i class="iconsmind-Money-Bag"></i> Зээл
                        </a>
                    </li>
                    <li id="receptionProduct">
                        <a href="{{url('/reception/product')}}">
                            <i class="iconsmind-Present"></i> Бараа
                        </a>
                    </li>

                </ul>
            </div>
        </div>


    </div>
    <main>
        <div class="container-fluid">
            @yield('content')
        </div>
        @yield('subcontent')
    </main>
    {{--<script src="{{asset('js/vendor/jquery-3.3.1.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/vendor/perfect-scrollbar.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/vendor/mousetrap.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/dore.script.js')}}"></script>--}}
    {{--<script src="{{asset('js/scripts.single.theme.js')}}"></script>--}}
    <script src="{{asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/vendor/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('js/vendor/mousetrap.min.js')}}"></script>
    @yield('footer')
    <script src="{{asset('js/dore.script.js')}}"></script>
    <script src="{{asset('js/scripts.single.theme.js')}}"></script>
    </body>

    </html>