<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function index()
    {
        $categorie = Categorie::latest()->simplePaginate(5);
        return response()->json(
            [
                'status' => 'OK',
                'data' => [
                    'categories' => $categorie->toArray()['data'],
                    'paginate' => collect($categorie->toArray())->except('data')
                ]
            ]
        );
    }

    public function store(Request $request)
    {
        $rule = [
            'name' => 'required|unique:categories,name'
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

        $categorie = Categorie::create(
            ['name' => $request->name]
        );

        return response()->json([
            'status' => 'OK',
            'data' => ['categories' => $categorie->fresh()]
        ]);
    }

    public function show($category)
    {
        $find = Categorie::find($category);

        if (!$find) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => 'Data Not Found']
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'data' => ['categories' => $find]
        ]);
    }

    public function update(Request $request, $category)
    {

        $find = Categorie::find($category);

        if (!$find) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => 'Data Not Found']
            ]);
        }

        $rule = [
            'name' => 'required|unique:categories,name,' . $find->id
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

        $find->update(['name' => $request->name]);

        return response()->json([
            'status' => 'OK',
            'data' => ['categories' => $find->fresh()]
        ]);
    }

    public function destroy($categorie)
    {
        $find = Categorie::find($categorie);

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
