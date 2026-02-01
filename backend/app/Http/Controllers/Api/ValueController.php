<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Value;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function index()
    {
        return response()->json(Value::all());
    }
}
