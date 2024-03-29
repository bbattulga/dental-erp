<head>
      <meta charset="UTF-8">
      <title>date</title>
      <meta name="robots" content="noindex">
      <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">
      <link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">
      <link rel="canonical" href="https://codepen.io/caioferracioli/pen/PROdKa">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">

     <link href="{{ asset('/css/shifts.css') }}" rel="stylesheet">

      <script id="weatherwidget-io-js" src="https://weatherwidget.io/js/widget.min.js"></script><script src="https://static.codepen.io/assets/editor/iframe/iframeConsoleRunner-dc0d50e60903d6825042d06159a8d5ac69a6c0e9bcef91e3380b17617061ce0f.js"></script>
      <script src="https://static.codepen.io/assets/editor/iframe/iframeRefreshCSS-e03f509ba0a671350b4b363ff105b2eb009850f34a2b4deaadaa63ed5d970b37.js"></script>
      <script src="https://static.codepen.io/assets/editor/iframe/iframeRuntimeErrors-29f059e28a3c6d3878960591ef98b1e303c1fe1935197dae7797c017a3ca1e82.js"></script>
      <script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/41/5/common.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/41/5/util.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/41/5/controls.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/41/5/places_impl.js"></script>

</head>
<body>
      <div class="row">
  

</div>

<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">

<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css' rel='stylesheet' media='print' />

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<div id="contextMenu" class="dropdown clearfix">

</div>


<div class="panel panel-default hidden-print">
  <div class="panel-heading">
    <h3 class="panel-title">Хайлтын хэсэг</h3>
  </div>
  <div class="panel-body">
    
    <div class="col-lg-4">
  
  <label for="calendar_view">Төрлөөр хайх</label>
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
  
  <label for="calendar_view">Сараар хайх</label>
  <div class="input-group">
      <select class="filter" id="calendar_filter" multiple="multiple">
        <option value="Sales">Sales</option>
        <option value="Lettings">Lettings</option>
      </select>
    </div>
</div>
    
    <div class="col-lg-4">
  
  <label for="calendar_view">Эмчээр хайх</label>
  <div class="input-group">
      <label class="checkbox-inline"><input class='filter' type="checkbox" value="Caio Vitorelli" checked>Сараа</label>
      <label class="checkbox-inline"><input class='filter' type="checkbox" value="Peter Grant" checked>Дулмаа</label>
      <label class="checkbox-inline"><input class='filter' type="checkbox" value="Adam Rackham" checked>Болдоо</label>
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
      
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCit4RJVPT9UiLQCJJPYEBkNTJCslqO4ps&libraries=places"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCit4RJVPT9UiLQCJJPYEBkNTJCslqO4ps&amp;libraries=places"></script>
      <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

      <script src="{{ asset('/js/shifts.js') }}"></script>
</body>