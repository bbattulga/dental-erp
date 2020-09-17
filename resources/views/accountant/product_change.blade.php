@extends('layouts.accountant')
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
    <!-- Menu active-->
    <script>
        document.getElementById('accountantProduct').classList.add('active');
    </script>
    <div class="row">
        <div class="col-lg-5">

            <div class="card">
                <div class="card-body">
                    <div class="btn-group float-right float-none-xs mt-2">
                        <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Хайх...">
                        </div>
                    </div>
                    <h5 class="card-title">Барааны жагсаалт
                        <br> <span class="text-muted text-small d-block">Барааны нэрэн дээр даран тоо болон үнийг өөрчилнө үү</span>
                    </h5>


                    <table id="myTable" class="data-table responsive nowrap" data-order="[[ 0, &quot;desc&quot; ]]">

                        <thead>
                        <tr>
                            <th>Дугаар</th>
                            <th>Барааны нэр</th>
                            <th>Хэмжээ</th>
                            <th>Барааны үнэ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1?>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$i}}</td>
                                <?php $i = $i + 1?>
                                <td>
                                    {{--<button type="button" class="btn btn-primary " data-toggle="modal"--}}
                                    {{--data-target="#exampleModalPopovers" onclick="onItemClick({{$product->id}})">--}}
                                    <a href="{{url('accountant/change_product_index/'.$product->id)}}">
                                        {{$product->name}}
                                    </a>
                                    {{--</button>--}}
                                </td>
                                <td>
                                    <p class="text-muted">{{$product->quantity}}{{$product->unit}}</p></td>
                                <td>{{$product->price}} ₮</td>


                            </tr>
                        @endforeach
                        <script>
                            function onItemClick(id) {
                                document.getElementById('hidden').value = id;
                                return true;
                            }
                        </script>


                        </tbody>
                    </table>

                </div>
            </div>


        </div>
        <div class="col-xl-7 col-lg-12 mb-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Барааг өөрчлөх</h5>
                            <form id ="form1" method="POST" action="{{url('/accountant/change_product')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$specific_product->id}}" />
                                <div class="form-group">
                                    <label>Барааны нэр</label>
                                    <input value="{{$specific_product->name}}" type="text" name="name" class="form-control mb-3">
                                </div>
                                
                                <div class="form-group">
                                    <label>Байгаа хэмжээ/ширхэг ({{$specific_product->unit}})</label>
                                    <input value="{{$specific_product->quantity}}" name="quantity" id="too"  class="form-control mb-3"
                                       type="number">
                                </div>

                                <div class="form-group">
                                    <label>Үнэ(₮)</label>
                                    <input value="{{$specific_product->price}}" name="price" id="too"  class="form-control mb-3"
                                       type="number">
                                </div>
                                <button onclick="numa()" class="btn btn-primary btn-block"
                                        type="submit">
                                    Хадгалах
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
@section('footer')
    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        function numb() {
            var number = document.getElementById("numhas").value;
            if(number < 1) {
                document.getElementById('numhas').classList.add('border-danger');
                document.getElementById('numhas_msg').innerHTML = "Утга буруу оруулсан байна";
            } else {
                document.getElementById("form").submit();
            }
        }
        function numa(){
            var too = document.getElementById("too").value;
            var une = document.getElementById("une").value;
            if(too < 1 ) {
                document.getElementById('too').classList.add('border-danger');
            }
            else if(une < 1){
                document.getElementById('une').classList.add('border-danger');
            }
            else {
                document.getElementById("form1").submit();
            }
        }
        function baraa() {
            var br = document.getElementById("br").value;
            if(br < 1) {
                document.getElementById('br').classList.add('border-danger');
            } else {
                document.getElementById("form3").submit();
            }
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

@endsection