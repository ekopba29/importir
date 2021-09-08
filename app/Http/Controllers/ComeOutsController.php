<?php

namespace App\Http\Controllers;

use App\Models\ComeOut;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComeOutsController extends Controller
{
    public function store(Request $request)
    {
        $rule = [
            'product_id' => 'required|exists:products,id',
            'total' => 'required|integer',
            'unit_price' => 'required|integer',
            'date_out' => 'required|date_format:Y-m-d H:i'
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


        $come = ComeOut::create(
            [
                'product_id' => $request->product_id,
                'total' => $request->total,
                'unit_price' => $request->unit_price,
                'price' => $request->unit_price * $request->total,
                'date_out' => $request->date_out
            ]
        );

        $product = Product::find($request->product_id);
        $product->update(['total' => $product->total - $request->total]);

        return response()->json([
            'status' => 'OK',
            'data' => ['come' => $come]
        ]);
    }

    public function update(Request $request, $come)
    {
        $find = ComeOut::find($come);

        if (!$find) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => 'Data Not Found']
            ]);
        }

        $rule = [
            'product_id' => 'required|exists:products,id',
            'total' => 'required|integer',
            'unit_price' => 'required|integer',
            'date_out' => 'required|date_format:Y-m-d H:i'
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
            'total' => $request->total,
            'unit_price' => $request->unit_price,
            'price' => $request->unit_price * $request->total,
            'date_out' => $request->date_out
        ]);

        return response()->json([
            'status' => 'OK',
            'data' => ['comes' => $find->fresh()]
        ]);
    }

    public function destroy($come)
    {
        $find = ComeOut::find($come);

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
            'error' => ['validation' => 'Err']
        ]);
    }
}
