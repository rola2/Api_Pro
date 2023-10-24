<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function index(){
        $posts = PostResource::collection(Post::get());
        $array = [
            'data'=>$posts,
            'message'=>'ok',
            'status'=>200
        ];
        
        return response($array);
    }
    public function show($id){
        $post = Post::find($id);
        if($post){
             $data = [
            'data'=>$post,
            'message'=>'ok',
            'status'=>200
        ];
            return response(new PostResource($post)) ;
        }else{
        $data = [
            'data'=>'null',
            'message'=>'The Post Not Found!',
            'status'=>401
        ];
        return response($data);
    }
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        if ($validator->fails()){
            return response([null,$validator->errors(),400]);
        }

        $post = Post::create($request->all());
        if($post){
           return response([new PostResource($post),'The Post Save',201]) ;
        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        if ($validator->fails()){
            return response([null,$validator->errors(),400]);
        }
        $post = Post::find($id);
        if(!$post){
            return response("The Post Not Found");
        }
        $post->update($request->all());
        if($post){
            return response([new PostResource($post),'The Post update',201]) ;
         }
    }
    public function destroy($id){
        $post = Post::find($id);
        if(!$post){
            return response("The Post Not Found");
        }
        $post->destroy($id);
        if($post){
            return response([null,'The Post deleted',200]) ;
         }
    }

}
