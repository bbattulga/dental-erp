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
<!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>   -->  
<script src="{{asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
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
<div id="treatmentTypeModal" class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modalBuri">

            </div>
        </div>
    </div>
</div>
<div id="treatmentWithLimit" class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Үнэн дүнг оруулна уу</h5>
                <input type="number" class="form-control" id="treatmentWithLimitPrice">
                <input type="hidden" id="treatmentWithLimitPriceMin">
                <input type="hidden" id="treatmentWithLimitPriceMax">
                <input type="hidden" id="treatmentSelectionIdWithLimit">
                <br>
                <button class="btn btn-primary" style="border-radius: 0px"
                    onclick="treatmentSelectionWithLimit()">Оруулах</button>
            </div>
        </div>
    </div>
</div>
<div id="singleTreatmentWithLimit" class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Үнэн дүнг оруулна уу</h5>
                <input type="number" class="form-control" id="singleTreatmentWithLimitPrice">
                <input type="hidden" id="singleTreatmentWithLimitPriceMin">
                <input type="hidden" id="singleTreatmentWithLimitPriceMax">
                <input type="hidden" id="singleTreatmentWithLimitId">
                <br>
                <button class="btn btn-primary" style="border-radius: 0px"
                    onclick="singleTreatmentWithLimit()">Оруулах</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade notes-modal" tabindex="-1" role="dialog" aria-hidden="true" onclick="clearNotes();">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" onclick="event.stopPropagation();">
            <div class="modal-header">
                <h5 class="modal-title" id="notes-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" onclick="$('.notes-modal').modal('hide'); clearNotes();">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Шинж тэмдэг</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" id="input-symptom"></textarea>
                </div>
                <div class="mb-3"></div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Онош</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" id="input-diagnose"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.notes-modal').modal('hide'); skipNotes()">
                    алгасах</button>
                <button type="button" class="btn btn-primary" onclick="$('.notes-modal').modal('hide'); saveNotes()" 
                    data-dismiss="modal">Үргэлжлүүлэх</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-center" id="lomboModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <br>
                <br>
                <h3><b>
                        <div id="buriLombo">Шүд #</div>
                    </b></h3>
                <input type="hidden" id="hiddenDecayChart" value="">
                <svg height="200" width="200">
                    <polygon id="pol1" points="0,0 100,100 200,0" onclick="myFunction('1')" />
                    <polygon id="pol2" points="100,100 200,0 200,200" onclick="myFunction('2')" />
                    <polygon id="pol4" points="0,200 100,100 200,200" onclick="myFunction('4')" />
                    <polygon id="pol8" points="0,0 100,100 0,200" onclick="myFunction('8')" />
                    <circle id="pol16" cx="100" cy="100" r="50" onclick="myFunction('16')" />
                </svg>
                <div>
                    <br>
                    <h5 style="color: darkgrey"><b>Цоорлын зэрэг</b></h5>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <input type="hidden" id="radioDecayLevel" value="1">
                        <label class="btn btn-info active">
                            <input type="radio" name="decayLevel" id="option1" checked
                            onchange="$('#radioDecayLevel').val(1)"> 1
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="decayLevel" id="option2"
                            onchange="$('#radioDecayLevel').val(2)"> 2
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="decayLevel" id="option3"
                            onchange="$('#radioDecayLevel').val(3)"> 3
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="decayLevel" id="option4"
                            onchange="$('#radioDecayLevel').val(4)"> 4
                        </label>
                    </div>
                </div>
                <br>
                <h5 style="color: darkgrey"><b>Сүүн шүд</b></h5>
                <label class="switch">
                    <input type="checkbox" id="suunShudToggle" onchange="toggleMilkTeeth()">
                    <span class="slider round"></span>
                </label>
                <br>
                <br>
                <button class="btn btn-info btn-ls" onclick="decaySubmit()">ОРУУЛАХ</button>
                <!--                                            content modal-->
            </div>
        </div>
    </div>
</div>

<!-- lombo treatment note modal -->
<div class="modal fade" id="lomboNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lombo-note-title"></h5>
                <h6 id="lombo-note-subtitle"></h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1rem 0;">
                <table class="table table-bordered">
                    <thead style="background-color: #2a7eeb; color: white;">
                        <tr>
                            <td>#</td>
                            <td>Шинж тэмдэг</td>
                            <td>Онош</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div id="lombo-note-symptom"></div>
                            </td>
                            <td>
                                <div id="lombo-note-diagnosis"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        -->
        </div>
    </div>
</div>
<!-- end lombo treatment note modal -->

<!-- show summaries -->
<div class="modal fade" id="allNotesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow: auto;">
            <div class="modal-header">
                <h5 class="modal-title">Шинж тэмдэг, онош</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1rem 0;">
                <table class="table table-bordered">
                    <thead style="background-color: #2a7eeb; color: white; position: sticky; top:0;">
                        <tr>
                            <td>#</td>
                            <td>Шинж тэмдэг</td>
                            <td>Онош</td>
                            <td>Шүд</td>
                            <td>Эмчилгээ</td>
                            <td>Өдөр</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($checkin_all as $_checkin)
                            @foreach($_checkin->treatments as $_user_treatment)
                            @if($_user_treatment->treatment_note)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>
                                    <div>{{ $_user_treatment->treatment_note->symptom }}</div>
                                </td>
                                <td>
                                    <div>
                                        {{ $_user_treatment->treatment_note->diagnosis }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @php
                                            $tooth_id = $_user_treatment->tooth_id;
                                            $tooth_title = $tooth_id != null? "#$tooth_id":'Бүх шүд';
                                        @endphp
                                        {{ $tooth_title }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $_user_treatment->treatment->name }}
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $_user_treatment->treatment_note->created_at }}</div>
                                </td>
                            </tr>
                             @php $i++ @endphp
                            @endif
                            @endforeach
                        @endforeach 
                    </tbody>
                </table>
            </div>
            <!--
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        -->
        </div>
    </div>
</div>

<form id="treatmentForm" method="post" action="{{url('/doctor/treatment/store')}}">
    @csrf
    <input type="hidden" name="treatment_id" value="" id="treatmentId">
    <input type="hidden" name="treatment_selection_id" value="" id="treatmentSelectionId">
    <input type="hidden" name="tooth_id" value="" id="toothId">
    <input type="hidden" name="user_id" value="{{$checkin->user_id}}" id="userId">
    <input type="hidden" name="value_id" value="" id="valueId">
    <input type="hidden" name="price" value="" id="treatmentPrice">
    <input type="hidden" name="checkin_id" value="{{$checkin->id}}" id="checkin_id">
    <input type="hidden" name="description" id="treatmentDescription">
    <input type="hidden" name="decay_level" id="decayLevel">
    <input type="hidden" name="tooth_type_id" id="toothTypeId">
    <input type="hidden" name="symptom" id="formInputSymptom">
    <input type="hidden" name="diagnosis" id="formInputDiagnosis">
</form>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div style="background-color: white; color: black; 
                display: inline-block; font-size: 2.3em;
                position: absolute; top: 0; right: 0; cursor: pointer;">
                <div class="glyph" data-toggle="modal" data-target="#allNotesModal">
                    <div class="glyph-icon simple-icon-notebook"></div>
                </div>
            </div>
            <div class="card-body mb-2">
                <div class="table-responsive">
                    <table class="table text-center">
                        <tr>
                            @for($i = 18; $i>=11; $i--)
                            <td style="color: grey;">
                                {{$i}}
                            </td>
                            @endfor
                            @for($i = 21; $i<=28; $i++) <td style="color: grey">
                                {{$i}}
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            @for($i = 18; $i>=11; $i--)
                            <?php
                                    $special_treatment = 0;
                                    $tooth_special_treatments = array(3,4,5,6,7,8,9,23);
                                    $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                                    $tooth_treatments = $user_treatments->where('tooth_id', $i);
                                    if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                                        $limit_date = $resetTreatment->created_at;
                                    }
                                    $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                                    foreach($tooth_treatments as $tooth_treatment) {
                                        for($a = 0; $a<sizeof($tooth_special_treatments); $a++) {
                                            if($tooth_treatment->treatment_id == $tooth_special_treatments[$a]) {
                                                $special_treatment = $tooth_special_treatments[$a];
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                            <td>
                                @switch($special_treatment)
                                @case(3)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_burees.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(4)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_extraction.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(5)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_implant.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(6)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_paalan.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(7)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(8)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post_cast.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(9)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(23)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @default
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @endswitch

                                @foreach($user_tooths as $ut)
                                    @if ($ut->tooth->code == $i)
                                        <div id="{{$i}}-toothmark" class="tooth-type">
                                            {{ $ut->tooth_type->shortName }}
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                            @for($i = 21; $i<=28; $i++) 
                                <?php
                                        $special_treatment = 0;
                                        $tooth_special_treatments = array(3,4,5,6,7,8,9,23);
                                        $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                                        $tooth_treatments = $user_treatments->where('tooth_id', $i);
                                        if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                                            $limit_date = $resetTreatment->created_at;
                                        }
                                        $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                                        foreach($tooth_treatments as $tooth_treatment) {
                                            for($a = 0; $a<sizeof($tooth_special_treatments); $a++) {
                                                if($tooth_treatment->treatment_id == $tooth_special_treatments[$a]) {
                                                    $special_treatment = $tooth_special_treatments[$a];
                                                    break;
                                                }

                                            }
                                        }
                                        ?> <td>
                                @switch($special_treatment)
                                @case(3)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_burees.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(4)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_extraction.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(5)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_implant.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(6)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_paalan.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(7)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(8)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post_cast.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(9)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(23)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @default
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @endswitch
                                    @foreach($user_tooths as $ut)
                                        @if ($ut->tooth->code == $i)
                                            <div id="{{$i}}-toothmark" class="tooth-type">
                                                {{ $ut->tooth_type->shortName }}
                                            </div>
                                        @endif
                                    @endforeach
                                @endfor
                                </td>
                        </tr>
                        <tr>
                            @for($i = 18; $i>=11; $i--)
                            <td>
                                <?php
                                        $tooth_value = array();
                                        $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                                        $tooth_treatments = $user_treatments->where('tooth_id', $i);
                                        if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                                            $limit_date = $resetTreatment->created_at;
                                        }
                                        $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                                        foreach($tooth_treatments as $tooth_treatment) {
                                            $tooth_treatment_value =  $tooth_treatment->value;
                                            $tooth_treatment_value_array =  array();
                                            while($tooth_treatment_value >= 1) {
                                                array_push($tooth_treatment_value_array, $tooth_treatment_value%2);
                                                $tooth_treatment_value = (int) $tooth_treatment_value/2;
                                            }
                                            $tooth_treatment_value_array = array_reverse($tooth_treatment_value_array);
                                            for($c = 0; $c < sizeof($tooth_treatment_value_array); $c++) {
                                                $checker = 1;
                                                $tooth_treatment_value_array[$c] = $tooth_treatment_value_array[$c] * pow(2,(sizeof($tooth_treatment_value_array) - $c - 1));
                                                for ($t = 0; $t < sizeof($tooth_value); $t++) {
                                                    if($tooth_value[$t] == $tooth_treatment_value_array[$c]) {
                                                        $checker = 0;
                                                    }
                                                }
                                                if($checker == 1) {
                                                    array_push($tooth_value, $tooth_treatment_value_array[$c]);
                                                }
                                            }
                                        }
                                        ?>


                                <input type="hidden" id="shud{{$i}}" value="{{array_sum($tooth_value)}}">
                                <svg height="25" width="25">
                                    <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                        onclick="changeStyle({{$i}})" />
                                    <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                        onclick="changeStyle({{$i}})" />
                                </svg>
                            </td>
                            @endfor
                            @for($i = 21; $i<=28; $i++) <td>
                                <?php
                                        $tooth_value = array();
                                        $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                                        $tooth_treatments = $user_treatments->where('tooth_id', $i);
                                        if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                                            $limit_date = $resetTreatment->created_at;
                                        }
                                        $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                                        foreach($tooth_treatments as $tooth_treatment) {
                                            $tooth_treatment_value =  $tooth_treatment->value;
                                            $tooth_treatment_value_array =  array();
                                            while($tooth_treatment_value >= 1) {
                                                array_push($tooth_treatment_value_array, $tooth_treatment_value%2);
                                                $tooth_treatment_value = (int) $tooth_treatment_value/2;
                                            }
                                            $tooth_treatment_value_array = array_reverse($tooth_treatment_value_array);
                                            for($c = 0; $c < sizeof($tooth_treatment_value_array); $c++) {
                                                $checker = 1;
                                                $tooth_treatment_value_array[$c] = $tooth_treatment_value_array[$c] * pow(2,(sizeof($tooth_treatment_value_array) - $c - 1));
                                                for ($t = 0; $t < sizeof($tooth_value); $t++) {
                                                    if($tooth_value[$t] == $tooth_treatment_value_array[$c]) {
                                                        $checker = 0;
                                                    }
                                                }
                                                if($checker == 1) {
                                                    array_push($tooth_value, $tooth_treatment_value_array[$c]);
                                                }
                                            }
                                        }
                                        ?>
                                <input type="hidden" id="shud{{$i}}" value="{{array_sum($tooth_value)}}">
                                <svg height="25" width="25">
                                    <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                        onclick="changeStyle({{$i}})" />
                                    <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                        onclick="changeStyle({{$i}})" />
                                </svg>
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            @for($i = 48; $i>=41; $i--)
                            <td>
                                <?php
                                        $tooth_value = array();
                                        $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                                        $tooth_treatments = $user_treatments->where('tooth_id', $i);
                                        if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                                            $limit_date = $resetTreatment->created_at;
                                        }
                                        $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                                        foreach($tooth_treatments as $tooth_treatment) {
                                            $tooth_treatment_value =  $tooth_treatment->value;
                                            $tooth_treatment_value_array =  array();
                                            while($tooth_treatment_value >= 1) {
                                                array_push($tooth_treatment_value_array, $tooth_treatment_value%2);
                                                $tooth_treatment_value = (int) $tooth_treatment_value/2;
                                            }
                                            $tooth_treatment_value_array = array_reverse($tooth_treatment_value_array);
                                            for($c = 0; $c < sizeof($tooth_treatment_value_array); $c++) {
                                                $checker = 1;
                                                $tooth_treatment_value_array[$c] = $tooth_treatment_value_array[$c] * pow(2,(sizeof($tooth_treatment_value_array) - $c - 1));
                                                for ($t = 0; $t < sizeof($tooth_value); $t++) {
                                                    if($tooth_value[$t] == $tooth_treatment_value_array[$c]) {
                                                        $checker = 0;
                                                    }
                                                }
                                                if($checker == 1) {
                                                    array_push($tooth_value, $tooth_treatment_value_array[$c]);
                                                }
                                            }
                                        }
                                        ?>
                                <input type="hidden" id="shud{{$i}}" value="{{array_sum($tooth_value)}}">
                                <svg height="25" width="25">
                                    <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                        onclick="changeStyle({{$i}})" />
                                    <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                        onclick="changeStyle({{$i}})" />
                                </svg>
                            </td>
                            @endfor
                            @for($i = 31; $i<=38; $i++) <td>
                                <?php
                                        $tooth_value = array();
                                        $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                                        $tooth_treatments = $user_treatments->where('tooth_id', $i);
                                        if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                                            $limit_date = $resetTreatment->created_at;
                                        }
                                        $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                                        foreach($tooth_treatments as $tooth_treatment) {
                                            $tooth_treatment_value =  $tooth_treatment->value;
                                            $tooth_treatment_value_array =  array();
                                            while($tooth_treatment_value >= 1) {
                                                array_push($tooth_treatment_value_array, $tooth_treatment_value%2);
                                                $tooth_treatment_value = (int) $tooth_treatment_value/2;
                                            }
                                            $tooth_treatment_value_array = array_reverse($tooth_treatment_value_array);
                                            for($c = 0; $c < sizeof($tooth_treatment_value_array); $c++) {
                                                $checker = 1;
                                                $tooth_treatment_value_array[$c] = $tooth_treatment_value_array[$c] * pow(2,(sizeof($tooth_treatment_value_array) - $c - 1));
                                                for ($t = 0; $t < sizeof($tooth_value); $t++) {
                                                    if($tooth_value[$t] == $tooth_treatment_value_array[$c]) {
                                                        $checker = 0;
                                                    }
                                                }
                                                if($checker == 1) {
                                                    array_push($tooth_value, $tooth_treatment_value_array[$c]);
                                                }
                                            }
                                        }
                                        ?>
                                <input type="hidden" id="shud{{$i}}" value="{{array_sum($tooth_value)}}">
                                <svg height="25" width="25">
                                    <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                        onclick="changeStyle({{$i}})" />
                                    <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                        onclick="changeStyle({{$i}})" />
                                    <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                        onclick="changeStyle({{$i}})" />
                                </svg>
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            @for($i = 48; $i>=41; $i--)
                            <?php
                    $special_treatment = 0;
                    $tooth_special_treatments = array(3,4,5,6,7,8,9,23);
                    $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                    $tooth_treatments = $user_treatments->where('tooth_id', $i);
                    if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                        $limit_date = $resetTreatment->created_at;
                    }
                    $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                    foreach($tooth_treatments as $tooth_treatment) {
                        for($a = 0; $a<sizeof($tooth_special_treatments); $a++) {
                            if($tooth_treatment->treatment_id == $tooth_special_treatments[$a]) {
                                $special_treatment = $tooth_special_treatments[$a];
                                break;
                            }

                        }
                    }
                    ?>
                            <td>
                                @switch($special_treatment)
                                @case(3)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_burees.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(4)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_extraction.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(5)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_implant.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(6)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_paalan.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(7)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(8)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post_cast.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(9)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(23)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @default
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @endswitch

                                @foreach($user_tooths as $ut)
                                    @if ($ut->tooth->code == $i)
                                        <div id="{{$i}}-toothmark" class="tooth-type">
                                            {{ $ut->tooth_type->shortName }}
                                        </div>
                                    @endif
                                @endforeach

                            </td>
                            @endfor
                            @for($i = 31; $i<=38; $i++) <?php
                        $special_treatment = 0;
                        $tooth_special_treatments = array(3,4,5,6,7,8,9,23);
                        $limit_date = date('Y-m-d', strtotime('2019-01-01'));
                        $tooth_treatments = $user_treatments->where('tooth_id', $i);
                        if($resetTreatment = $tooth_treatments->where('treatment_id', 2)->first()) {
                            $limit_date = $resetTreatment->created_at;
                        }
                        $tooth_treatments = $tooth_treatments->where('created_at', '>', $limit_date);
                        foreach($tooth_treatments as $tooth_treatment) {
                            for($a = 0; $a<sizeof($tooth_special_treatments); $a++) {
                                if($tooth_treatment->treatment_id == $tooth_special_treatments[$a]) {
                                    $special_treatment = $tooth_special_treatments[$a];
                                    break;
                                }

                            }
                        }
                        ?> <td>
                                @switch($special_treatment)
                                @case(3)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_burees.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(4)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_extraction.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(5)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_implant.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(6)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_paalan.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(7)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(8)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_post_cast.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(9)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @case(23)
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'_canal.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @default
                                <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                    onclick="changeStyle({{$i}})">
                                @break
                                @endswitch

                                @foreach($user_tooths as $ut)
                                    @if ($ut->tooth->code == $i)
                                        <div id="{{$i}}-toothmark" class="tooth-type">
                                            {{ $ut->tooth_type->shortName }}
                                        </div>
                                    @endif
                                @endforeach
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            @for($i = 48; $i>=41; $i--)
                            <td style="color: grey">
                                {{$i}}
                            </td>
                            @endfor
                            @for($i = 31; $i<=38; $i++) 
                            <td style="color: grey">
                                {{$i}}
                                </td>
                                @endfor
                        </tr>
                    </table>
                    <h3>Тэмдэглэгээ</h3>
                    <div class="row">
                        <div class="col-lg-9"> 
                            <select id="select-tooth-type" class="form-control"
                                    onchange="handleSelectToothMark(event, this.value)">
                                <option value="" selected></option>
                                @foreach($tooth_types as $tooth_type)
                                    <option value="{{ $tooth_type }}">
                                        {{ $tooth_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                        <button id="btn-delete-tooth-type" 
                                onclick="handleDeleteToothMarks()"
                                type="button" class="btn btn-primary btn-block">
                            Тэмдэглэгээ устгах
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Рентген зураг</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <form method="post" action="{{url('doctor/treatment/xray')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="xray_user_id" value="{{$checkin->user_id}}">
                            <input type="file" name="photo" accept="image/*"> <button class="btn btn-primary"type="submit">Оруулах</button>
                        </form>
                    </div>
                </div>
                <div class="row m-3">
                    @foreach($checkin->user->photos->sortByDesc('id') as $photo)
                    <div class="col-md-6">
                        <span class='zoom' id='xray{{$photo->id}}'>
                            <img src='{{url('img/uploads/'.$photo->path)}}' width='100%' alt='Daisy on the Ohoopee' />
                            <p>{{$photo->created_at}}</p>
                        </span>
                        <script>
                            $(document).ready(function () {
                                $('#xray{{$photo->id}}').zoom({
                                    magnify: 2
                                });
                            })
                        </script>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div><!-- Tooth images ending-->


    <div class="col-md-3">
        <select id="treatmentCategorySelect" class="form-control" onchange="handleSelectTreatmentCategory(event, this.value)">
            @foreach($treatmentCategories as $treatmentCategory)
            @if ($loop->first)
            <option value="{{ $treatmentCategory->id }}" selected> {{ $treatmentCategory->name }} </option>
            @else
            <option value="{{ $treatmentCategory->id }}"> {{ $treatmentCategory->name }} </option>
            @endif
            @endforeach
        </select>
        <br>
        <div class="card">
            <ul class="nav nav-tabs nav-justified ml-0 mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                        aria-controls="first" aria-selected="true">Түүх</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="second-tab" data-toggle="tab" href="#second" role="tab"
                        aria-controls="second" aria-selected="false">Эмчилгээ</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active scroll" id="first" role="tabpanel" aria-labelledby="first-tab">
                    @foreach($user_treatments as $user_treatment)
                    @php
                        $treatment_name = $user_treatment->treatment->name;
                        $history_key = 'treatment-history-'.$loop->index;
                        $treatment_note = $user_treatment->treatment_note;
                        $title = $user_treatment->tooth_id == null? 'Бүх шүд' . " - $treatment_name":"Шүд #".$user_treatment->tooth_id . " - $treatment_name";
                    @endphp
                    <div class="col-md-12 text-left line history{{$user_treatment->tooth_id}}"
                        @if ($treatment_note)
                        onclick="openLomboNoteModal('{{$title}}','{{$treatment_note->symptom}}', '{{$treatment_note->diagnosis}}')"console.log('a') @endif>
                        <b>{{$user_treatment->tooth_id == null? 'Бүх шүд':"Шүд #".$user_treatment->tooth_id}} -
                            {{\App\Treatment::find($user_treatment->treatment_id)->name}}</b>
                        <div class="row">
                            <div class="text-muted col-md-6">
                                @if(is_null($user_treatment->treatment_selection_id) ||
                                $user_treatment->treatment_selection_id == 0)
                                @else
                                {{\App\TreatmentSelections::find($user_treatment->treatment_selection_id)->name}}
                                @endif
                            </div>
                            <div class="text-right text-muted col-md-6">
                                {{date('Y-m-d', strtotime($user_treatment->created_at))}}<br>
                                {{$user_treatment->price}}₮
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="tab-pane scroll" id="second" role="tabpane2" aria-labelledby="second-tab">
                    <div id="treatmentsContainer" class="card-body">
                        @foreach($treatments as $treatment)
                        <!--
                In case of special treatment
                -->
                        <!-- remove comments to see default lombo -->

                        @if($treatment->id == 1)
                        <button class="btn btn-primary btn-block single"
                                onclick="openNotesModal(event, '#lomboModal', '{{$treatment->name}}')">

                            <div class="row">

                                <div class="col-md-12 text-left" onclick="reset()">
                                    {{$treatment->name}} <br>

                                    @if($treatment->treatment_selections()->count() != 0)
                                    {{$treatment->treatment_selections()->count()}} төрөлтэй
                                    @endif
                                </div>

                                @foreach($treatment->treatment_selections as $selection)
                                <input type="hidden"
                                    value="{{$selection->name}}/{{$selection->id}}/{{$selection->price}}/{{$selection->limit}}"
                                    class="treatment_{{$treatment->id}}">
                                @endforeach
                            </div>

                        </button>
                        @else
                        <button class="btn btn-primary btn-block

                        @if($treatment->selection_type == 0)
                            all
                        @elseif($treatment->selection_type == 1)
                            single
                        @else
                            multiple
                        @endif" @if($treatment->treatment_selections->count() != 0)
                            onclick="treatmentButton('{{$treatment->id}}', '{{$treatment->name}}')"
                            @else
                            onclick="singleTreatment('{{$treatment->id}}', '{{$treatment->price}}',
                            '{{$treatment->limit}}', '{{$treatment->name}}')"
                            @endif
                            >
                            <div class="row">
                                <div class="col-md-9 text-left">
                                    {{$treatment->name}}<br>

                                    @if ($treatment->treatment_selections()->count() != 0)
                                    {{$treatment->treatment_selections->count()}}
                                    төрөлтэй
                                    @endif
                                    @foreach($treatment->treatment_selections as $selection)
                                    <input type="hidden"
                                        value="{{$selection->name}}/{{$selection->id}}/{{$selection->price}}/{{$selection->limit}}"
                                        class="treatment_{{$treatment->id}}">
                                    @endforeach
                                </div>
                            </div>
                        </button>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <form action="{{url('/doctor/treatment/finish')}}" method="post" id="treatmentsFinish">
            @csrf
            <br>
            <select class="form-control" name="nurse_id">
                <option value="0">Сувилагч сонгох</option>
                @foreach($nurses as $nurse)
                <option value="{{$nurse->role->id}}">{{substr($nurse->last_name, 0, 2)}}. {{$nurse->name}}</option>
                @endforeach
            </select>
            <br>
            <input type="hidden" name="checkin_id" value="{{$checkin->id}}">
            <button type="button" onclick="finishDate()" class="btn btn-primary btn-block">ДУУСГАХ</button>
        </form>
        <div id="treatmentHistoryModal" class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Хийгдсэн эмчилгээ</h5>
                        <br>
                        @foreach($user_treatments->where('checkin_id', $checkin->id) as $treatment_history)
                        <a href="{{url('/doctor/treatment/history/'.$treatment_history->id)}}">
                            <div class="col-md-12 text-left line history{{$user_treatment->tooth_id}}">
                                @if ($treatment_history->tooth_id == null)
                                <b>Бүх шүд<b>
                                        @else
                                        <b>#{{$treatment_history->tooth_id}} -
                                            {{\App\Treatment::find($treatment_history->treatment_id)->name}}</b>
                                        @endif
                                        <br>
                                        <div class="row">
                                            <div class="text-muted col-md-6">
                                                @if(is_null($treatment_history->treatment_selection_id) ||
                                                $treatment_history->treatment_selection_id == 0)
                                                @else
                                                {{\App\TreatmentSelections::find($treatment_history->treatment_selection_id)->name}}
                                                @endif
                                            </div>
                                            <div class="text-right text-muted col-md-6">
                                                {{date('Y-m-d', strtotime($treatment_history->created_at))}}<br>
                                                {{$treatment_history->price}}₮
                                            </div>
                                        </div>
                            </div>
                        </a>
                        @endforeach
                        <br>
                        <button class="btn btn-primary btn-block" onclick="finishTreatment()">ОРУУЛАХ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function(){

        $('#ex1').zoom({
                    magnify: 2
                });

        document.getElementById('treatmentCategorySelect').value = 1;
        document.getElementById('select-tooth-type').value  = 0;
    });

    function finishDate() {
        $("#treatmentHistoryModal").modal();
    }

    function finishTreatment() {
        document.getElementById('treatmentsFinish').submit();
    }
    var nextModal= ''; 
    var skipNotesBoolean = false;

    var tooths = [];
    var selectedArea = [];
    var toothClassList = ["single", "all", "multiple"];

    var milkyteeth = [];
    var emptyteeth = [];

    var single = document.getElementsByClassName(toothClassList[0]);
    var all = document.getElementsByClassName(toothClassList[1]);
    var mult = document.getElementsByClassName(toothClassList[2]);

    for (i = 0; i < all.length; i++) {
        all[i].style.display = "block";
    }
    for (i = 0; i < single.length; i++) {
        single[i].style.display = "none";
    }
    for (i = 0; i < mult.length; i++) {
        mult[i].style.display = "none";
    }

    var markingTooths = false;
    var save = false;
    var currentToothMark = null;
    function handleSelectToothMark(event, value){
        if (value == ''){
            markingTooths = false;
            return;
        }
        currentToothMark = JSON.parse(value);
        markingTooths = true;
    }

    function toothMarkName(toothMark){
        let name = toothMark.name;
        name = name.substr(0, name.indexOf(' ')).toLowerCase();
        return;
    }

     // ruby = tooth_id
     // existing mark will be overwritten
    function markTooth(ruby){
        // validation
        let userId = $('#userId').val();
        let toothTypeId = currentToothMark.id;
        let toothId = ruby;
        // marked already?
        // if marked, replace that
        if ($(`#${ruby}-toothmark`) != null){
            deleteToothMark(userId, ruby);
        }
        addToothMark(userId, toothId, currentToothMark.id);
    }   

    function deleteToothMark(userId, ruby){
        
        let toothId = ruby;
        $.ajax({
                type: 'DELETE',
                url: `/api/user-tooth/${userId}/delete/${toothId}`,
                data: {
                    '_token': "{{csrf_token()}}",
                    user_id: userId,
                    tooth_code: toothId
                },
                success: function(){$(`#${toothId}-toothmark`).remove()},
                fail: function(){alert('Өмнөх тэмдэглэгээг устгахад алдаа гарлаа')},
            })
    }
    function handleDeleteToothMarks(){
        let userId = $('#userId').val();
        for (let i=0; i<tooths.length; i++){
            let ruby = tooths[i];
            deleteToothMark(userId, ruby);
        }
    }


    function addToothMark(userId, ruby, toothTypeId){
        let toothId = ruby;
        $.ajax({
            type: 'POST',
            url: '/api/user-tooth/create',
            data: {
                '_token': "{{csrf_token()}}",
                user_id: parseInt(userId),
                tooth_code: parseInt(toothId),
                tooth_type_id: parseInt(toothTypeId)
            },
            success: function(response){
                console.log('response');
                console.log(response);
                let name = currentToothMark.name;
                name = name.substr(0, name.indexOf(' ')).toLowerCase();
                $(`#${ruby}`).after(`<div id="${toothId}-toothmark" class="tooth-type">${name}</div>`);
            },
            fail: function(err){
                alert('Тэмдэглэгээ өгхөд алдаа гарлаа');
            }
        });
    }

    function handleSelectTreatmentCategory(e, categoryId = null) {
        e.preventDefault();
        e.stopPropagation();
        console.log('category selected');
        if (categoryId == null)
            alert('category not selected');
        let url = `/api/treatments/category/${categoryId}`;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (treatmentsResponse) {
                setTreatmentsHTML(treatmentsResponse)
            },
            fail: function (err) {
                console.log(err)
            }
        });
    }
    
    //handleSelectTreatmentCategory(new Event('click'), 1);

    function setTreatmentsHTML(treatments) {
        console.log('treatments');
        console.log(treatments);
        let container = document.getElementById('treatmentsContainer');
        let html = '';
        for (let i = 0; i < treatments.length; i++) {
            let treatment = treatments[i];
            if (treatment.id == 1) {

                // treatment should be seen or not
                // when fetched from db first time
                let inlinestyle = 'style="'; // notice " (pair " will be set after these if blocks")
                // single treatment when selected multiple tooths
                if ((treatment.selection_type == 1) && tooths.length == 0){
                    inlinestyle += 'display:none;';
                }
                // treatment for all tooths when selected signle tooth
                else if((treatment.selection_type == 0) && tooths.length == 1){
                    inlinestyle += 'display:none;';
                }
                inlinestyle += '"'; // sets terminating " for inline style
                html += `<button class="btn btn-primary btn-block single" ${inlinestyle}` +
                    `onclick="openNotesModal(event, '#lomboModal', '${treatment.name}')">` +
                    `<div class="row">` +
                    `<div class="col-md-12 text-left" onclick="reset()">` +
                    `${treatment.name} <br>` +
                    `${treatment.treatment_selections.length == 0? '':treatment.treatment_selections.length+' төрөлтэй'}` +
                    `</div>`;

                let inner = '';
                for (let j = 0; j < treatment.treatment_selections.length; j++) {
                    let selection = treatment.treatment_selections[j];
                    inner += `<input type="hidden" ` +
                        `value="${selection.name}/${selection.id}/${selection.price}/${selection.limit}"` +
                        `class="treatment_${treatment.id}">`;
                }
                html += inner + '</div>';
                html += '</button>';
                continue; // end condition treatment.id==1
            }

            // treatment.id != 1

            let cls = null;
            if (treatment.selection_type == 0)
                cls = 'all';
            else if (treatment.selection_type == 1)
                cls = 'single';
            else
                cls = 'multiple';

            let onClickStr = '';
            if (treatment.treatment_selections && (treatment.treatment_selections.length > 0))
                onClickStr = `onclick="treatmentButton('${treatment.id}', '${treatment.name}')"`;
            else
                onClickStr = `onclick="singleTreatment('${treatment.id}',` +
                `'${treatment.price}', '${treatment.limit}', '${treatment.name}')"`;

            // treatment should be seen or not
            // when fetched from db first time
            let inlinestyle = 'style="'; // notice " (pair " will be set after these if blocks")
            // single treatment when selected multiple tooths
            if ((treatment.selection_type == 1) && tooths.length == 0){
                inlinestyle += 'display:none;';
            }
            // treatment for all tooths when selected signle tooth
            else if((treatment.selection_type == 0) && tooths.length == 1){
                inlinestyle += 'display:none;';
            }
            inlinestyle += '"'; // sets terminating " for inline style

            outer = `<button ${onClickStr} class="btn btn-primary btn-block ${cls}" ${inlinestyle}>` +
                `<div class="row">` +
                `<div class="col-md-9 text-left">` +
                `${treatment.name}<br> ${treatment.treatment_selections.length == 0? '':treatment.treatment_selections.length+' төрөлтэй'}` +
                `</div>`;
            let inner = '';
            for (let i = 0; i < treatment.treatment_selections.length; i++) {
                let selection = treatment.treatment_selections[i];
                inner += `<input type="hidden"` +
                    `value="${selection.name}/${selection.id}/${selection.price}/${selection.limit}"` +
                    `class="treatment_${treatment.id}">`;
            }
            outer += inner;
            outer += '</div>';
            outer += '</button>';

            html += outer;
        }
        treatmentsContainer.innerHTML = html;
    }

    function reset() {
        document.getElementById('treatmentSelectionId').value = null;
        document.getElementById('option1').click();

        for (i = 0; i < selectedArea.length; i++) {
            document.getElementById("pol" + selectedArea[i]).setAttribute('class', 'empty');
        }
        // document.getElementById('suunShudToggle').setAttribute('class','')
        var x = document.getElementById('suunShudToggle');
        x.checked = false;
    }

    function changeStyle(ruby) {


        if (markingTooths){
            markTooth(ruby);
            return;
        }

        //----VALIDATION-----
        if (tooths.length === 0) {
            tooths.push(ruby);
        } else {
            var check = true;
            for (var count = 0; count < tooths.length; count++) {
                if (tooths[count] === ruby) {
                    check = false;
                }
            }
            if (check) {
                tooths.push(ruby);
            } else {
                tooths.splice(tooths.indexOf(ruby), 1);
            }
        }

        document.getElementById('buriLombo').innerText = "Шүд #" + tooths[0];
        //----VALIDATION END-----
        if (markingTooths){
            markTooths(null, ruby); // event=null
        }

        //PAINT table using @tooths array
        console.log(tooths);
        for (var j = 1; j <= 4; j++) {
            for (var i = 10 * j + 1; i <= 10 * j + 8; i++) {
                document.getElementById(i).setAttribute("class", "tooth");
            }
            for (var i = 10 * j + 1; i <= 10 * j + 8; i++) {
                for (var count = 0; count < tooths.length; count++) {
                    if (tooths[count] === i) {
                        document.getElementById(i).classList.remove("tooth");
                    }
                }
                if (tooths.length === 0) {
                    document.getElementById(i).classList.remove("tooth");
                }
            }

        }
        for (var z = 0; z < document.getElementsByClassName('line').length; z++) {
            document.getElementsByClassName('line')[z].style.display = 'none';
        }


        if (tooths.length === 0) {
            for (i = 0; i < all.length; i++) {
                all[i].style.display = "block";
            }
            for (i = 0; i < single.length; i++) {
                single[i].style.display = "none";
            }
            for (i = 0; i < mult.length; i++) {
                mult[i].style.display = "none";
            }
            for (var j = 1; j <= 4; j++) {
                for (var i = 10 * j + 1; i <= 10 * j + 8; i++) {
                    document.getElementById(i).classList.remove("tooth");
                }
            }

        } else if (tooths.length === 1) {
            for (i = 0; i < all.length; i++) {
                all[i].style.display = "none";
            }
            for (i = 0; i < single.length; i++) {
                single[i].style.display = "block";
            }
            for (i = 0; i < mult.length; i++) {
                mult[i].style.display = "none";
            }
        } else {
            for (i = 0; i < all.length; i++) {
                all[i].style.display = "single";
            }
            for (i = 0; i < single.length; i++) {
                single[i].style.display = "none";
            }
            for (i = 0; i < mult.length; i++) {
                mult[i].style.display = "block";
            }
        }

        if (tooths.length == 0) {
            for (i = 0; i < document.getElementsByClassName('line').length; i++) {
                document.getElementsByClassName('line')[i].style.display = 'block';
            }
        } else {
            for (i = 0; i < tooths.length; i++) {
                var choosen = document.getElementsByClassName('history' + tooths[i]);
                for (var d = 0; d < choosen.length; d++) {
                    choosen[d].style.display = 'block';
                }
            }
        }
    }


    //LOMBO STARTING


    function sumList(array) {
        var sum = 0;
        for (i = 0; i < array.length; i++) {
            var parse = parseInt(array[i]);
            sum += parse;
        }
        return sum;
    }
    var decayValidation;

    function myFunction(ruby) {
        //            Validation start
        if (selectedArea.length === 0) {
            selectedArea.push(ruby);
        } else {
            var check = true;
            for (var count = 0; count < selectedArea.length; count++) {
                if (selectedArea[count] === ruby) {
                    check = false;
                }
            }
            if (check) {
                selectedArea.push(ruby);
            } else {
                selectedArea.splice(selectedArea.indexOf(ruby), 1);
            }
        }

        //            ----Validation End------
        //              Change Color on click
        if (selectedArea.includes(ruby) === true) {

            document.getElementById("pol" + ruby).setAttribute('class', 'lombo');
        } else if (selectedArea.includes(ruby) === false) {

            document.getElementById("pol" + ruby).setAttribute('class', 'empty');
        }
        //            sumList
        var total = sumList(selectedArea);
        decayValidation = total;

        //            hidden value
        var x = document.getElementById('hiddenDecayChart').value = total;
        console.log(ruby);
        console.log('lombo total', total);
        document.getElementById("toothId").value = tooths;
    }

    function decaySubmit() {

        let tselectionid = document.getElementById('treatmentSelectionId').value;
        console.log("Decay");
        var decayLevel = document.getElementsByName('decayLevel');
        for (var i = 0; i < decayLevel.length; i++) {
            if (decayLevel[i].checked) {
                document.getElementById('treatmentSelectionId').value = i + 1;
            }
        }
        if (document.getElementById('suunShudToggle').checked) {
            document.getElementById('treatmentSelectionId').value = parseInt(document.getElementById(
                'treatmentSelectionId').value) + 4;
        }
        document.getElementById('treatmentId').value = 1;
        document.getElementById('valueId').value = document.getElementById('hiddenDecayChart').value;

        // set decay level
        $('#decayLevel').val($('#radioDecayLevel').val());

        if ($("#treatmentPrice").value == null ||
            ($("#treatmentPrice") == '')) {
            $("#lomboModal").modal('hide');
            treatmentButton(1, 'Ломбо');
            return;
        }

        if (decayValidation > 0) {
            document.getElementById('treatmentForm').submit();
        } else {
            alert("Та ломбоо сонгоно уу.")
        }
        console.log(decayLevel);
    }


    //                                integer to binary
    //Polygon
    function paint(input) {
        var s = '';
        var v = '';
        var d = parseInt(input);
        while (d > 0) {
            s = s + d % 2;
            d = parseInt(d / 2);
        }
        s = s.split("");
        return s;
    }

    for (var p = 1; p <= 4; p++) {
        for (var f = 10 * p + 1; f < 10 * p + 9; f++) {
            var x = document.getElementById('shud' + f).value;
            var list = paint(x);

            for (var i = 0; i < list.length; i++) {
                if (list[i] == 1) {
                    document.getElementById('pol' + f + '_' + i).setAttribute('class', 'lombo');
                } else {
                    document.getElementById('pol' + f + '_' + i).setAttribute('class', 'empty');
                }
            }
        }
    }

    //start
    function treatmentReset() {
        var x = document.getElementsByClassName('delete');
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
    }

    // start
    function treatmentButton(treatment, treatmentName) {
        console.log('treatmentbutton', treatment);
        document.getElementById('treatmentSelectionId').value = null;
        document.getElementById('toothId').value = tooths;
        document.getElementById('treatmentId').value = treatment;
        if (shouldOpenNotesModal()){
            openNotesModal(null, '#treatmentTypeModal', treatmentName);
        }else{
            $('#treatmentTypeModal').modal();
        }
        treatment = parseInt(treatment);
        var n = treatment;
        console.log(treatment);
        treatmentReset();
        treatment = parseInt(treatment);
        var input = document.getElementsByClassName("treatment_" + treatment);

        for (i = 0; i < input.length; i++) {
            var buttonValue = input[i].value;
            var buttonLimit = buttonValue.split('/')[3];
            var buttonLimitMin = buttonValue.split('/')[2];
            var buttonId = buttonValue.split('/')[1];
            var buttonText = buttonValue.split('/')[0];
            var button = '<button type="button" class="delete btn btn-primary btn-block mb-1" onclick="treatment(' +
                buttonId + ', ' + buttonLimitMin + ', ' + buttonLimit + ')">' + buttonText + '</button>';
            document.getElementById('modalBuri').innerHTML += button;
        }
    }

    function treatment(id, price, limit) {
        if (limit === '' || limit === null || limit === undefined) {
            document.getElementById('treatmentSelectionId').value = id;
            document.getElementById('treatmentForm').submit();
        } else {
            document.getElementById('treatmentSelectionIdWithLimit').value = id;
            document.getElementById('treatmentWithLimitPriceMin').value = price;
            document.getElementById('treatmentWithLimitPriceMax').value = limit;
            $("#treatmentTypeModal").modal("hide");
            $("#treatmentWithLimit").modal();
        }
    }

    function singleTreatment(id, price, limit, treatmentName) {
        console.log('singletreatment', treatment);
        document.getElementById('treatmentSelectionId').value = null;
        if (limit === '' || limit === null) {
            document.getElementById('toothId').value = tooths;
            document.getElementById('treatmentId').value = id;
            document.getElementById('treatmentForm').submit();
        } else {
            document.getElementById('singleTreatmentWithLimitId').value = id;
            document.getElementById('singleTreatmentWithLimitPriceMin').value = price;
            document.getElementById('singleTreatmentWithLimitPriceMax').value = limit;
            $("#treatmentTypeModal").modal("hide");
            if (shouldOpenNotesModal()){
                openNotesModal(null, '#singleTreatmentWithLimit', treatmentName);
                return;
            }
            $("#singleTreatmentWithLimit").modal();
        }
    }

    function treatmentSelectionWithLimit() {    
        let price = parseInt(document.getElementById('treatmentWithLimitPrice').value);
        var minPrice = parseInt(document.getElementById('treatmentWithLimitPriceMin').value);
        let maxPrice = parseInt(document.getElementById('treatmentWithLimitPriceMax').value);
        $('#treatmentDescription').val($('#selectionTreatmentDescription').val());
        console.log('price ', price);
        console.log('min;max -> ', minPrice, maxPrice);
        if ((price < minPrice) || (price > maxPrice)) {
            alert(`Үнийн дүн буруу байна! Үнийн дүн ${minPrice}₮-${maxPrice}₮ хооронд байх ёстой`);
        } else {
            document.getElementById('treatmentPrice').value = document.getElementById('treatmentWithLimitPrice').value;
            document.getElementById('treatmentSelectionId').value = document.getElementById(
                'treatmentSelectionIdWithLimit').value;
            document.getElementById('treatmentForm').submit();
        }
    }

    function singleTreatmentWithLimit() {
        let price = parseInt(document.getElementById('singleTreatmentWithLimitPrice').value);
        var minPrice = parseInt(document.getElementById('singleTreatmentWithLimitPriceMin').value);
        var maxPrice = parseInt(document.getElementById('singleTreatmentWithLimitPriceMax').value);
        if ((price < minPrice) || (price > maxPrice)) {
            alert(`Үнийн дүн буруу байна! Үнийн дүн ${minPrice}₮-${maxPrice}₮ хооронд байх ёстой`);
        } else {
            document.getElementById('treatmentPrice').value = document.getElementById('singleTreatmentWithLimitPrice')
                .value;
            document.getElementById('treatmentId').value = document.getElementById('singleTreatmentWithLimitId').value;
            document.getElementById('toothId').value = tooths;
            document.getElementById('treatmentForm').submit();
        }
    }

    function toggleMilkTeeth(){
        let input = $('#toothTypeId');
        // set non-milk
        if (input.val() == {{App\ToothType::milk()->id}}){
            input.val(null);
            return;
        }
        // set milk
        input.val({{App\ToothType::milk()->id}});
    }

    function skipNotes(){
        skipNotesBoolean = true;
        clearNotes();
        $(nextModal).modal();
    }
    function clearNotes(){
        $('#input-symptom').val('');
        $('#input-diagnose').val('');
    }
    clearNotes();

    function saveNotes(){
        $('#formInputSymptom').val($('#input-symptom').val());
        $('#formInputDiagnosis').val($('#input-diagnose').val());
        $(nextModal).modal();
    }
    function openNotesModal(event, nextModalSelector, treatmentName){
        nextModal = nextModalSelector;
        let tooth = tooths[0];
        let title = `Шүд #${tooth==undefined?'бүгд':tooth} - ${treatmentName}`;
        console.log('title');
        $('#notes-title').html(title);
        $('.notes-modal').modal();
    }

    function shouldOpenNotesModal(){
        if (($('#input-symptom').val().length == 0) &&
            $('#input-diagnose').val().length == 0){
            return true;
        }
        return false;
    }
    function openLomboNoteModal(title,symptom, diagnosis, decayLevel, toothType){
        console.log('title', title);
        $('#lombo-note-title').html(title);
        $('#lombo-note-symptom').html(symptom);
        $('#lombo-note-diagnosis').html(diagnosis);
        $('#lomboNoteModal').modal();
    }

    function treatmentNoteModal(){

    }
    // end
</script>
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
{{--Scriptuudiig include hiiideg heseg--}}
@endsection