@extends('layouts.app')
@push('stylesheets') 
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
 <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<style type="text/css">
    
</style> 
@endpush 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Appointment</div> 
                <div class="card-body">
                     @if (\Session::has('success'))
                        <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                        </div>
                      @endif
                      @if (count($errors) > 0)
                        <div class="alert alert-danger">
                              @foreach ($errors->all() as $error)
                                  {{ $error }} <br>
                              @endforeach
                        </div>
                      @endif
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary">
                     Add
                    </a>  
                    <div id='calendar'></div>
                         <div class="card">
                            <div class="card-body">
                              <table class="table table-striped data-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th> 
                                        <th>Start Time</th> 
                                        <th>End Time</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>  
                         </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Edit Appointment</h4>

                Title:
                <br />
                <input type="text" class="form-control" name="title" id="title">Title:
                <br />
                <input type="text" class="form-control" name="start_time" id="start_time">

                End time:
                <br />
                <input type="text" class="form-control" name="finish_time" id="finish_time">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="button" class="btn btn-primary" id="appointment_update" value="Save">
            </div>
        </div>
    </div>
</div>
@include('modals.delete')
@endsection

@push('scripts')
 <script type="text/javascript" src="//code.jquery.com/jquery-3.4.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <script src="http://projects.webbions.com/dipyourtoein/public/assets/vendors/moment/moment.min.js"></script>
<script src="http://projects.webbions.com/dipyourtoein/public/assets/vendors/fullcalendar/fullcalendar.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"> 
         $(function() {
                $('#calendar').fullCalendar({
                    events : [
                        @foreach($appointments as $appointment)
                        {
                            title : '{{ $appointment->title }}',
                            start : '{{ $appointment->start_time }}', 
                        },
                        @endforeach
                    ],
                    eventClick: function(calEvent, jsEvent, view) {
                        $('#start_time').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
                        $('#finish_time').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
                        $('#title').val(calEvent.title);
                        $('#editModal').modal();
                    }
                });
                $('#confirmDelete').on('show.bs.modal', function (e) {
                      $message = $(e.relatedTarget).attr('data-message');
                      $(this).find('.modal-body p').text($message);
                      $title = $(e.relatedTarget).attr('data-title');
                      $(this).find('.modal-title').text($title);

                      // Pass form reference to modal for submission on yes/ok
                      var form = $(e.relatedTarget).closest('form');

                      //$(this).find('.modal-footer #confirm').data('form', form);
                      $(this).find('.modal-footer #confirm').data('form',form);
                }); 

                $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
                    $(this).data('form').submit();
                }); 
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    "order": [[ 0, "desc" ]],
                    ajax: {
                        url: "{{ route('getAppointments' )}}",
                        data: function (d) { 
                            d.title = $('input[name=title]').val(); 
                        }
                      },
                      columns: [
                          {data: 'id', name: 'id'}, 
                          {data: 'title', name: 'title'}, 
                          {data: 'start_time', name: 'start_time'}, 
                          {data: 'end_time', name: 'end_time'}, 
                          {data: 'action', name: 'action', orderable: false, searchable: false},
                      ],
                }); 
        });       
    </script>   
    
@endpush

