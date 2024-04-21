<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\DataModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
// use App\Exports\ArrayExport;
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;


use Validator;
use Session;
use Config;

class DataController extends Controller
{
    public function __construct(DataModel $DataModel)
    {
        $data               = [];
      
    }
    
    public function add()
    {
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:json',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

       

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $contents = file_get_contents($file->path());

            $dataArray = json_decode($contents,true);

            // $keysWithId = array_keys(array_column($dataArray, "id"));
            $newArray = $this->findIds($dataArray);
            // dd($idKeys);
            $idKeys = array_unique($newArray);
            $csvFile = public_path('files\New-Data.csv');
            $csvHandle = fopen($csvFile,'w');

            foreach($idKeys as $item){
                DataModel::create(['id_data'=>$item]);
                fputcsv($csvHandle,[$item]);

                
            }

            

            fclose($csvHandle);
            // $this->export($idKeys);
           
            // $ExcelCreated = Excel::download(new ArrayExport($idKeys),'data.xlsx');
        }
        
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('/');
        
    }

     public function findIds($dataArray){

        $ids = [];
            foreach($dataArray as $key=>$value){
                if($key === "id"){
                    $ids[] = $value;
                }elseif(is_array($value)){
                    $ids = array_merge($ids,$this->findIds($value));
                }
            }
            return $ids;
     }

     public function export($array){
        // dd($array);
        $csvFile = tempnam(sys_get_temp_dir(),'export');

        // $csvFile = public_path('files\Tempexport.xlsx');

        $csvHandle = fopen($csvFile,'w');
        // foreach($array as $item){
            fputcsv($csvHandle,$array);  

        // }

        fclose($csvHandle);

            
        // $excelFile = tempnam(sys_get_temp_dir(),'export').'xlsx';

        $excelFile = public_path('files\export.csv');
        $excelHandle = fopen($excelFile,'w');

        $new = fwrite($excelHandle,file_get_contents($csvFile));
        fclose($excelHandle);
        // dd($excelFile);


        unlink($csvFile);
        return Response::download($excelFile,'export.xlsx');


     }

     
}
