<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function category()
    {
        $category = Category::where('status','1')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);
    }

    public function product($slug)
    {

        $category = Category::where('slug', $slug)->first();


        if($category)
        {
            $product = Product::where('category_id', $category->id)->where('status','1')->get();

            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product_data'=>[
                        'product'=>$product,
                        'category'=>$category,
                    ]
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'Product Not Available'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found'
            ]);
        }
    }


    public function viewproduct($category_slug, $product_slug)
    {
        $category = Category::where('slug',$category_slug)->first();

        if($category)
        {
            $product = Product::where('category_id', $category->id)->where('slug', $product_slug)->first();
            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product'=>$product,
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'Product Not Available'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found'
            ]);
        }
    }

}
