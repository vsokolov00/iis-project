<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;
use App\Models\Image;
use Storage;

class ImageDisplayController extends Controller
{
    public function displayImage($filename) {
        return  Storage::disk('local')->response("public/storage/images/empty.png");
        // if (Storage::disk('local')->has("public/images/" . $filename)) {
        //     return  Storage::disk('local')->response("public/images/" . $filename);
        // }
        // if (Storage::disk('s3')->has("public/images/" . $filename)) {
        //     $s3_file = Storage::disk('s3')->get("public/images/" . $filename);
        //     $local_storage = Storage::disk('local');
        //     $local_storage->put("public/images/" . $filename, $s3_file);
        //     return  Storage::disk('s3')->response("public/images/" . $filename);
        // } else {
        //     return  Storage::disk('s3')->response("public/images/empty.png");
        // }
    }
}
