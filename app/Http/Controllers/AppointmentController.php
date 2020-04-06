<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use yajra\Datatables\Datatables; 
use App\Appointment;
use Auth;
use Validator;
use Carbon\Carbon;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('appointment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $this->validate($request, [
            'title' => 'required',
            'start_time' => 'date_format:Y-m-d H:i|required|unique:appointments',
            'end_time' => 'required'
        ]);  
       
        $event = new Appointment;
        $event->user_id = Auth::user()->id;
        $event->title = $request['title'];
        $event->start_time =  $request['start_time'];
        $event->end_time = $request['end_time'];
        if ($request->hasFile('attachments')) {
            $image = $request->file('attachments');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/attachments');
            $image->move($destinationPath, $name); 
            $event->attachment = $name; 
        }    
        $event->save();

        return redirect()->route('appointment.index' )
                        ->with('success','Appointment create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        return view('appointment.edit' , compact('appointment' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
         $this->validate($request, [
            'title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);    

        $appointment->title = $request['title'];
        $appointment->start_time =  $request['start_time'];
        $appointment->end_time = $request['end_time'];
        $appointment->save();

        return redirect()->route('appointment.index' )
                        ->with('success','Appointment update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {   
         $appointment->delete();
          return redirect()->route('appointment.index' )
                        ->with('success','Appointment delete successfully');
    }

    public function getDataAppointments(){

        $items = Appointment::get();
        
        return Datatables::of($items)  
            ->editColumn('start_time', function ($item) { 
                return $item->start_time;
            }) 
            ->editColumn('end_time', function ($item) { 
                return $item->end_time;
            })  
            ->addColumn('action', function ($item) {  
                 $action = '<a href="'.route("appointment.edit", $item->id).'" class="btn btn-primary btn-sm btn-rounded btn-fw" style="margin-right:5px;"><i class="fa fa-pencil"></i> Edit</a>';
                $action .= '<form action="'.route("appointment.destroy", $item->id).'" method="post" style="display:inline-block; vertical-align: middle; margin: 0;" id="'.$item->id.'">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete this Appointment?" class="btn btn-danger btn-sm btn-rounded btn-fw">Delete</button></form>';
              
                return $action;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
