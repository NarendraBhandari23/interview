<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Models\Category;
use App\Models\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $products = Product::query()
            ->where(['user_id' => $user->id, 'is_deleted' => 0])
            ->get()
            ->toArray();

        return response()->json(['type' => 'Success', 'products' => $products]);
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
            'name' => 'required|unique:products,name,NULL,id,is_deleted,0',
            'price' => 'required|integer'
        ]);

        // Category Ids to be stored in comma separated format, Request to send an array in request.
        $data = [
            'user_id' => $user->id,
            'name' => $request->name,
            'category_ids' => implode(', ', $request->category_ids),
            'price' => $request->price
        ];

        $product = Product::create($data);

        if ($product) {
            return response()->json(['type' => 'Success', 'message' => 'Product was added successfully.']);
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
            'name' => 'required|unique:products',
            'price' => 'required|integer'
        ]);

        $product = Product::where('user_id', $user->id)->find($id);

        if ($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_ids = implode(', ', $request->category_ids);

            $product->save();

            return response()->json(['type' => 'Success', 'message' => 'The product was udpated successfully.']);
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

        $product = Product::where('user_id', $user->id)->find($id);
        if ($product) {
            $product->is_deleted = 1;
            $product->save();

            return response()->json(['type' => 'Success', 'message' => 'The product was deleted successfully.']);
        } else {
            return response()->json(['type' => 'Error', 'message' => 'The product does not exists.']);
        }
    }
}
