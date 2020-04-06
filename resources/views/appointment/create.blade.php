@extends('layouts.app')
@push('stylesheets')  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@endpush
@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-end flex-wrap">
            <div class="mr-md-3 mr-xl-5"> 
               @if( isset($appointment) )
                 <h2>{{ __('Edit Appointment') }}</h2>
               @else
                 <h2>{{ __('Add New Appointment') }}</h2>
              @endif
               <div class="d-flex">
                <a href="{{ url('/') }}" class="text-muted mb-0 hover-cursor"><i class="mdi mdi-home text-muted hover-cursor"></i>Dashboard<a/>
                &nbsp;/&nbsp; 
                <span class="mb-0 hover-cursor text-primary">
                   @if( isset($appointment) )
                    {{ __('Edit Appointment') }} 
                   @else
                     {{ __('Add New Appointment') }}
                  @endif
                </span> 
              </div>
            </div> 
          </div> 
        </div>
      </div>
  </div>  
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

    <form id="UserForm" name="ParkingForm" action="@yield('editId',route('appointment.index'))" method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
      {{csrf_field()}}
      @section('editMethod')
      @show 
      @csrf
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group row">
                <label for="title" class="col-md-12 col-form-label">{{ __('Appointment Name') }}</label> 
                <div class="col-md-12">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ ( ( isset($appointment->title) ) ? $appointment->title : old('title') ) }}" required autocomplete="title" autofocus>

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="start_time" class="col-md-12 col-form-label">{{ __('Start Time') }}</label> 
                <div class="col-md-12">
                    <input id="start_time" type="text" class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{ ( ( isset($appointment->start_time) ) ? $appointment->start_time : old('start_time') ) }}" required autocomplete="start_time" autofocus>

                    @error('start_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="end_time" class="col-md-12 col-form-label">{{ __('End Time') }}</label> 
                <div class="col-md-12">
                    <input id="end_time" type="text" class="form-control @error('end_time') is-invalid @enderror" name="end_time" value="{{ ( ( isset($appointment->end_time) ) ? $appointment->end_time : old('end_time') ) }}" required autocomplete="end_time" autofocus>

                    @error('end_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div> 
              <div class="form-group row">
                <label for="name" class="col-md-12 col-form-label">{{ __('Notes') }}</label> 
                <div class="col-md-12">
                    <textarea class="form-control @error('notes') is-invalid @enderror" name="tile" value="{{ ( ( isset($appointment->notes) ) ? $appointment->notes : old('notes') ) }}" required autocomplete="end_time" autofocus></textarea>

                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div> 
             
              <div class="form-group row">
                <label for="name" class="col-md-12 col-form-label">{{ __('Attachments') }}</label> 
                <div class="col-md-12">
                    <input id="attachments" type="file" class="@error('end_time') is-invalid @enderror" name="attachment" /> 
                </div>
              </div> 
            </div>
            <div class="card-footer">
              <input type="submit" name="" value="Submit" class="btn btn-primary mr-2">
              <a class="btn btn-light" href="{{ route('appointment.index') }}">{{ __('Cancel') }}</a>
            </div>  
          </div>
        </div> 
      </div>
    </form>

@include('modals.delete')
@endsection

@push('scripts') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
      $(function() {
              $('#start_time').datetimepicker({ format: 'YYYY-MM-DD HH:mm',});
              $('#end_time').datetimepicker({format: 'YYYY-MM-DD HH:mm'});
        });  
  </script>
@endpush