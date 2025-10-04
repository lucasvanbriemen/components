<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index(Request $request)
    {
        $component = $request->path();


        return "test";

        return $this->$component($request);
    }

    public function input($request)
    {
        $type = $request->query('type', 'text');
        $label = $request->query('label', 'Input Label');
        $placeholder = $request->query('placeholder', ' ');
        $value = $request->query('value', '');
        $name = $request->query('name', 'input_name');
        $id = $request->query('id', 'input_id');
        $class = $request->query('class');

        return view('components.input',
            compact('type', 'label', 'placeholder', 'value', 'name', 'id')
        );
    }
}
