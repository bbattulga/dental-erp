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
    <link href="{{asset('plugin/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugin/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="{{asset('plugin/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{asset('plugin/switchery/switchery.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <link rel="stylesheet" href="{{asset('/js/apps/timetable/public/build/bundle.css')}}">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

    <style>
        .hidden{
            display: none;
        }
        .btn-newuser{
            z-index: 1040;
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
            min-width: 60px;
            background-color: #333333;
            color: #e7e7e7e7;
        }

        .tooltip-my:hover .tooltiptext{
            visibility: visible;
        }

        .fullwidth-my{
            width: 100vw;
            position: relative;
            left: 0;
            top: 0;
        }

    </style>
@endsection
@section('content')
    <script>
        document.getElementById('receptionUser').classList.add('active');
    </script>

    <div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg btn-newuser" 
            data-toggle="modal" 
            data-target="#registerModal">Шинэ үйлчлүүлэгч бүртгэх
    </button>

  <!-- Modal -->
  <div class="modal fade" id="registerModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Modal Header</h4>
        </div>
        <div class="modal-body">
          
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="#" method="post" enctype="multipart/form-data" id="form">
                        @csrf
                        <input type="hidden" name="appointment" value="@if(!empty($param)) 1 @else 0 @endif">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputAddress2">Овог</label>
                                    <input name="last_name" type="text" class="form-control" id="lname" placeholder="Овог" value="{{old('last_name')}}">
                                    <span id="lname_msg" style="color:red"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputAddress2">Нэр</label>
                                    <input name="name" type="text" class="form-control" id="fname" placeholder="Нэр"
                                           @if(empty(old('name'))) value="@if(!empty($param)){{$param[0]}}@endif" @else value="{{old('name')}}" @endif>
                                    <span id="fname_msg" style="color:red"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label>Хүйс сонгох</label>
                                <select name="sex" id="inputState" class="form-control">
                                    @if(!empty(old('sex')))
                                        @if(old('sex')==0)
                                            <option value="0">Эр</option>
                                            <option value="1">Эм</option>
                                        @else
                                            <option value="1">Эм</option>
                                            <option value="0">Эр</option>
                                        @endif
                                    @else
                                        <option value="0">Эр</option>
                                        <option value="1">Эм</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Төрсөн он сар</label>
                                <input name="birth_date" autocomplete="off" class="form-control datepicker"
                                       id = "birth" placeholder="Төрсөн он сар" value="{{old('birth_date')}}">
                                <span id="date_msg" style="color:red"></span>
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Цахим хаяг</label>
                                <input name="email" type="email" class="form-control" id="email"
                                       placeholder="Цахим хаягаа оруулна уу" value="{{old('email')}}">
                                <span id="email_msg" style="color:red"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Регистрийн дугаар</label>
                                <input name="register" type="text" class="form-control" id="registernum"
                                       placeholder="Регистрийн дугаараа оруулна уу" value="{{old('register')}}">
                                <span id="registernum_msg" style="color:red"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Утасны дугаар</label>
                            <input name="phone_number" type="text" class="form-control" id="phone" placeholder="Утасны дугаараа оруулна уу"
                                   @if(empty(old('phone_number')))value="@if(!empty($param)){{$param[1]}}@endif" @else value="{{old('phone_number')}}" @endif>
                            <span id="phone_msg" style="color:red"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Гэрийн хаяг</label>
                            <input name="location" type="text" class="form-control" id="Address" placeholder="Гэрийн хаягаа оруулна уу" value="{{old('location')}}">
                            <span id="address_msg" style="color:red"></span>
                        </div>

                        <label for="inputState">Тайлбар</label>

                        <textarea class="form-control" data-val="true" data-val-length="Maximum = 1000000 characters" data-val-length-max="100000" id="info" name="info"  placeholder="Тайлбар">{{old('info')}}</textarea>


                        <div class="form-group row mb-0">
                            <div class="col-sm-10">
                                <br>
                                <button id="btnSubmitNewUser" type="button" 
                                    class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-target="#registerModal">
                                        Үйлчлүүлэгч нэмэх
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="appointment_id" value="@if(!empty($param)) {{$param[2]}} @endif">
                    </form>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

  
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Овог</th>
                        <th>Нэр</th>
                        <th>Хүйс</th>
                        <th>Нас</th>
                        <th>Регистрийн дугаар</th>
                        <th>Утасны дугаар</th>
                        <th>Цаг захиалсан эсэх</th>
                        <th>Сүүлд үйлчлүүлсэн хугацаа</th>
                       <!-- <th>Цахим хаяг</th> -->
                       <th></th>
                    </tr>
                    </thead>
                    <tbody id="usersRowsContainer">
                    <?php $i = 1?>
                    @foreach($users as $user)
                        @if(is_null($user->role))

                        <tr id="user-row-{{$user->id}}">

                            <td>
                                {{$i}}
                                
                                <input id="userdatajson-{{$user->id}}" type="hidden" value="{{$user}}">
                            </td>
                            <td>{{$user->last_name}}</td>
                            <td> <a href="{{url('/admin/user_check/'.$user->id)}}">{{$user->name}}</a></td>
                                <td>
                                @if($user->sex == 0)
                                Эр
                                @elseif($user->sex == 1)
                                    Эм
                                    @endif
                                </td>
                            <td> {{Carbon\Carbon::parse($user->birth_date)->age}}
                            </td>
                            <td>{{$user->register}}</td>
                            <td>{{$user->phone_number}}</td>

                            @if(!empty($user->check_in_today))
                            <td>{{$user->check_in_today->shift->date}}</td>
                            @else
                            <td>цаг захиалаагүй</td>
                            @endif
                            <td>{{ $user->last_treatment_date}}</td>
                            <td>
                                {{--$user->email--}}
                                <div class="row-crud-user">
                                    <div class="crud-ic tooltip-my" 
                                    data-toggle="modal" 
                                            data-target="#checkinModal">
                                        <img src="{{ asset('/img/icon/teethcare.png') }}">
                                        <div class="tooltiptext"                                           
                                            type="button">
                                            Эмчилгээнд оруулах
                                        </div>
                                    </div>
                                    <div class="crud-ic tooltip-my">
                                        <img src="{{ asset('/img/icon/pen.png') }}">
                                        <div class="tooltiptext">
                                             Засах
                                        </div>
                                    </div>
                                    <div onclick="deleteUser({{$user->id}})"
                                        class="crud-ic tooltip-my">
                                        <img src="{{ asset('/img/icon/trashbin.png') }}">
                                        <div class="tooltiptext">
                                            Хаяг устгах
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                         <?php $i++;?>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="checkinModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div id="checkinModalContent" class="modal-content">
        <div class="modal-header">
            <h4>Эмч сонгох</h4>
          <button type="button" class="close" data-dismiss="modal" data-backdrop="false">&times;</button>
        </div>
        <div class="modal-body">

            @foreach(App\Doctor::all() as $doctor)
            <div>{{$doctor->name}}</div>
            <button onclick="submitCheckIn(event, {{$doctor->id}})"
                class="btn btn-primary">
                {{ $doctor->last_name.substr(0, 2).'.'.$doctor->name }}
            </button>
            @endforeach..
        </div>
      </div>
    </div>
</div>

</div>


<!-- delete request -->

<form id="form-user-delete" action="#" method="delete" enctype="multipart/form-data">
    @csrf
    <input id="delete-user-id" type="hidden" name="id" value="">
</form>

<form id="form-checkin">
    <input type="hidden" name="checkin_user_id">
    <input type="hidden" name="checkin_doctor_id">
</form>


@endsection
@section('footer')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <script src="{{asset('plugin/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('plugin/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugin/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/buttons.print.min.js')}}"></script>

    <!-- Key Tables -->
    <script src="{{asset('plugin/datatables/dataTables.keyTable.min.js')}}"></script>

    <!-- Responsive examples -->
    <script src="{{asset('plugin/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugin/datatables/responsive.bootstrap4.min.js')}}"></script>

    <!-- Selection table -->
    <script src="{{asset('plugin/datatables/dataTables.select.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            // Default Datatable
            $('#datatable').DataTable();

            //Buttons examples
            
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf']
            }); 
        
            // Key Tables

            $('#key-table').DataTable({
                keys: true
            });
            
            // Responsive Datatable
            $('#responsive-datatable').DataTable();
        
            // Multi Selection Datatable
            $('#selection-datatable').DataTable({
                select: {
                    style: 'multi'
                }
            });

            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            // $("#checkinModalContent").css('width', '100%');
        });


    let userCreateUrl = '/api/users/create';
    let userDeleteUrl = '/api/users/delete';
    function addNewUser(data){
        /*
            user = {
                user_id: 1,
                last_name: 'Jonjo',
                name: 'Naji',
                register: 'ИШ29384736',
                phone_number: 80394837,
                email: 'jonjonaze@mail.com',
                birth_date: '2002-10-04',
                sex: 1,
                location: 'jonjo location',
                'description': 'jonjodescription'
            }
        */
    }   

    let inputUserId = document.getElementById('delete-user-id');
    function deleteUser(id){

        let data = document.getElementById(`userdatajson-${id}`).value;

        let userRow = document.getElementById(`user-row-${id}`);
        console.log(data);
        if (!window.confirm('a\n b')){
            return;
        }

        let url = `/api/users/delete/${id}`;
        inputUserId.value = id;
        $.ajax({
            type: 'DELETE',
            url: url,
            data: $("#form-user-delete").serialize(),
            success: function(result){
                // remove from dom
                $(`#user-row-${id}`).remove();
            },
            fail: function(err){alert(`error ${err}`)}
        });
    }

    $("#btnSubmitNewUser").click(function(){
        let url = '/api/users/create';
        $.ajax({
            type: 'POST',
            url: url,
            data: $("#form").serialize(),
            success: addNewUser,
            fail: function(err){alert('алдаа гарлаа')}
        });
        return true;
    });

    function submitCheckIn(event, doctorId){
        event.preventDefault();
        let userId = document.getElementById('checkin_user_id');
        console.log(doctorId);
        $("#checkinModal").modal('hide');
    }
    </script>

    <script src="{{asset('js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/vendor/Sortable.js')}}"></script>

    <script src="{{asset('js/validation.js')}}"></script>
@endsection
