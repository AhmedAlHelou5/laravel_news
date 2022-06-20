<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//        $classes=Classe::get();
        $classes=User::all();
        return response()->json($classes);
        return view('check',compact('classes'));
    }
//    public function getUsers()
//    {
//        $classes=User::orderBy('id','DESC')->get();
//        return response()->json($classes);
//    }
    public function getUsers(Request$request)
    {
        $classes= User ::when($request->name,function($s)use($request){
        $s->where('name','Like','%'.$request->name.'%');
        })->with('news_type')->paginate(2);
    return response()->json($classes);
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
        $validated=Validator::make($request->all(),[
            'name' =>'required|max:30',
            'email' => 'required|unique:users',
            'password' => 'required',

        ],[],[
                'name' =>'الاسم',
                'email' => 'البريد الالكتروني',
            ]
        );
        if($validated->fails()){
            $msg="تاكد من البيانات المدخلة";
            $data=$validated->errors();
            return response()->json(compact('msg','data'),422);
        }
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        return $request->json(['msg'=>"تمت الاضافة بنجاح"]);
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
        $user=User::Find($id);
        return  response()->json(compact('user'));
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
        $classe=News::Find($id);
        return response()->json($classe);
        dd($id);
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

    public function login(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['message'=>"عذرا البريد الالكتروني غير صحيح "],status:401);
        }
        if(Hash::check($request-> password,$user-> password)){
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response=['token' => $token];
            return response($response,status:200);
        }else{
            $response=["message"=>"عذرا كلمة المرور خطأ"];
            return response($response,status:422);
        }

    }
}
