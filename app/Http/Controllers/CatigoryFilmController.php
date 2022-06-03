<?php

namespace App\Http\Controllers;

use App\Models\CatigoryFilm;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatigoryFilmController extends Controller
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
    public function getCategory(Request $request)
    {
        $categorycs = CatigoryFilm::get();
        return response()->json($categorycs);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'categoryName' => 'required|unique:film_categories',
        ], [],[
            'categoryName'=> 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }
        $category = new CatigoryFilm();
        $category->categoryName = $request->categoryName;
        $category->save();
        return response()->json(['msg' => 'تمت الاضافة بنجاح']);
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
    public function edit($id)
    {
        //
    }
    public function delete($id)
    {
        $del=CatigoryFilm::Find($id);
        $result=$del->delete();
        if ($result){
            return response()->json(['result' => 'تمت عملية الحذف']);
        }else{
            return response()->json(['result' => 'فشلت عملية الحذف']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'categoryName' => 'sometimes|required|unique:film_categories,categoryName,'.$id,
        ], [],[
            'categoryName'=> 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }
        $category = CatigoryFilm::Find($id);
        $category->categoryName = $request->categoryName;
        $category->save();
        return response()->json(['msg' => 'تم التعديل بنجاح']);
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
