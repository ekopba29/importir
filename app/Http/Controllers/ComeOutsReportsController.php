<?php

namespace App\Http\Controllers;

use App\Models\Come;
use App\Models\ComeOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComeOutsReportsController extends Controller
{
    public function daily(Request $request)
    {
        $rule = [
            'date' => 'required|date_format:Y-m-d'
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

        return response()->json([
            'status' => 'OK',
            'data' => ['reports' => ComeOut::filterDaily($request->date)->get()]
        ]);
    }

    public function weekly(Request $request)
    {
        return response()->json(['status' => 'NOK', 'validation' => ['error' => 'Not finish yet']]);
    }

    public function monthly(Request $request)
    {
        $rule = [
            'month' => 'required|date_format:m',
            'year' => 'required|date_format:Y'
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

        return response()->json([
            'status' => 'OK',
            'data' => ['reports' => ComeOut::filterMonthly($request->month, $request->year)->get()]
        ]);
    }

    public function yearly(Request $request)
    {
        $rule = [
            'year' => 'required|date_format:Y'
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

        return response()->json([
            'status' => 'OK',
            'data' => ['reports' => ComeOut::filterYearly($request->year)->get()]
        ]);
    }
}
