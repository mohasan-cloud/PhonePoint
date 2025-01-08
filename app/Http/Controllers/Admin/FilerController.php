<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // Corrected namespace for Image class

class FilerController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the input
        $request->validate([
            'image' => 'required',
            'width' => 'required|integer',
            'height' => 'required|integer',
        ]);

        // Check if files are uploaded
        if ($request->hasFile('image')) {
            // Handle multiple files upload
            if (is_array($request->file('image')) && $request->images_limit > 1) {
                $files = $request->file('image');

                foreach ($files as $file) {
                    $fileName = $this->processFile($file, $request->width, $request->height);
                    $data['single'][] = $fileName; // Store file name for multiple files
                }

                return response()->json($data);
            } 
            // Handle single file upload
            else {
                $file = $request->file('image');
                $fileName = $this->processFile($file, $request->width, $request->height);

                $data['single'] = $fileName; // Store file name for single file
                return response()->json($data);
            }
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    // Helper method to process files
    private function processFile($file, $width, $height)
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName . '_cms_' . time() . '.' . $extension;

        // Define destination paths
        $destinationPath = public_path('/images/thumb');
        
        // Resize and save image if not an ICO or document
        if (!in_array($extension, ['ico', 'pdf', 'doc', 'docx'])) {
            $img = Image::make($file->getRealPath());
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $fileName);
        }

        // Move the original file
        $file->move(public_path('images'), $fileName);

        return $fileName;
    }

    public function fileDestroy(Request $request)
    {
        $filename = $request->get('file');

        // Delete files from different directories
        $this->deleteFile(public_path('images/' . $filename));
        $this->deleteFile(public_path('images/thumb/' . $filename));
        $this->deleteFile(public_path('images/mid/' . $filename));

        return response()->json(['file' => $filename]);
    }

    // Helper method to delete files
    private function deleteFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
