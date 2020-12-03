<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use yajra\Datatables\Datatables;

class FirmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Firm::select('*')->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $html = "<button class='btn btn-primary btn-icon' onclick='edit_firm(".$row['id'].")'><i class='fa fa-pen'></i></button>
                    <button class='btn btn-danger btn-icon' onclick='delete_firm(".$row['id'].")'><i class='far fa-trash-alt'></i></button>";
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('firms');
    }

    public function store(Request $request)
    {
        $input['name'] = $request->name;
        $input['gst'] =  $request->gst;
        $input['address'] = $request->address;
        $input['state'] = $request->state;
        if($request->id){
            $check = Firm::where('id', $request->id)->update($input);
            $data['message'] = "Firm Updated successfully";
        }
        else{
            $check = Firm::create($input);
            $data['message'] = "Firm added successfully";
        }
        if($check){
            $data['success'] = true;
            return response()->json($data, 200);
        }
        else{
            $data['success'] = false;
            $data['message'] = "Something went wrong";
            return response()->json($data, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Http\Response
     */
    public function show(Firm $firm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Http\Response
     */
    public function edit($firm)
    {
        $data = Firm::find($firm);
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Http\Response
     */
    public function destroy($firm)
    {
        $check = Firm::where('id', $firm)->delete();
        if($check){
            $data['success'] = true;
            $data['message'] = "Firm deleted successfully";
            return response()->json($data, 200);
        }
        $data['success'] = false;
        $data['message'] = "Something went wrong";
        return response()->json($data, 200);
    }
}
