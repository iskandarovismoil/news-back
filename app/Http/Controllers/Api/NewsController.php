<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsModel;

use Validator;

class NewsController extends Controller
{   
    public function news()
    {
        return response()->json(NewsModel::get(), 200);
    }

    public function newsAdd(Request $request)
    {   
        $rules = [
            'title' => 'required|min:10|max:200',
            'description' => 'required|min:40',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return response()->json(['error' => true, 'message' => 'Error'], 400);
        }
        $request->request->add(['userid' => 2, 'likes' => 0]);
        $news = NewsModel::create($request->all());
        return response()->json($news, 201);
    }

    public function newsEdit(Request $request, $id)
    {
        $rules = [
            'title' => 'min:10|max:200',
            'description' => 'min:40',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return response()->json(['error' => true, 'message' => $validator->messages()], 400);
        }
        $news = NewsModel::where('id', $id)->first();
        
        if( is_null($news) )
        {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        }

        $news->update($request->all());
        return response()->json($news, 200);
    }

    public function newsDelete(Request $request, $id)
    {
        $news = NewsModel::where('id', $id)->first();
        if( is_null($news) )
        {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        }
        $news->delete();
        return response()->json('ok', 204);
    }
}
