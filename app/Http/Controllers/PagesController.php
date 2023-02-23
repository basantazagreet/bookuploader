<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\PdfParser\PdfParser;
use setasign\Fpdi\Tcpdf\Fpdi;

class PagesController extends Controller
{
    //
    public function checkPages(Request $request){

        $file = $request->file('pdf');
    
        // Save the file to a temporary location on disk
        $path = $file->store('tmp');
    
        // Instantiate the PDF parser
        $parser = new PdfParser(storage_path('app/' . $path));
    
        // Get the number of pages in the PDF file
        $num_pages = $parser->getPageCount();
    
        // Check if the number of pages is even or odd
        if ($num_pages % 2 == 0) {
            // The number of pages is even
            echo "The uploaded PDF has an even number of pages.";
        } else {
            // The number of pages is odd
            echo "The uploaded PDF has an odd number of pages.";
        }
    
        // Delete the temporary file from disk
        Storage::delete($path);
    
        }


}
