@extends('layouts.reception')
@section('header')
    {{--End css style gh met link file oruulna--}}
    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}"/>
    <style>
        .hidden {
            border-radius: 10px;
            opacity: 0;
            background-color: white;
            border: 0px;
        }

        .hidden:hover, .hidden:focus {
            opacity: 1;
        }

    </style>
@endsection
@section('content')
    <script>
        document.getElementById('receptionShifts').classList.add('active');
    </script>
    <div class="modal fade" id="deleteShiftModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('/reception/shifts/cancel')}}" >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Ээлж цуцлах
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            {{--sdfdsafsa--}}
                        </button>
                    </div>
                    <div class="modal-body">
                        Эмч: <span id="doctorName"></span><br>
                        Өдөр: <span id="shiftDate"></span><br>
                        Ээлж: <span id="shiftTime"></span><br>
                        <input type="hidden" name="shift_id" id="shiftId">
                    </div>
                    <div class="modal-footer">
                        <input type="text" name="description" required class="form-control" id="shiftId" placeholder="Тайлбар">
                        <button type="submit" class="btn btn-primary" style="border-radius: 0px">Ээлж цуцлах</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive text-center">
                        @foreach($doctors as $doctor)
                            <tr>
                                <td>Эмч</td>
                                @for($i=0; $i<30; $i++)
                                <td>{{date('Y-m-d', strtotime("+".$i." Days"))}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <th rowspan="2"><br><br><br>
                                    {{$doctor->name}}</th>
                                @for($i = 0; $i < 30; $i++)
                                    <?php $time = $shifts->where('date', date('Y-m-d', strtotime('+' . $i . ' Days')))->where('user_id', $doctor->id)->where('shift_type_id', 1)->first(); ?>
                                    @if($time)
                                        <td>
                                            <button class="btn btn-primary" style="border-radius: 10px" onclick="deleteShift('{{$time->id}}', '{{$doctor->name}}', 'Өдрийн ээлж', '{{$time->date}}')">Өглөөний ээлж<br><span class="text-right"
                                                                                                                                                                                                                                    style="font-size: 10px">{{$time->appointments->count()}} хүн захиалсан</span>
                                            </button>
                                        </td>

                                    @elseif($time = $shifts->where('date', date('Y-m-d', strtotime('+' . $i . ' Days')))->where('user_id', $doctor->id)->where('shift_type_id', 3)->first())
                                        <td rowspan="2">
                                            <button class="btn btn-primary" style="height: 140px; border-radius: 10px" onclick="deleteShift('{{$time->id}}', '{{$doctor->name}}', 'Бүтэн ээлж', '{{$time->date}}')">Бүтэн ээлж<br><span class="text-right"
                                                                                                                                                                                                                                               style="font-size: 10px">{{$time->appointments->count()}} хүн захиалсан</span>
                                            </button>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{url('/reception/shifts/'.$i.'/'.$doctor->id.'/1')}}">
                                                <button class="btn btn-light hidden">Тавигдаагүй<br><span class="text-right"
                                                                                                          style="font-size: 10px">ээлж тавих</span>
                                                </button>
                                            </a>
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                @for($i = 0; $i < 30; $i++)
                                    <?php $time = $shifts->where('date', date('Y-m-d', strtotime('+' . $i . ' Days')))->where('user_id', $doctor->id)->where('shift_type_id', 2)->first(); ?>
                                    @if($time)
                                        <td>
                                            <button class="btn btn-primary" style="border-radius: 10px" onclick="deleteShift('{{$time->id}}' ,'{{$doctor->name}}', 'Оройн ээлж', '{{$time->date}}')">Оройний ээлж<br><span class="text-right"
                                                                                                                                                                                                                                  style="font-size: 10px">{{$time->appointments->count()}} хүн захиалсан</span>
                                            </button>
                                        </td>
                                    @elseif( $time = $shifts->where('date', date('Y-m-d', strtotime('+' . $i . ' Days')))->where('user_id', $doctor->id)->where('shift_type_id', 3)->first())

                                    @else
                                        <td>
                                            <a href="{{url('/reception/shifts/'.$i.'/'.$doctor->id.'/2')}}">
                                                <button class="btn btn-light hidden">Тавигдаагүй<br><span class="text-right"
                                                                                                          style="font-size: 10px">ээлж тавих</span>
                                                </button>
                                            </a>
                                        </td>
                                    @endif
                                @endfor

                            </tr>

                        @endforeach


                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        function deleteShift(id, doctor_name, shift_time, shift_date) {
            document.getElementById('shiftId').value = id;
            document.getElementById('doctorName').innerHTML = doctor_name;
            document.getElementById('shiftTime').innerHTML = shift_time;
            document.getElementById('shiftDate').innerHTML = shift_date;
            $("#deleteShiftModal").modal();
        }
    </script>
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
    {{--Scriptuudiig include hiiideg heseg--}}
@endsection