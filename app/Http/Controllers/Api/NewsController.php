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
        $news_list = NewsModel::paginate(20);
        return response()->json($news_list, 200);
    }

    public function news_by_id($id)
    {
        $news = NewsModel::where([['id', $id]])->first();
        
        if($news) {

            if(auth()->id() == $news->userid)
                $my = true;
            else
                $my = false;
         
        } else
            $my = NULL;
        
        return response()->json(['data' => $news, 'my' => $my], 200);
    }

    public function news_by_userid($userid)
    {
        return response()->json(NewsModel::where([['userid', $userid]])->get(), 200);
    }

    public function news_my()
    {
        return response()->json(NewsModel::where([['userid', auth()->id()]])->get(), 200);
    }

    public function news_add(Request $request)
    {   

        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }

        $rules = [
            'title' => 'required|min:10|max:200',
            'description' => 'required|min:40',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 200);
        }

        $news = NewsModel::create([
            "title" => htmlspecialchars($request->title, ENT_QUOTES), 
            "description" => htmlspecialchars($request->description, ENT_QUOTES), 
            'userid' => auth()->id(), 
            'likes' => 0
        ]);

        return response()->json(['success' => true, 'error' => false], 201);
    }

    public function news_edit(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }

        $rules = [
            'title' => 'min:10|max:200',
            'description' => 'min:40',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 400);
        }

        $news = NewsModel::where([['id', $id], ['userid', auth()->id()]])->first();
        
        if( is_null($news) ) {
            return response()->json(['success' => false, 'error' => 'Not found'], 403);
        }
        
        $news->update([
            "title" => htmlspecialchars($request->title, ENT_QUOTES), 
            "description" => htmlspecialchars($request->description, ENT_QUOTES), 
        ]);

        return response()->json(['success' => true, 'error' => false], 200);
    }

    public function news_delete(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 200);
        }

        $news = NewsModel::where([['id', $id], ['userid', auth()->id()]])->first();

        if( is_null($news) ) {
            return response()->json(['success' => false, 'error' => 'Not found'], 200);
        }

        $news->delete();

        return response()->json(['success' => true, 'error' => false], 200);
    }
}
