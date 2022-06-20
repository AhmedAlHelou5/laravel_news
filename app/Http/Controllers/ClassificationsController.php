<?php

namespace App\Http\Controllers;

use App\Models\Classifications;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated= \Illuminate\Support\Facades\Validator::make($request->all(),[
            'type' =>'required|unique:classification',
        ],[],[
                'type' =>'الصنف',
            ]
        );
        if($validated->fails()){
            $msg="تاكد من البيانات المدخلة";
            $data=$validated->errors();
            return response()->json(compact('msg','data'),402);
        }

        $type= new Classifications();
        $type->type=$request->type;
        $type->save();
        return response()->json(['message'=>"تم إضافة الصنف  بنجاح "]);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    public function addType(Request $request)
    {
//        $validated= \Illuminate\Support\Facades\Validator::make($request->all(),[
//            'type' =>'required',
//        ],[],[
//                'type' =>'الصنف',
//            ]
//        );
//        if($validated->fails()){
//            $msg="تاكد من البيانات المدخلة";
//            $data=$validated->errors();
//            return response()->json(compact('msg','data'),402);
//        }
//
//        $type= new Classifications();
//        $type->type=$request->type;
//        $type->save();
//        return response()->json(['message'=>"تم إضافة الصنف  بنجاح "]);
    }
}
