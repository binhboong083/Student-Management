<?php

namespace App\Http\Services;

use Exception;

class UploadService
{
    public function store($request, &$message)
    {
        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $maxSize = 5 * 1024 * 1024; // Giới hạn dung lượng là 5MB

                if (!in_array($extension, $allowedExtensions)) {
                    throw new Exception('Định dạng tệp tin không hợp lệ.');
                }

                if ($file->getSize() > $maxSize) {
                    throw new Exception('Dung lượng tệp tin vượt quá giới hạn cho phép.');
                }

                $pathFull = 'uploads/' . date('Y/m/d');

                $request->file('file')->storeAs(
                    'public/' . $pathFull,
                    $name
                );

                return '/storage/' . $pathFull . '/' . $name;
            } catch (Exception $error) {
                $message = $error->getMessage();
                return false;
            }
        }
    }
}
