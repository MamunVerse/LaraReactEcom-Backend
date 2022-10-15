<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function allcategory()
    {
        $category = Category::where('status','1')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }


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
            $data['status'] = (int)$request->status;

            $category->create($data);

            return response()->json([
                'status' => 200,
                'message' => 'Category Added Successfully.'
            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'error' => 'Category Not Found'
            ]);
        }
    }

    public function update(Request $request, $id)
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
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $category = Category::find($id);
            if ($category) {

                $data = $request->all();
                $data['status'] = (int)$request->status;

                $category->update($data);

                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Category Not ID Found',
                ]);
            }
        }
    }

    public function delete($id){
        $category = Category::where('id', $id)->first();

        if ($category) {

            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => "Category Deleted Successfully"
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'error' => 'Category Not Found'
            ]);
        }
    }
}
