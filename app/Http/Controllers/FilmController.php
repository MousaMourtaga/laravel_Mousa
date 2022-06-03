<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getFilm(Request $request)
    {
        $filmcs = Film::with('catigoryFilms')->get()
            ->when($request->name, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%');
        })->when($request->phone, function ($q) use ($request) {
            $q->where('showtime', 'like', '%' . $request->showtime . '%');
        });
        return response()->json($filmcs);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|unique:film',
            'catigory_id' => 'required|numeric',
            'detailsfilm' => 'required',
            'showtime' => 'required|date',
            'image' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
        ], [],[
            'name'=> 'الاسم',
            'catigory_id'=>'رقم التصنيف',
            'detailsfilm'=>'تفاصيل الفيلم',
            'showtime'=>'موعد العرض',
            'image' => 'الصورة',

        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }

        $path = $request->file('image')->store('public/image');
        $film = new Film();
        $film->name = $request->name;
        $film->catigory_id  = $request->catigory_id;
        $film->detailsfilm = $request->detailsfilm;
        $film->ratingfilm = $request->ratingfilm;
        $film->image = $path;
        $film->showtime = $request->showtime;
        $film->save();
        return response()->json(['msg' => 'تمت الاضافة بنجاح']);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'sometimes|required|unique:film,name,'.$id,
            'catigory_id' => 'required|numeric',
            'detailsfilm' => 'required',
            'showtime' => 'required|date',
            'image' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
        ], [],[
            'name'=> 'الاسم',
            'catigory_id'=>'رقم التصنيف',
            'detailsfilm'=>'تفاصيل الفيلم',
            'showtime'=>'موعد العرض',
            'image' => 'الصورة',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }

        $path = $request->file('image')->store('public/image');
        $film = Film::Find($id);
        $film->name = $request->name;
        $film->catigory_id  = $request->catigory_id;
        $film->image = $path;
        $film->detailsfilm = $request->detailsfilm;
        $film->ratingfilm = $request->ratingfilm;
        $film->showtime = $request->showtime;
        $film->save();
        return response()->json(['msg' => 'تم التعديل بنجاح']);
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
    public function delete($id)
    {
        $del=Film::Find($id);
        $result=$del->delete();
        if ($result){
            return response()->json(['result' => 'تمت عملية الحذف']);
        }else{
            return response()->json(['result' => 'فشلت عملية الحذف']);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //auth
    public function login(Request $request)
    {
        $usess= User::where('email',$request->email)->first();
        if (!$usess){
            return response()->json(['msg' => 'عذرا هذا الايميل غير صحيح'],401);
        }
        $usess= User::where('password',$request->password)->first();
        if ($usess){
            $token=$usess->createToken('Laravel Password Grant Client')->accessToken;
            $response =['token'=>$token];
            return  response($response,200);
        }else{
            $response =   ['msg' => 'عذرا كلمة المرور خطا'];
            return  response($response,422);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
