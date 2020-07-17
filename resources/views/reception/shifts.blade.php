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
    <link rel="stylesheet" href="{{asset('css/vendor/date.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
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

<div class="row">
  
    <div id="contextMenu" class="dropdown clearfix"></div>

    <div class="panel panel-default hidden-print">
      <div class="panel-heading">
        <h3 class="panel-title">Filter Calendar (Users, Calendar and Eventy Type)</h3>
      </div>
      <div class="panel-body">
        
        <div class="col-lg-4">
      
      <label for="calendar_view">Filter Eventy Type</label>
      <div class="input-group">
          <select class="filter" id="type_filter" multiple="multiple">
            <option value="Appointment">Appointment</option>
            <option value="Check-in">Check-in</option>
            <option value="Checkout">Checkout</option>
            <option value="Inventory">Inventory</option>
            <option value="Valuation">Valuation</option>
            <option value="Viewing">Viewing</option>
          </select>
        </div>
    </div>
        
        <div class="col-lg-4">
      
      <label for="calendar_view">Filter Calendars</label>
      <div class="input-group">
          <select class="filter" id="calendar_filter" multiple="multiple">
            <option value="Sales">Sales</option>
            <option value="Lettings">Lettings</option>
          </select>
        </div>
    </div>
        
        <div class="col-lg-4">
      
      <label for="calendar_view">Filter Users</label>
      <div class="input-group">
          <label class="checkbox-inline"><input class='filter' type="checkbox" value="Caio Vitorelli" checked>Caio Vitorelli</label>
          <label class="checkbox-inline"><input class='filter' type="checkbox" value="Peter Grant" checked>Peter Grant</label>
          <label class="checkbox-inline"><input class='filter' type="checkbox" value="Adam Rackham" checked>Adam Rackham</label>
      </div>
    </div>
        
      </div>
    </div>
    
            <div id="wrapper">
                <div id="loading"></div>
                <div class="print-visible" id="calendar"></div>
            </div>
        
          
          <!-- ADD EVENT MODAL -->
          
          <div class="modal fade" tabindex="-1" role="dialog" id="newEventModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Create new <span class="eventType"></span></h4>
                </div>
                <div class="modal-body">
                  
                  <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="title">All Day Event ?</label>
                            <input class='allDayNewEvent' type="checkbox"></label>
                        </div>
                    </div>
              
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="title">Event title</label>
                            <input class="inputModal" type="text" name="title" id="title" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="starts-at">Starts at</label>
                            <input class="inputModal" type="text" name="starts_at" id="starts-at" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="ends-at">Ends at</label>
                            <input class="inputModal" type="text" name="ends_at" id="ends-at" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="calendar-type">Calendar</label>
                            <select class="inputModal" type="text" name="calendar-type" id="calendar-type">
                              <option value="Sales">Sales</option>
                              <option value="Lettings">Lettings</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="add-event-desc">Description</label>
                            <textarea rows="4" cols="50" class="inputModal" name="add-event-desc" id="add-event-desc"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-event">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
          
          
          <!-- EDIT EVENT MODAL -->
          
          <div class="modal fade" tabindex="-1" role="dialog" id="editEventModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Edit <span class="eventName"></span></h4>
                </div>
                <div class="modal-body">
                  
                    
              
              <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="title">All Day Event ?</label>
                            <input class='allDayEdit' type="checkbox"></label>
                        </div>
                    </div>
              
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="title">Event title</label>
                            <input class="inputModal" type="text" name="editTitle" id="editTitle" />
                        </div>
                    </div>
              
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="starts-at">Starts at</label>
                            <input class="inputModal" type="text" name="editStartDate" id="editStartDate" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="ends-at">Ends at</label>
                            <input class="inputModal" type="text" name="editEndDate" id="editEndDate" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="edit-calendar-type">Calendar</label>
                            <select class="inputModal" type="text" name="edit-calendar-type" id="edit-calendar-type">
                              <option value="Sales">Sales</option>
                              <option value="Lettings">Lettings</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="edit-event-desc">Description</label>
                            <textarea rows="4" cols="50" class="inputModal" name="edit-event-desc" id="edit-event-desc"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteEvent">Delete Event</button>
                    <button type="button" class="btn btn-primary" id="updateEvent">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@endsection

@section('footer')
<script>
    document.getElementById('receptionShifts').classList.add('active');
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
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale-all.js"></script>
    <script src="{{asset('js/vendor/date.js')}}"></script>
    <script src="{{asset('js/vendor/date2.js')}}"></script>
    <script>
      newEvent = function(start, end, eventType) {
      
      var colorEventyType;
      
      if (eventType == "Appointment"){
        colorEventyType = "colorAppointment";
      }
      else if (eventType == "Check-in"){
        colorEventyType = "colorCheck-in";
      }
      else if (eventType == "Checkout"){
        colorEventyType = "colorCheckout";
      }
      else if (eventType == "Inventory"){
        colorEventyType = "colorInventory";
      }
      else if (eventType == "Valuation"){
        colorEventyType = "colorValuation";
      }
      else if (eventType == "Viewing"){
        colorEventyType = "colorViewing";
      }

      $("#contextMenu").hide();
      $('.eventType').text(eventType);
      $('input#title').val("");
      $('#starts-at').val(start);
      $('#ends-at').val(end);
      $('#newEventModal').modal('show');
      
      var statusAllDay;
      var endDay;
    
      $('.allDayNewEvent').on('change',function () {
      
        if ($(this).is(':checked')) {
          statusAllDay = true;
          var endDay = $('#ends-at').prop('disabled', true);
        } else {
          statusAllDay = false;
          var endDay = $('#ends-at').prop('disabled', false);
        }   
      });
      
      //GENERATE RAMDON ID - JUST FOR TEST - DELETE IT
      var eventId = 1 + Math.floor(Math.random() * 1000);
      //GENERATE RAMDON ID - JUST FOR TEST - DELETE IT
    
      $('#save-event').unbind();
      $('#save-event').on('click', function() {
      var title = $('input#title').val();
      var startDay = $('#starts-at').val();
      if(!$(".allDayNewEvent").is(':checked')){
        var endDay = $('#ends-at').val();
      }
      var calendar = $('#calendar-type').val();
      var description = $('#add-event-desc').val();
      var type = eventType;
      if (title) {
        var eventData = {
            _id: eventId,
            title: title,
            avatar: 'https://republika.mk/wp-content/uploads/2017/07/man-852762_960_720.jpg',
            start: startDay,
            end: endDay,
            description: description,
            type: type,
            calendar: calendar,
            className: colorEventyType,
            username: 'Caio Vitorelli',
            backgroundColor: '#1756ff',
            textColor: '#ffffff',
            allDay: statusAllDay
        };
        $("#calendar").fullCalendar('renderEvent', eventData, true);
        $('#newEventModal').find('input, textarea').val('');
        $('#newEventModal').find('input:checkbox').prop('checked',false);
        $('#ends-at').prop('disabled', false);
        $('#newEventModal').modal('hide');
        }
      else {
        alert("Title can't be blank. Please try again.")
      }
      });
  }
    </script>
@endsection