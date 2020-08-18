@extends('layouts.doctor')
@section('header')
<link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('js/apps/doctor-treatment/bundle.css')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .scroll {
        height: 350px;
        overflow-y: scroll;
        width: 100%;
    }

    .penone{
        pointer-events: none;
    }

    .p5Canvas{
        pointer-events: none;
        position: absolute;
        top: 0;
        left: 0;
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
<script src="{{asset('plugin/datatables/jszip.min.js')}}"></script>
<script src="{{asset('plugin/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('plugin/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('js/apps/doctor-treatment/bundle.js')}}"></script>
{{--Scriptuudiig include hiiideg heseg--}}
@endsection