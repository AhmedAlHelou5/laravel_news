<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $newss = News::all();
        return response()->json($newss);

    }

    public function get_news_with_category()
    {
        $newss = News::with('typeNews')->get();
        return response()->json($newss);
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
        //
    }
    public function addNews(Request $request)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title' => 'required',
            'photo' => 'required',
            'description' => 'required',
            'date' => 'required',
            'classification_id' => 'required',
        ], [], ['title' => 'عنوان الخبر', 'photo' => 'صورة الخبر', 'description' => 'تفاصيل الخبر', 'date' => 'التاريخ', 'classification_id' => 'التصنيف']);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 402);
        }
        $path = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $image_name = time() . '.' . $file->getClientOriginalExtension();
            $path = 'images' . '/' . $image_name;
            $file->move(public_path('images'), $image_name);

            $news = new News();
            $news->title = $request->title;
            $news->photo = $path;
            $news->description = $request->description;
            $news->date = $request->date;
            $news->classification_id = $request->classification_id;
            $news->save();
            return response()->json(['message' => "تم إضافة الخبر بنجاح "]);
        } else {
            $news = new News();
            $news->title = $request->title;
            $news->description = $request->description;
            $news->time = $request->time;
            $news->save();
            return response()->json(['message' => "تم إضافة الخبر بنجاح "]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        $newss = News::find($id);
        return response()->json($newss);
        //
    }

// حسب العنوان والتصنيف
    public function filterNewsTitleAndType(Request $request)
    {
        $news = News::select('news.*')
            ->join('classification', 'classification.id', '=', 'news.classification_id')
            ->When($request, function ($query) use ($request) {
                $query->where('news.title', 'Like', '%' . $request->title . '%');
                if ($request->classification_id != null)
                    $query->where('classification.type', 'Like', '%' . $request->classification_id . '%');
//                    $query->where('classification.id',$request->classification_id);
            })->with('typeNews')->get();
        return response()->json($news);
    }

    public function filterByTitle(Request $request)
    {
        $news = News::orderby('id', 'Asc')
            ->When($request, function ($query) use ($request) {
                $query->where('title', 'Like', '%' . $request->title . '%');
//                if ($request->classification_id!=null){}
            })->with('typeNews')->get();
        return response()->json($news);
    }
// اي تاريخ
    public function filterBydate(Request $request)
    {
        if ($request->date  == null) {
            $newss = News::with('typeNews')->get();
            return response()->json($newss);
        }else{
        $news = News::orderby('id', 'Asc')
            ->When($request, function ($query) use ($request) {
                $query->where('date', 'Like', '%' . $request->date . '%');
            })->with('typeNews')->get();
        return response()->json($news);}
    }

    //   تاريخ محدد
    public function filterNewsByDate(Request $request)
    {
        $news = News::orderby('id', 'Asc')
       -> when($request->date, function ($query) use ($request) {
            $query->whereDate('date', date('Y-m-d', strtotime($request->date)));
        })->with('typeNews')->get();
        return response()->json($news);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title' => 'sometimes:news,title,' . $id,
            'photo' => 'sometimes:news,photo,' . $id,
            'description' => 'sometimes:news,description,' . $id,
            'date' => 'sometimes:news,date,' . $id,
            'classification_id' => 'sometimes:news,classification_id,' . $id,
        ], [], ['title' => 'عنوان الخبر', 'photo' => 'صورة الخبر', 'description' => 'تفاصيل الخبر', 'date' => 'التاريخ', 'classification_id' => 'التصنيف']);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 402);
        }
        $path = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $image_name = time() . '.' . $file->getClientOriginalExtension();
            $path = 'images' . '/' . $image_name;
            $file->move(public_path('images'), $image_name);

            $news = News::Find($id);
            if ($request->title) {
                $news->title = $request->title;
            }
                $news->photo = $path;

            if ($request->description) {
                $news->description = $request->description;

            }
            if ($request->date) {
                $news->date = $request->date;
            }
            if ($request->classification_id) {
                $news->classification_id = $request->classification_id;
            }

            $news->update();
            return response()->json(['message' => "تم تعديل الخبر بنجاح "]);

        } else {
            $news = News::Find($id);
            $news->title = $request->title;
            $news->description = $request->description;
            $news->date = $request->date;
            $news->classification_id = $request->classification_id;
            $news->update();
            return response()->json(['message' => "تم تعديل الخبر بنجاح "]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $news=News::find($id)->delete();
        return response()->json(['message' => "تم حذف الخبر بنجاح "]);

    }





}
