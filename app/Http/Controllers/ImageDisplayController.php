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
        if (Storage::disk('s3')->has("public/images/" . $filename)) {
            return  Storage::disk('s3')->response("public/images/" . $filename);
        } else {
            return  Storage::disk('s3')->response("public/images/empty.png");
        }
    }
}
