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
        $type = $request->input('type', 'text');
        $label = $request->input('label', 'Input Label');
        $placeholder = $request->input('placeholder', ' ');
        $value = $request->input('value', '');
        $name = $request->input('name', 'input_name');
        $id = $request->input('id', 'input_id');
        $class = $request->input('class', null);
        
        return view('components.input',
            compact('type', 'label', 'placeholder', 'value', 'name', 'id', 'class')
        );
    }
}
