<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\File;

class FileUpload extends Controller
{
  public function createForm(){
    return view('file-upload');
  }

  public function fileUpload(Request $req){
      $fileinfo = explode('.', $_FILES['file']['name']);
      if($fileinfo[count($fileinfo) - 1] != 'csv') {
        return back()->with('error','File is not csv file.');
      }
        // $fileModel = new File;

        // if($req->file()) {
        //     $fileName = time().'_'.$req->file->getClientOriginalName();
        //     $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

        //     $fileModel->name = time().'_'.$req->file->getClientOriginalName();
        //     $fileModel->file_path = '/storage/' . $filePath;
        //     $fileModel->save();

        //   }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
        //   return back()
        //   ->with('success','File has been uploaded.')
        //   ->with('file', $fileName);
   }

}