<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    public function index()
    {
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }
    public function store(Request $request)
    {

        $validator  = Validator::make($request->all(), [
            'meta_title' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'slug' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {

            $category = new Category();

            $data = $request->all();
            $data['status'] = $request->status == 'on' ? '1':'0';

            $category->create($data);

            return response()->json([
                'status' => 200,
                'message' => 'Category Added Successfully.'
            ]);
        }
    }
}
