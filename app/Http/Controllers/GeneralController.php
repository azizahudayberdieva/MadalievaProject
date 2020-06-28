<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {
        dd(111);
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);

        switch ($request->type) {
            case 'video':
                echo "i равно 0";
                break;
            case 'file':
                echo "i равно 1";
                break;
            default:
                echo "Error type file uploading";
                break;
        }


    }

    public function upload(Request $request)
    {
        $file = $request->file('upload');

        $fileName =  $file->getFilename().'.' .$file->getClientOriginalExtension();
        $file->storeAs('public/files',  $fileName);

        $file = new File;
        $file->name = $file->getFilename();
        $file->source = '/files/' . $fileName;
        $file->extension = $file->getClientOriginalExtension();
        $file->size = $file->getSize();

        $file->save();

        return redirect(route('units.show', $request->unit_id));
    }
}
