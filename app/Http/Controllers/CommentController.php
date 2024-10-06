<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller 
{
    
    public function index($id)
    {
        return response(Comment::where('product_id',$id)->get(),200);
    }

    public function store(Request $request, $id)
    {
        $request -> validate([
         'comment'=>'required'
        ]);
        $comment =Comment::create([
            'product_id'=>$id ,
            'user_id'=>Auth::id(),
            'comment'=>$request->comment 
        ]);
        Product::where('id',$id)->increment('comments');
        return response($comment,201);
    }
}
