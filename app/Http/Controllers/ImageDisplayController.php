<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;

class ImageDisplayController extends Controller
{
    public function displayImage($filename) {
    $path = storage_path() . '/app/public/images/' . $filename;

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
    }
}
