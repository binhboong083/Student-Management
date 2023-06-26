<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }

    public function store(Request $request)
    {
        //dd($request->file());
        $message = '';
        $url = $this->upload->store($request, $message);
        if ($url !== false) {
            return response()->json([
                'error' => false,
                'url' => $url,
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => $message,
        ]);
    }
}
