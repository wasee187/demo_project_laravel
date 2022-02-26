<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Models\File;

class ContactController extends Controller
{
    function show($name){
        $contact_data = Contact::where('file_name', $name)->get();
        return view('contact',['contacts'=> $contact_data]);
    }

    function create(){
        return view('file_upload');
    }

    
    function store(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
            'filename'=> 'required'
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();

        }
        $filename = $request->filename;

        //************ file name saving to database************* */
        $file = new File;
        $file->name = $filename;
        $file->save();

        $file = file($request->file->getRealPath());
        $data = array_slice($file,1);
        
        $parts = (array_chunk($data,5));
        foreach($parts as $index=>$part){
            $chunk_filename = resource_path('pending-files/'.$request->filename."sample".$index. ".csv");
            file_put_contents($chunk_filename,$part);
        }

        $path = resource_path("pending-files/*.csv");

        $files = glob($path);

        foreach (array_slice($files,0,100) as $file){

            $data = array_map('str_getcsv',file($file));

            foreach($data as $row){
                $contact = new Contact;
                $contact->number = $row[0];
                $contact->firstname = $row[1];
                $contact->lastname = $row[2];
                $contact->email = $row[3];
                $contact->state = $row[4];
                $contact->zip = $row[5];
                $contact->file_name =  $filename;
                $contact->save();
            }
            unlink($file);
        }
        session()->flash('log_success','Data uploaded successfully!');
        return redirect()->back();
    }

}
