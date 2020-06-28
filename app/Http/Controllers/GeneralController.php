<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {

        return view('formPage');
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);
        $this->upload($request, $request->type);

        return redirect(route('mainPage'));
    }

    public function home()
    {
        return view('welcome');
    }

    public function upload(Request $request, $type)
    {
        $file = $request->file('upload');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public/files', $fileName);
        $file = new File;
        $file->name = $this->unifier($fileName);
        $file->source = '/files/' . $fileName;
        $file->extension = $request->file('upload')->getClientOriginalExtension();
        $file->size = $request->file('upload')->getSize() / 1024; //KiloBytes
        $file->save();
    }

    public function unifier($string)
    {
        $res = explode('.', $string);
        return $res[0].date(now()).'.'.$res[1];
    }
}
