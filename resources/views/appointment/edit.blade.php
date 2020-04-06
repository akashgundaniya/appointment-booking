@extends('appointment.create')
@section('editId', route('appointment.update', $appointment->id))

@section('editMethod')
	{{method_field('PUT')}}
@endsection