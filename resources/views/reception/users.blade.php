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
  <button id="btn-modal-register" type="button" 
            class="btn btn-info btn-lg btn-newuser" 
            data-toggle="modal" 
            data-target="#registerModal">Шинэ үйлчлүүлэгч бүртгэх
    </button>

  <!-- Modal -->
  <div class="modal fade" id="registerModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4>Шинэ үйлчлүүлэгч нэмэх</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
                <div class="">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <div class="">
                            <form enctype="multipart/form-data" 
                                id="form-register">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Овог</label>
                                        <input type="text" 
                                                class="form-control" id="last_name"
                                                name="last_name"
                                                placeholder="овог"
                                                required>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Нэр</label>
                                        <input type="text" 
                                                class="form-control" 
                                                id="name" 
                                                name="name"
                                                placeholder="нэр"
                                                required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Регистрийн дугаар</label>
                                    <input type="text" 
                                            class="form-control" 
                                            id="register" 
                                            name="register"
                                            placeholder="АБ3948..."
                                            required>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="last_name">төрсөн он сар</label> <br />
                                        <input type="date" name="birth_date">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Хүйс</label> <br />
                                        <select name="sex">
                                            <option value="0" selected>Эр</option>
                                            <option value="1">Эм</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Утас</label>
                                        <input type="text" 
                                                class="form-control" id="phone"
                                                name="phone_number"
                                                placeholder="8948..."
                                                required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">email</label>
                                        <input type="email" 
                                                class="form-control" 
                                                id="email" 
                                                name="email"
                                                placeholder="john.doe@gmail.com...">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputAddress">Гэрийн хаяг</label>
                                    <input type="text" 
                                            class="form-control" 
                                            name="location"
                                            placeholder="СБД...">
                                </div>

                                <div class="form-group">
                                    <label for="inputAddress">Тайлбар</label>
                                    <input type="text" 
                                            class="form-control" 
                                            name="description"
                                            placeholder="...">
                                </div>

                                <button id="btnSubmitNewUser"
                                     class="btn btn-primary d-block mt-3"
                                     data-dismiss="modal"
                                        style="float:right;">
                                    Бүртгэх
                                </button>
                            </form>
                        </div>
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
                    <tbody id="users_rows_container">
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

                            @if(!empty($user->checkin_today))
                            <td id="td-checkin-{{$user->id}}">Тийм</td>
                            @else
                            <td id="td-checkin-{{$user->id}}">---</td>
                            @endif
                            <td>{{ $user->last_treatment_date == null? '---': $user->last_treatment_date }}</td>
                            <td>
                                {{--$user->email--}}
                                <div class="row-crud-user">
                                    <div class="crud-ic tooltip-my" 
                                    data-toggle="modal" 
                                            data-target="#checkinModal"
                                    onclick="setCheckinUserId(event, {{$user->id}})">
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
            <div style="display: grid; grid-template-columns: 8fr 2fr;
                                        box-shadow: 1px 1px 2px #444444; margin-bottom: 5px;">
                <div>{{$doctor->last_name}}. {{$doctor->name}}</div>
                <button onclick="submitCheckIn(event, {{$doctor->id}})" data-dismiss="modal"
                    class="btn btn-primary" style=" margin-bottom: 10px;">
                    сонгох
                </button>
            </div>
            @endforeach
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

<form id="form-checkin" action="#" method="post" enctype="multipart/form-data" >
    @csrf
    <input id="checkin_user_id" type="hidden" name="user_id">
    <input id="checkin_doctor_id" type="hidden" name="doctor_id">
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

    function _calculateAge(birthday) { // birthday is a date
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }

    let userCreateUrl = '/api/users/create';
    let userDeleteUrl = '/api/users/delete';
    function addNewUser(data){
        console.log('add new user');
        console.log(data);
        let user = data;

        let rowCrud = `<div class="row-crud-user">`+
                           `<div id="user-checkin-${user.id}" class="crud-ic tooltip-my" `+
                                    `data-toggle="modal"`+
                                   `data-target="#checkinModal"`+
                                    ` onclick="setCheckinUserId(event, ${user.id})">`+
                             `<img src="/img/icon/teethcare.png">`+
                             `<div class="tooltiptext"` +                                    
                                  `  type="button"> `+
                                   ` Эмчилгээнд оруулах `+
                                `</div>` +
                           ` </div> `+

                           ` <div class="crud-ic tooltip-my"> `+
                                    `<img src="/img/icon/pen.png">`+
                                    `<div class="tooltiptext"> `+
                                       `Засах `+
                                    `</div>` +
                            `</div>`+
                            `<div id="user-del-${user.id}" onclick="deleteUser(${user.id})"`+
                                `class="crud-ic tooltip-my">`+
                                `<img src="/img/icon/trashbin.png">` +
                                `<div class="tooltiptext">`+
                                    ` Хаяг устгах` +
                               ` </div>`+
                            `</div>`+
                       `</div>`;

        let row = `<td>-</td>`+
                `<input id="userdatajson-${user.id}" type="hidden" value="${user}">`+
                `<td>${user.last_name}</td>`+
                `<td>${user.name}</td>`+
                `<td>${user.sex == '0'?'Эр': 'Эм'}</td>`+
                `<td>${_calculateAge(new Date(user.birth_date))}</td>`+
                `<td>${user.register}</td>`+
                `<td>${user.phone_number}</td>`+
                `<td id="td-checkin-${user.id}">---</td>`+
                `<td>---</td>`+
                `<td>${rowCrud}</td>`;
        $("#users_rows_container").prepend(row);
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

    $("#btnSubmitNewUser").click(function(event){
        event.preventDefault();
        let url = '/api/users/create';
        $.ajax({
            type: 'POST',
            url: url,
            data: $("#form-register").serialize(),
            success: addNewUser,
            fail: function(err){alert('алдаа гарлаа')}
        });
        return true;
    });

    function setCheckinUserId(event, userId){
        event.preventDefault();
        $("#checkin_user_id").val(userId);
    }

    function getCheckInUserId(){
        return $("#checkin_user_id").val();
    }

    function checkinSuccess(){
        let userId = getCheckInUserId();
        $(`#td-checkin-${userId}`).html('Тийм');
        alert('Ok');
    }

    function checkinFail(){
        aleret('Алдаа гарлаа')
    }

    function submitCheckIn(event, doctorId){
        event.preventDefault();
        $("#checkin_doctor_id").val(doctorId);
        $.ajax({
            type: 'POST',
            url: '/api/checkins/create',
            data: $("#form-checkin").serialize(),
            success: checkinSuccess,
            fail: checkinFail
        });
    }

    </script>

    <script src="{{asset('js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/vendor/Sortable.js')}}"></script>

    <script src="{{asset('js/validation.js')}}"></script>
@endsection
