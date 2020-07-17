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

    <style>
        .dnone{
            display: none;
        }
    </style>
    {{--End css style gh met link file oruulna--}}
@endsection
@section('content')
    {{--//Za aliv l dee--}}
    <script>
        document.getElementById('receptionPayment').classList.add('active');
    </script>
    <div class="row">

@foreach($treatment_done_users as $treatment_done_user)
        <div class="col-md-4"><!--profile heseg-->


            <div class="card "><!--row -->
                <div class="card-body">
                    <a href="#">
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">

                            <div class="pl-3 pr-2">
                                <a href="{{url('/reception/user_check/'.$treatment_done_user->shift->doctor->id)}}">
                                    <p class="font-weight-medium mb-0 ">Эмч {{$treatment_done_user->shift->doctor->name}}</p>
                                    <p class="text-muted mb-0 text-small">{{$treatment_done_user->shift->date}} өдөр хийгдсэн эмчилгээ</p>
                                </a>
                            </div>
                        </div>

                    </a>


                    <h5 class="card-title">Өвчтөний мэдээлэл</h5>
                    <div class="d-flex flex-row">
                        <div class="w-50">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a><b>Овог</b> </a>
                                </li>
                                <li class="mb-1">
                                    <a><b>Нэр</b> </a>
                                </li>
                                <li class="mb-1">
                                    <a><b>Хүйс</b> </a>
                                </li>
                                <li class="mb-1">
                                    <a><b>Утасны дугаар</b> </a>
                                </li>
                                <li class="mb-1">
                                    <a><b>Цахим хаяг</b> </a>
                                </li>
                                <li class="mb-1">
                                    <a><b>Регистер</b> </a>
                                </li>
                                <li class="mb-1">
                                    <a><b>Төрсөн он сар өдөр</b> </a>
                                </li>

                            </ul>
                        </div>

                        <div class="w-50">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a>{{$treatment_done_user->user->last_name}}</a>
                                </li>
                                <li class="mb-1">
                                    <a>{{$treatment_done_user->user->name}}</a>
                                </li>
                                <li class="mb-1">
                                    @if($treatment_done_user->user->sex == 0)
                                    <a>Эр</a>
                                        @else
                                        <a>Эм</a>
                                @endif
                                </li>
                                <li class="mb-1">
                                    <a>{{$treatment_done_user->user->phone_number}}</a>
                                </li>
                                <li class="mb-1">
                                    <a>{{$treatment_done_user->user->email}}</a>
                                </li>
                                <li class="mb-1">
                                    <a>{{$treatment_done_user->user->register}}</a>
                                </li>
                                <li class="mb-1">
                                    <a>{{$treatment_done_user->user->birth_date}}</a>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <br>
                    <table class="table table-sm table-borderless">
                        <?php
                        $treatments = \App\UserTreatments::all()->where('checkin_id',$treatment_done_user->id)
                        ?>
                        <?php $total = 0?>
                        <tbody>
                        @foreach( $treatments as $treatment)
                        <tr>
                            <td>
                                <span class="log-indicator border-theme-2 align-middle"></span>
                            </td>
                            <td>
                                <span class="font-weight-medium">{{$treatment->treatment->name}}</span>
                            </td>
                            <td class="text-right">
                                 <span class="text-muted">
                               {{$treatment->price}}₮
                                         <?php /** @var TYPE_NAME $total */
                                         $total = $total + $treatment->price?>
                                </span>
                            </td>

                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <span id="total-price" class="badge badge-pill badge-primary" style="font-size: 20px">Нийт төлбөр {{$total}}₮</span>
                    <br>
                    <br>
                    {{--<div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
                        <form class="form-inline" action="{{url('/reception/payment/store')}}" method="post">
                            @csrf
                            <label class="sr-only" for="inlineFormInputName2">Name</label>
                            <input name="promotion_code" type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2"
                                   placeholder="Урамшуулалын код">

                            <button id="btn-promotion"
                                class="btn" onclick="checkPromotion(event, {{$loop->index}})">Шалгах</button>
                            <div style="margin-bottom: 5px"></div>
                            <input name="lease" type="number" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2"
                                   placeholder="Зээлийн урьдчилгаа">
                            <input type="hidden" value="{{$treatment_done_user->id}}" name="checkin_id">
                            <input type="submit" class="btn btn-sm btn-outline-primary mb-2" style="border-radius: 0px" value="Төлбөр төлөх">
                        </form>
                    {{--</div>--}}
                </div>
            </div>
        </div>

        <input class="dnone" id="total{{$loop->index}}" value="{{$total}}">

    @endforeach


        <div class="col-md-4"><!--profile heseg-->


            <div class="card "><!--row -->
                <div class="card-body">
                    <div>default</div>
                </div>
            </div>
        </div>

    </div><!--end row-->

@endsection
@section('footer')
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">

        let datas = [];
        let d = null;

        let currentIndex = -1;
        let btnPromotion = document.getElementById('btn-promotion');
        let inputPromotion = document.getElementById('inlineFormInputName2');

        function checkPromotion(event, index){
            event.preventDefault();
            event.stopPropagation();
            currentIndex = index;
            
            axios.get(`/api/promotions/code/${inputPromotion.value}`)
                .then(response=>{
                    console.log('response promotion');
                    console.log(response.data);
                    if (response.data.length == 0){
                        alert('Урамшууллын код хүчингүй байна');
                        return 0;
                    }
                    showPromotion(response.data[0]);
                    btnPromotion.innerText = 'Ашиглах';
                })
                .catch(err=>console.log(err));
        }

        function showPromotion(promotion){
            let target = document.getElementById(`total${currentIndex}`);
            let total = parseInt(target.value);
            console.log(`total = ${total}`);
            console.log(total-total*promotion.percentage/100);
            inputPromotion.value = `код ашиглан төлөх: ${total-total*promotion.percentage/100}`;
        }
    </script>

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
