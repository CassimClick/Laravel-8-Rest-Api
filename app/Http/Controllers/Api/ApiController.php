<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public $productModel;
    public function __construct()
    {
        $this->productModel = new Products();
    }
    public function createProduct(Request $request)
    {

        //validation
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required',
        ]);

        //create data

        $this->productModel->name = $request->name;
        $this->productModel->desc = $request->desc;
        $this->productModel->price = $request->price;

        $this->productModel->save();

        //send response

        return response()->json([
            'message' => 'Product Added',
        ]);
    }
    public function listProducts()
    {

        $data = $this->productModel->get();

        return response()->json([
            'data' => $data,
        ]);

    }
    public function singleProduct($id)
    {
        if ($this->productModel->where('id', $id)->exists()) {
            return response()->json([
                'data' => $this->productModel->where('id', $id)->get(),
            ]);

        } else {
            return response()->json([
                'message' => 'Product Not Found',
            ]);

        }
    }
    public function updateProduct(Request $request, $id)
    {

        $product = $this->productModel->find($id);

        if ($product) {

            $product->update($request->all());

            return response()->json([
                'message' => 'Product Updated',
                'data' => $product->where('id', $id)->get(),
            ]);

        } else {
            return response()->json([
                'message' => 'Product Not Found',

            ]);

        }
    }
    public function deleteProduct($id)
    {

        $product = $this->productModel->find($id);

        if ($product) {

            $product->delete();

            return response()->json([
                'message' => 'Product Deleted',
                // 'data' => $product->where('id', $id)->get(),
            ]);

        } else {
            return response()->json([
                'message' => 'Product Not Found',

            ]);

        }

    }

    public function searchProduct($name)
    {
        $product = $this->productModel->where('name', 'like', '%' . $name . '%')->get();
        if (count($product) > 0) {

            return response()->json([

                'data' => $product,
            ]);

        } else {
            return response()->json([
                'message' => 'No Product Match  Found',

            ]);

        }

    }
}