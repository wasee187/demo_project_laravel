<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File; 
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\InputFile;
use App\Models\Chunkfile;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files_data = InputFile::all();
        return view('file',['files'=> $files_data]);     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //
    }

    public function contact_file_upload(){
        return view('file_upload');
    }

    function show_contact($id){
        $contact_data = Contact::where('chunk_file_id', $id)->get();
        return view('contact',['contacts'=> $contact_data]);
    }


    public function contact_store(Request $request){
        $file_id ;
        $user_filename = $request->filename;
        $validator = Validator::make($request->all(), [
            // validating file input 
            'file' => 'required|mimes:csv,txt',
            'filename'=> 'required',
            'chunkPoint'=> 'required',
        ]);

        if ($validator->fails()) {
            //redirecting back if error occurred
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();

        }
       
        $file_data = $this->validate_data($request);//validating file data
        $chunk_point = $request->chunkPoint;
        $parts = (array_chunk($file_data,$chunk_point));//chunking array data
        $file_id =$this->get_file_id( $user_filename); //getting current file id from database

        foreach($parts as $index=>$part){//looping chunk data parts

            $total_contact = count($part);

            $chunk_filename = $user_filename."_sample".$index. ".csv"; //creating chunk file name

            $this->save_chunkFile_data($chunk_filename, $index, $file_id, $total_contact);//saving chunk file info in database

            $chunk_file = resource_path('pending-files/'.$chunk_filename); //creating new file for chunk data and saving to pending file folder
            
            file_put_contents($chunk_file,serialize($part)); //saving chunked data to chunk file 

        }//looping chunk data parts end

        $path = resource_path("pending-files/*.csv"); //getting all pending file's resource path
        $files = glob($path);
    
        $this->save_contact_data($files,$file_id); //saving contact data in database

        session()->flash('log_success','Data uploaded successfully!');
        return redirect()->back();
    }

    public function show_chunk_file(Request $request){
        $id = $request->id;
        $chunk_file = Chunkfile::where('file_id',$id)->get();
        return response()->json([
            'chunk_file' => $chunk_file
        ]);
    }

    /********* custom functions ************/ 

    function validate_data($request){
        $user_filename = $request->filename;
        $file = $request->file;
        $destinationPath = 'pending-files/';
        $originalFile = $file->getClientOriginalName();
        $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
        $file->move($destinationPath, $filename);//saving input file in specific folder
    
        $contacts = [];
        if (($open = fopen($destinationPath.$filename, "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {

                $contacts[] = $data;//reading csv file data and saving to an empty array
            }
           fclose($open);
        }

        $contacts_data = array_slice($contacts,1);//slicing file's first header row
        $total_contacts_count = count($contacts_data);//getting total given contact count
        
        $index_contact =[];
        foreach ($contacts as $index=>$contact) {
            //validation of contact data
            $validator = Validator::make($contact, [
                $contact[0]=> 'required',
            ]);
            if ($validator->fails()) {
                $contact = array_slice($contact,$index);//if validation failed row will be excluded
            }else{
                $index_contact[] = $contact; 
            }
        }

        $total_valid_contacts_count = count($index_contact);//getting total valid contact count
        $this->save_file_data($user_filename,$total_contacts_count, $total_valid_contacts_count);//file info saving to database
        File::delete($destinationPath.$filename);
        return $index_contact; //returning the valid data
    } 

    function save_file_data($name,$total_contact, $valid_contact){
        $file = new InputFile;
        $file->name = $name;
        $file->total_uploads = $total_contact;
        $file->total_process = $valid_contact;
        $file->save();
    }

    function save_chunkFile_data($name, $index,$fileId,$total_contact){

        $chunk_file = new Chunkfile;
        $chunk_file->name = $name;
        $chunk_file->index_number = $index;
        $chunk_file->file_id = $fileId;
        $chunk_file->total_contact = $total_contact;
        $chunk_file->save();
    }

    function save_contact_data( $files, $f_id){

        foreach (array_slice($files,0,100) as $index=>$file){
     
            $chunk_file = Chunkfile::where(['index_number'=>$index, 'file_id'=>$f_id])
                                    ->select('id')
                                    ->get();//selecting chunk file id depending on index number

            $data = unserialize(file_get_contents($file)); //extracting data from file
     
            foreach($data as $row){//looping all string value data
                $contact = new Contact;
                $contact->number = $row[0];
                $contact->firstname = $row[1];
                $contact->lastname = $row[2];
                $contact->email = $row[3];
                $contact->state = $row[4];
                $contact->zip = $row[5];
                $contact->file_id = $f_id;
                $contact->chunk_file_id = $chunk_file[0]['id'];
                $contact->save();
            }
            unlink($file);//removing chunk file from pending file folder
        }
    }

    function get_file_id($name){
        $file_id = InputFile::where('name',$name)
                    ->select('id')
                    ->get();
        return $file_id[0]['id'];
    }

}

