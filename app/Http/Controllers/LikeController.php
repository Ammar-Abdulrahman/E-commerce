<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function store($id)
    {   
        $isLike=Like::where('user_id',Auth::id());
        $isLike = Like::where('product_id',$id);
        if ($isLike->exists()){
            Like::where('user_id',Auth::id()) 
            ->where('product_id',$id)
            ->delete();
            Product::where('id',$id)->decrement('likes');
            return response(null,200);
        }else{
           $like =Like::create([
               'product_id'=>$id ,
               'user_id'=>Auth::id() 
           ]);
           Product::where('id',$id)->increment('likes');
           return response(null,201);
        }
    }

    
    public function index(Product $product)
    {
        return response(Like::where('product_id',$product->id)->get(),200);
    }

}
