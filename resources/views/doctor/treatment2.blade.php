@extends('layouts.doctor')
@section('header')
<link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}" />

<link rel="stylesheet" href="{{asset('js/apps/doctor-treatment/bundle.css')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .scroll {
        height: 350px;
        overflow-y: scroll;
        width: 100%;
    }

    .invisible{
        opacity: 0;
    }

    .tooth {
        opacity: 0.5;
    }

    .tooth-type{
        font-size: 12px;
        color: gray;
    }

    polygon {
        margin: auto;
        display: block;
        stroke-width: 1;
        stroke: darkgrey;
        fill: transparent;
    }

    circle {
        stroke-width: 1;
        stroke: darkgrey;
        fill: white;
    }

    /*

                circle:hover {
                    fill : aqua;
                }
        */
    .lombo {
        fill: #138496;
        animation-duration: 0.3s;
    }

    .empty {
        fill: white;
        animation-duration: 0.3s;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #138496;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .line {
        margin: 10px;
        border-left: thick solid orange;
    }

    .zoom {
        display: inline-block;
        position: relative;
    }

    /* magnifying glass icon */
    .zoom:after {
        content: '';
        display: block;
        width: 33px;
        height: 33px;
        position: absolute;
        top: 0;
        right: 0;
        /*background:url(icon.png);*/
    }

    .zoom img {
        display: block;
    }

    .zoom img::selection {
        background-color: transparent;
    }

    .hidden{
        visibility: hidden;
    }

    .symptom-text{
        width: 100%;
    }

</style>

{{--End css style gh met link file oruulna--}}
@endsection
@section('content')

<script>
    document.getElementById('doctorTreatment').classList.add('active');
</script>

<input type="hidden" id="checkin" value="{{ $checkin }}">

@endsection
@section('footer')

</script>

<script src="{{asset('js/symptoms.js')}}"></script>
<script src="{{asset('js/vendor/Chart.bundle.min.js')}}"></script>
<script src="{{asset('js/vendor/chartjs-plugin-datalabels.js')}}"></script>
<script src="{{asset('js/vendor/moment.min.js')}}"></script>
<script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
<script src="{{asset('js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('js/vendor/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/vendor/progressbar.min.js')}}"></script>
<script src="{{asset('js/vendor/jquery.barrating.min.js')}}"></script>
<script src="{{asset('js/vendor/jquery.zoom.min.js')}}"></script>
<script src="{{asset('js/vendor/select2.full.js')}}"></script>
<script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
<script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/vendor/Sortable.js')}}"></script>

<script src="{{asset('js/apps/doctor-treatment/bundle.js')}}"></script>
{{--Scriptuudiig include hiiideg heseg--}}
@endsection