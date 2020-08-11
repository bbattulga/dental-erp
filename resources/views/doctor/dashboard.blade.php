@extends('layouts.doctor')
@section('header')



    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}"/>

@endsection
@section('content')
    <script>
        document.getElementById('doctorDashboard').classList.add('active');
    </script>

    <div class="row">
        <div class="col-md-3">
            <div class="card ">
                <div class="card-body">
                    <div class="text-center">
                        @if($user->profile_pic == '')
                            Зураггүй
                        @else
                            <img width="200px" style="border-radius: 100%"
                                 src="/img/staffs/{{$user->profile_pic}}">
                        @endif
                        <br>
                        <br>
                        <p class="list-item-heading mb-1">
                        <h3>{{$user->name}} {{$user->last_name}}</h3></p>
                        <div class="text-center">
                            <p class="text-muted text-small mb-2">Утасны дугаар</p>
                            <p class="mb-3">
                                {{$user->phone_number}}
                            </p>
                            <p class="text-muted text-small mb-2">Цахим хаяг</p>
                            <p class="mb-3">
                                {{$user->email}}
                            </p>
                            <p class="text-muted text-small mb-2">Мэргэжил</p>
                            <p class="mb-3">
                                {{$user->role->name}}
                            </p>
                            <p class="text-muted text-small mb-2">Тайлбар</p>
                            <p class="mb-3">
                                {{$user->description}}
                            </p>
                            @if($user->role == null)
                                Халагдсан
                            @else

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">

                    <form method="post" action="{{url('/doctor/dashboard/date')}}">
                        @csrf

                        <div class="input-daterange input-group mb-3" id="datepicker" data-date-format="yyyy-mm-dd">
                            <a href="#" onclick="$(this).closest('form').submit()" style="color: #8f8f8f">Хугацаа
                                өөрчлөн харах</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="date-start" name="start_date" class="form-control datepicker"
                                    data-date-format="yyyy-mm-dd"
                                   style="background-color: #f8f8f8; border-color: #f8f8f8; border-bottom-color: #8f8f8f; color: #8f8f8f; padding: 0px"
                                   placeholder="Эхлэл"
                                   value="{{ $start_date }}">
                                   &nbsp;&nbsp;&nbsp;<span
                                    style="color: #8f8f8f">-&nbsp;&nbsp;&nbsp;</span>
                            <input id="date-end" name="end_date" class="form-control datepicker"
                                    data-date-format="yyyy-mm-dd"
                                   style="background-color: #f8f8f8; border-color: #f8f8f8; border-bottom-color: #8f8f8f; color: #8f8f8f; padding: 0px"
                                   placeholder="Төгсгөл"
                                   value="{{ $end_date }}">
                                   &nbsp;&nbsp;&nbsp;
                            <a id="show-datebetween" href="#" onclick="$(this).closest('form').submit()" style="color: #8f8f8f">үзэх</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="text-right" style="color: #8f8f8f">
                        <form id="monthSearch" action="{{url('/doctor/dashboard/by_month')}}" method="post">
                            @csrf
                            Хугацаа өөрчлөн үзэх:
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
                        <br>
                    </div>
                </div>
            </div>


            <div class="row">
                <div id="scrollDiv" class="col-md-5" style=" height: 96vh; position:relative; width:400px;overflow:auto;">
                    <?php $sum=0;?>
                    <?php $users=0;?>
                    @foreach($shifts as $shift)
                        @foreach($shift->checkins->where('state','>=', 3) as $check_in)
                            <?php $users++;?>
                            <div class="col-md-12">
                                <div class="card"> 
                                    <div style="background-color: white; color: black; 
                                        display: inline-block; font-size: 2.3em;
                                        position: absolute; top: 0; right: 0; cursor: pointer; margin:2px;">
                                        <div class="glyph"  onclick="showTreatmentDetails({{$check_in}})">
                                            <div class="glyph-icon simple-icon-notebook"></div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="#">
                                                <div class="d-flex flex-row mb-3 pb-3 border-bottom">

                                                    <div class="pl-3 pr-2">
                                                        {{--<a href="#">--}}
                                                        <p class="font-weight-medium mb-0 ">{{$check_in->user->name}}</p>
                                                        <p class=" text-muted mb-0 text-small"> {{$check_in->shift->date}} өдөр хийгдсэн эмчилгээ</p>
                                                        {{--</a>--}}
                                                    </div>
                                                </div>
                                            </a>
                                        </h5>
                                        <table class="table table-sm table-borderless">
                                            <?php
                                            $treatments = \App\UserTreatments::all()->where('checkin_id',$check_in->id)
                                            ?>
                                            <?php $total = 0;
                                            ?>

                                            <tbody>
                                            @foreach($treatments as $treatment)
                                                <tr>
                                                    <td>
                                                        <span class="log-indicator border-theme-2 align-middle"></span>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-medium"
                                data-whatever="@mdo" style="cursor: pointer;">{{$treatment->treatment->name}}</span>
                                                    </td>
                                                    <td class="text-right">
                                                            <span class="text-muted"> {{$treatment->price}}₮
                                                                 <?php /** @var TYPE_NAME $total */
                                                                $total = $total + $treatment->price?>
                                                            </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        @if(!empty($check_in->user_promotion))
                                            <?php $promotion = $check_in->user_promotion->promotion;?>
                                            <span class="badge badge-pill badge-secondary">Хямдарсан {{$promotion->percentage}}% {{$promotion->promotion_name}} </span>
                                            <br>
                                            <span class="badge badge-pill badge-primary">Нийт зарцуулсан {{$total = $total*((100-$promotion->percentage)/100)}}₮</span>
                                        @else
                                            <span class="badge badge-pill badge-primary">Нийт зарцуулсан {{$total}}₮</span>
                                        @endif
                                        <?php $sum = $sum + $total ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @endforeach
                </div>
                <div class="col-md-7" id="scrollDiv">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>
                                        <b>{{intval($sum)}}₮</b>
                                    </h4>
                                    <h5>орлого</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>
                                        <b>{{$users}} хүн</b>
                                    </h4>
                                    <h5>үйлчлүүлсэн</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <h6>Бүтэн - {{$count_full ?? ''}}  &nbsp; &nbsp;Хагас - {{$count_half ?? ''}}</h6>
                                        <thead>
                                        <tr>
                                            <th>Өдөр</th>
                                            <th>Ээлж</th>
                                            <th>Үүсгэсэн</th>
                                            <th>Үүсгэсэн хугацаа</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($shifts as $shift)
                                            <tr>
                                                <td>{{$shift->date}}</td>
                                                <td>
                                                    @if($shift->shift_type_id == 1)
                                                        Өглөөний ээлж
                                                    @elseif($shift->shift_type_id == 2)
                                                        Оройн ээлж
                                                    @else
                                                        Бүтэн ээлж
                                                    @endif
                                                </td>
                                                <td>{{$shift->createdby->name}}</td>
                                                <td>{{$shift->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        
                                        
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



    </div>

<!-- show summaries -->
<div class="modal fade" id="treatmentNotesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patient-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1rem 0;">
                <table class="table table-bordered">
                    <thead style="background-color: #2a7eeb; color: white; position: sticky; top:0;">
                        <tr>
                            <td>Шүд</td>
                            <td>Шинж тэмдэг</td>
                            <td>Онош</td>
                            <td>Эмчилгээ</td>
                        </tr>
                    </thead>
                    <tbody id="treatment-rows-container">

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

    </div><!-- row -->
@endsection
@section('footer')


    <script src="{{asset('js/vendor/perfect-scrollbar.min.js')}}"></script>

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
        const scrolldiv = document.querySelector('#scrollDiv');
        const ps = new PerfectScrollbar(scrolldiv);

        // Handle size change
        if (document.querySelector('#resize')){
            document.querySelector('#resize').addEventListener('click', () => {

        // Get updated values
        if (document.querySelector('#width') && document.querySelector('#height')){
            width = document.querySelector('#width').value;
            height = document.querySelector('#height').value;
        
        // Set demo sizes
        demo.style.width = `${width}px`;
        demo.style.height = `${height}px`;
        
        // Update Perfect Scrollbar
        ps.update();
        }
        });
        }   
        

        function tdBlock(data){
            return `<td><div>${data}</div></td>`;
        }

        var treatmentRowsContainer = document.getElementById('treatment-rows-container');
        function showTreatmentDetails(checkin){
            console.log('show details');
            console.log(checkin);
            let treatments = checkin.treatments;
            let user = checkin.user;
            console.log(treatments);
            let title = `Үйлчлүүлэгч - ${user.last_name[0]}. ${user.name}`;
            let subtitle = `Утас - ${checkin.user.phone_number}`;
            title += `<br>${subtitle}`;
            $('#patient-title').html(title);

            let treatmentRows = '';
            for (let i=0; i<treatments.length; i++){
                let treatment = treatments[i];
                let tds = `<tr><td>#${treatment.tooth_id}</td>` +
                            `<td>${treatment.treatment_note.symptom}</td>` +
                            `<td>${treatment.treatment_note.diagnosis}</td>` +
                            `<td>${treatment.treatment.name}</td></tr>`;
                treatmentRows += `${tds}`;
            };
            treatmentRowsContainer.innerHTML = treatmentRows;
            $('#treatmentNotesModal').modal();
        }
    </script>

@endsection