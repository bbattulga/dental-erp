@extends('layouts.reception')
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

    <div id="timetable"></div>
    <div id="timetable-calendar"></div>
    <!--
    <div class="row">
        {{--<div class="col-md-12">--}}
        <div class="card">
            <div class="card-body">
                @if(!empty($user))<h4>{{$user->name}} </h4>{{$user->register}}@endif
                <div class="row mb-4">
                    <div class="col-md-3">
                        <select class="form-control" onchange="location = this.value;">
                            <option>Өдрөөр</option>
                            <option value="@if(\App\UserRole::where('role_id', 2)->first() != null) 
                            @if(!empty($user))
                            {{url('reception/time/week/'. \App\UserRole::where('role_id', 2)->first()->id .'/'. $user->id)}}
                            @else
                            {{url('reception/time/week/'. \App\UserRole::where('role_id', 2)->first()->id)}}
                            @endif
                            @endif">
                                30 хоногоор
                            </option>

                        </select>
                    </div>
                    <div class="col-md-5">
                        {{--<form id="form11" method="post" action="{{url('/admin/transaction/date')}}">--}}
                            {{--@csrf--}}
                            {{--<div class="input-group">--}}
                                {{--<input id="date" name="start_date" autocomplete="off" class="form-control datepicker"--}}
                                       {{--placeholder="mm/dd/YYYY" value="">--}}
                                {{--<button class="btn btn-primary" style="border-radius: 0px">ҮЗЭХ</button>--}}

                            {{--</div>--}}
                        {{--</form>--}}
                    </div>
                </div>


                <table class="table table-responsive text-center table-bordered">
                    <tr>
                        <th></th>
                        <?php $s = 0?>
                        @foreach($shifts as $shift)
                            <th><img style="border-radius: 100%" src="{{asset('img/profile5.jpg')}}"
                                     width="25px"> {{$shift->doctor->name}}</th>
                            <?php $s++?>
                        @endforeach
                    </tr>
                    @for($i = 0; $i<6; $i++)
                        <tr>
                            <td height="90px">{{9+$i}}:00</td>
                            @foreach($shifts as $shift)

                                @if($shift->shift_type_id == 1 || $shift->shift_type_id ==3)
                                    @if($appointment = $shift->appointments->where('start', 9+$i)->first())
                                        <td height="90px" rowspan="{{$appointment->end - $appointment->start}}">
                                            <button class="btn  @if(\App\CheckIn::where('shift_id', $shift->id)->where('user_id', $appointment->user_id)->first())
                                                    btn-success
                                                    @else
                                                    btn-primary
                                                    @endif
                                                    btn-block text-left"
                                                    onclick="deleteAppointment('{{$appointment->name}}', '{{$appointment->phone}}', '{{$appointment->shift->date}}',
                                                            '{{$appointment->start}}:00 - {{$appointment->end}}:00', '{{$appointment->id}}', '{{$shift->doctor->name}}'
                                                            , @if(\App\CheckIn::where('shift_id', $shift->id)->where('user_id', $appointment->user_id)->first()) 'a'
                                                    @elseif($customer = \App\User::find($appointment->user_id))
                                                            '{{$customer->id}}' @else '0' @endif )"
                                                    style="border-radius: 20px; height: 100%;">
                                                {{$appointment->name}}<br><span>{{$appointment->phone}}</span></button>
                                        </td>
                                    @elseif($appointment = $shift->appointments->where('start','<', 9+$i)->where('end', '>', 9+$i)->first())
                                    @else
                                        <td height="90px" rowspan="1">
                                            <button onclick="bookTime('{{9+$i}}', '{{$shift->id}}', '{{$shift->doctor->name}}')"
                                                    class="btn btn-primary btn-block text-left hidden"
                                                    style="border-radius: 20px; height: 100%;">Захиалга
                                                нэмэх<br><span>бол дарна уу</span></button>
                                        </td>
                                    @endif
                                @else
                                    <td height="90px" style="background-color: #bcbcbc"></td>
                                @endif
                            @endforeach
                        </tr>
                    @endfor
                    @for($i = 6; $i<12; $i++)
                        <tr>
                            <td height="90px">{{9+$i}}:00</td>
                            @foreach($shifts as $shift)
                                @if($shift->shift_type_id == 2 || $shift->shift_type_id ==3)
                                    @if($appointment = $shift->appointments->where('start', 9+$i)->first())
                                        <td height="90px" rowspan="{{$appointment->end - $appointment->start}}">
                                            <button class="btn  @if(\App\CheckIn::where('shift_id', $shift->id)->where('user_id', $appointment->user_id)->first())
                                                    btn-success
                                                    @else
                                                    btn-primary
                                                    @endif
                                                    btn-block text-left"
                                                    onclick="deleteAppointment('{{$appointment->name}}', '{{$appointment->phone}}', '{{$appointment->shift->date}}',
                                                            '{{$appointment->start}}:00 - {{$appointment->end}}:00', '{{$appointment->id}}', '{{$shift->doctor->name}}'
                                                            , @if(\App\CheckIn::where('shift_id', $shift->id)->where('user_id', $appointment->user_id)->first()) 'a'
                                                    @elseif($customer = \App\User::find($appointment->user_id))
                                                            '{{$customer->id}}' @else '0' @endif )"
                                                    style="border-radius: 20px; height: 100%;">
                                                {{$appointment->name}}<br><span>{{$appointment->phone}}</span></button>
                                        </td>
                                    @elseif($appointment = $shift->appointments->where('start','<', 9+$i)->where('end', '>', 9+$i)->first())
                                    @else
                                        <td height="90px" rowspan="1">
                                            <button onclick="bookTime('{{9+$i}}', '{{$shift->id}}', '{{$shift->doctor->name}}')"
                                                    class="btn btn-primary btn-block text-left hidden"
                                                    style="border-radius: 20px; height: 100%;">Захиалга
                                                нэмэх<br><span>бол дарна уу</span></button>
                                        </td>
                                    @endif
                                @else
                                    <td height="90px" style="background-color: #bcbcbc"></td>
                                @endif
                            @endforeach
                        </tr>
                    @endfor

                </table>
            </div>
            {{--</div>--}}
        </div>

    </div> -->

@endsection
@section('footer')

    <script>
        var mTime;
        var mShift;

        function bookTime(time, shift_id, doctor_name) {
            mTime = time;
            mShift = shift_id;
            document.getElementById("timeShow").innerHTML = time;
            document.getElementById("timeInput").value = time;
            document.getElementById("nameShow").innerHTML = doctor_name;
            document.getElementById('shiftInput').value = shift_id;
            $("#exampleModalRight").modal();
        }

        function deleteAppointment(name, phone, date, time, appointment_id, doctor_name, registered) {
            document.getElementById("da_user_name").innerHTML = name;
            document.getElementById("da_user_phone").innerHTML = phone;
            document.getElementById("da_date").innerHTML = date;
            document.getElementById("da_time").innerHTML = time;
            document.getElementById("da_id").value = appointment_id;
            document.getElementById("da_doctor_name").innerHTML = doctor_name;
            // registered = parseInt(registered);
            if (registered === 'a') {
                document.getElementById("variableButton").innerText = "Эмчилгээнд орсон";
                document.getElementById("variableButton").classList.add('disabled');
            } else if (registered === '0') {
                document.getElementById("variableButton").innerText = "Бүртгэх&Оруулах";
                document.getElementById("variableLink").setAttribute('href', "{{url('/reception/user/register')}}" + "/" + name + "/" + phone + "/" + appointment_id);
            } else {
                document.getElementById("variableButton").innerText = "Эмчилгээнд оруулах";
                document.getElementById("variableLink").setAttribute('href', "{{url('/reception/user_check')}}" + "/" + registered + "/" + appointment_id + "/check_in");
            }
            document.getElementById("da_user_link").setAttribute('href', "https://www.google.com" + "/" + "1");
            $("#deleteAppointment").modal();
        }


        function validation(shift_id) {

            // Backend bolon Frontend hosluultiin gaihamshig
                    @foreach($shifts as $shift)
                        var shift{{$shift->id}} = @if($shift->shift_id == 0) [1, 2, 3, 4, 5, 6, 7, 8, 15, 16, 17, 18, 19, 20, 21, 22, 23] @elseif($shift->shift_id == 0) [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 21, 22, 23] @else [1, 2, 3, 4, 5, 6, 7, 8, 21, 22, 23] @endif ;
                        @foreach ($shift->appointments as $appointment)
                            @for ($i = $appointment->start; $i< $appointment->end; $i++)
                                shift{{$shift->id}}.push({{$i}});
                            @endfor
                        @endforeach
                        console.log(shift{{$shift->id}});
                    @endforeach
                    var shiftName = "shift" + shift_id;
                    var check = [];
                    var q = [];
                    var d = document.getElementById("ner").value;
                    var ut = document.getElementById("utas").value;
                    var tsag = document.getElementById("hugatsaa").value;
                    console.log(tsag)
                    for (i = 0; i <= tsag-1; i++) {
                        var int = parseInt(mTime);
                        check.push(int + i);
                        q.push(eval(shiftName).includes(check[i]));
                    }
                    console.log(q);
                    if (d === "") {
                        document.getElementById('ner').classList.add('border-danger');
                    } else if (ut.length !== 8) {
                        document.getElementById('utas').classList.add('border-danger');
                    } else if (tsag < 1 || tsag === "" || q.includes(true) === true) {
                        document.getElementById("hugatsaa").classList.add('border-danger');
                    } else {
                        document.getElementById("form111").submit();
                        // console.log(tsag.value)

                    }

                }
    </script>

    <script src="{{asset('js/apps/timetable/public/build/bundle.js')}}"></script>
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
    <script>
        function gh() {
            var pass = document.getElementById("ps").value;
            var des = document.getElementById("ds").value;
            if(pass === ""){
                document.getElementById('ps').classList.add('border-danger');
            }
            else if(des === "") {
                document.getElementById('ds').classList.add('border-danger');
                document.getElementById('ps').classList.remove('border-danger');
            }
            else {
                document.getElementById("form11").submit();
            }
        }
    </script>
    {{--Scriptuudiig include hiiideg heseg--}}
@endsection