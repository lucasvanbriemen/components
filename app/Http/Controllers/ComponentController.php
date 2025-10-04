<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index(Request $request)
    {
        $component = $request->path();

        return $this->$component($request);
    }
    
    public function input($request)
    {
        
        return view('components.input',
            compact('request')
        );
    }
}
