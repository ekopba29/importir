<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('id', 'desc')->with(['product_categories' => function ($query) {
            return $query;
        }])->simplePaginate(5);
        return response()->json(
            [
                'status' => 'OK',
                'data' => [
                    'products' => $product->toArray()['data'],
                    'paginate' => collect($product->toArray())->except('data')
                ]
            ]
        );
    }

    public function store(Request $request)
    {
        $rule = [
            'name' => 'required|unique:products,name',
            'unit' => 'required',
        ];

        $validation = Validator::make(
            $request->all(),
            $rule
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => $validation->errors()]
            ]);
        }

        $product = Product::create(
            [
                'name' => $request->name,
                'unit' => $request->unit
            ]
        );

        $categorie = collect($request->categorie)->map(function ($categorie) use ($product) {
            return new ProductCategorie(['categorie_id' => $categorie, 'product_id' => $product->id]);
        });

        $product->product_categories()->saveMany($categorie);

        return response()->json([
            'status' => 'OK',
            'data' => ['products' => $product->fresh()]
        ]);
    }

    public function show($category)
    {
        $find = Product::orderBy('id', 'desc')->with('product_categories')->find($category);

        if (!$find) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => 'Data Not Found']
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'data' => ['products' => $find]
        ]);
    }

    public function update(Request $request, $category)
    {

        $find = Product::find($category);

        if (!$find) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => 'Data Not Found']
            ]);
        }

        $rule = [
            'name' => 'required|unique:products,name,' . $find->id,
            'unit' => 'required',
            'total' => 'required|integer'
        ];

        $validation = Validator::make(
            $request->all(),
            $rule
        );


        if ($validation->fails()) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => $validation->errors()]
            ]);
        }

        $find->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'total' => $request->total
        ]);


        $categorie = collect($request->categorie)->map(function ($categorie) use ($find) {
            return new ProductCategorie(['categorie_id' => $categorie, 'product_id' => $find->id]);
        });

        ProductCategorie::where('product_id', $find->id)->delete();

        $find->product_categories()->saveMany($categorie);

        return response()->json([
            'status' => 'OK',
            'data' => ['products' => $find->fresh()]
        ]);
    }

    public function destroy($product)
    {
        $find = Product::find($product);

        if (!$find) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => 'Data Not Found']
            ]);
        }

        if ($find->delete()) {
            return response()->json([
                'status' => 'OK',
            ]);
        }

        return response()->json([
            'status' => 'NOK',
            'error' => ['validation' => 'Data Not Found']
        ]);
    }
}
