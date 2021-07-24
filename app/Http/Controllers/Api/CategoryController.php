<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $categories = Category::query()
            ->select('name as category', 'parent_category_id as parent_category')
            ->where(['user_id' => $user->id, 'is_deleted' => 0])
            ->get()
            ->toArray();

        $finalArray = [];
        foreach ($categories as $category) {

            if ($category['parent_category']) {
                $category['parent_category'] = Category::where('id', $category['parent_category'])->value('name');
            }
            array_push($finalArray, $category);
        }

        return response()->json(['type' => 'Success', 'categories' => $finalArray]);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name,NULL,id,is_deleted,0'
        ]);

        $data = [
            'user_id' => $user->id,
            'name' => $request->name
        ];

        if (isset($request->parent_category_id)) {
            $data['parent_category_id'] = $request->parent_category_id;
        }

        $category = Category::create($data);

        if ($category) {
            return response()->json(['type' => 'Success', 'message' => 'Category was added successfully.']);
        } else {
            return response()->json(['type' => 'Error', 'message' => 'We are currently unable to save the given data, Please try again after some time.']);
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'name' => 'required|unique:categories',
        ]);
        $category = Category::where('user_id', $user->id)->find($id);

        if ($category) {
            $category->name = $request->name;
            $category->parent_category_id = $request->parent_category_id;

            $category->save();

            return response()->json(['type' => 'Success', 'message' => 'The category was udpated successfully.']);
        } else {
            return response()->json(['type' => 'Error', 'message' => 'The product does not exists.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $category = Category::where('user_id', $user->id)->find($id);
        if ($category) {
            $category->is_deleted = 1;
            $category->save();

            return response()->json(['type' => 'Success', 'message' => 'The category was deleted successfully.']);
        } else {
            return response()->json(['type' => 'Error', 'message' => 'The category does not exists.']);
        }
    }
}
