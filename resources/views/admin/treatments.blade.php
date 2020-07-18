@extends('layouts.admin')
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
        .hidden {
            opacity: 0;
            background-color: white;
            border: 0px;
        }

        .hidden:hover, .hidden:focus {
            opacity: 0.2;
            background-color: #8f8f8f;
        }
        .btn-newuser{
            z-index: 10000;
            position: fixed;
            right: 10px;
            bottom: 10px;
            margin: 10px;
        }

        .row-crud-user{
            min-width: 96px;
            display: flex;
            flex-direction: row;
            align-content: space-around;
            justify-content: center;
        }

        .crud-ic{
            flex-direction: column;
            justify-content: center;

            max-width: 30px;
            max-height: 30px;
            margin: 0 5px;

            cursor: pointer;
            transition: 0.4s;
            display: flex;
        }

        .crud-ic:hover{
            max-width: 36px;
            max-height: 36px;
        }

        .crud-ic > img{
            max-width: 100%;
            height: auto;
        }

        .tooltip-my{
            display: inline-block;
        }

        .tooltiptext{
            visibility: hidden;
            font-size: 10px;
            width: 200px;
            background-color: #333333;
            color: #e7e7e7e7;
        }

        .tooltip-my:hover .tooltiptext{
            visibility: visible;
        }
    </style>
    {{--End css style gh met link file oruulna--}}
@endsection
@section('content')
    <script>
        document.getElementById('adminTreatments').classList.add('active');
    </script>
   <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Нэр</th>
                            <th>Хийгдэх хэлбэр</th>
                            <th>Төрөл</th>
                            <th>Үнэ</th>
                            <th>Үнийн хязгаар</th>
                            <th>Сонголтын тоо</th>
                            <th></th>
                        </thead>
                        <tbody>
                        @foreach($treatments as $treatment)
                            <tr>
                                <td>{{$treatment->id}}</td>
                                <td><a href="{{url('admin/treatment/'.$treatment->id)}}">{{$treatment->name}}</a></td>
                                <td>@if($treatment->selection_type == 1) Нэг шүд @else Бүх шүд @endif</td>
                                <td>@if($treatment->category == 0) Эмчилгээ @elseif($treatment->category == 1) Гажиг засал @elseif($treatment->category == 2) Согог засал @else Мэс засал @endif</td>
                                <td>@if(empty($treatment->price)) Хоосон @else {{$treatment->price}}₮ @endif</td>
                                <td>@if(empty($treatment->limit)) Хоосон @else {{$treatment->limit}}₮ @endif</td>
                                <td>{{$treatment->treatment_selections->count()}}</td>
                                <td>
                                <div class="row-crud-user">
                                  
                                    <div class="crud-ic tooltip-my">
                                        <img src="http://127.0.0.1:8000/img/icon/pen.png">
                                        <div class="tooltiptext">
                                             Засах
                                        </div>
                                    </div>
                                    <div onclick="deleteUser(416)" class="crud-ic tooltip-my">
                                        <img src="http://127.0.0.1:8000/img/icon/trashbin.png">
                                        <div class="tooltiptext">
                                            Хаяг устгах
                                        </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card m-1">
                <div  class="card-body">
                    <h5>Шинэ эмчилгээ оруулах</h5>
                    <form method="post" action="{{url('admin/treatment/store')}}"
                            enctype="multipart/form-data">
                        @csrf
                        Нэр:
                        <input class="form-control" type="text" name="name" required>
                        <br>
                        Хийгдэх хэлбэр:
                        <select class="form-control" name="selection_type">
                            <option value="0">Бүх шүд</option>
                            <option value="1">Нэг шүд</option>
                        </select>
                        <br>
                        Төрөл:
                        <select class="form-control" name="category">
                            @foreach(App\TreatmentCategory::all() as $tcategory)

                            @if ($loop->first)
                            <option value="{{$tcategory->id}}" selected>{{$tcategory->name}}</option>
                            @else
                             <option value="{{$tcategory->id}}">{{$tcategory->name}}</option>
                             @endif
                            @endforeach
                        </select>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                Үнэ:
                                <input class="form-control" name="price" type="number" >
                            </div>
                            <div class="col-md-6">
                                Үнийн хязгаар:
                                <input class="form-control" name="limit" type="number" >
                            </div>
                        </div>
                        <br>
                        Зураг:
                        <input class="form-control" type="file" name="image"
                            accept="image/png, image/jpeg">
                        <br>

                        <br>
                        <button class="btn btn-primary" type="submit">Оруулах</button>
                    </form>
                </div>
            </div>
        </div>
   </div>
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