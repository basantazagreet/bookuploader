<?php

namespace App\Http\Controllers;

use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfParser\PdfParser;
use setasign\Fpdi\PdfReader;
use App\Product;
use App\ProductsPdf;
use App\Http\Requests\PdfRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    function uploadSubmit(PdfRequest $request){

        //Setting messages for four checklist
        $return_messages = array('page_count' => true,
        'empty_pages' => true, 'size_match' => true, 'safe_margin' => true);
        $has_error = false;
     
        $file = $request->file('pdf_file');

        // Check if the file exists and is a valid PDF file
        if ($request->hasFile('pdf_file') && $file && $file->isValid() && strtolower($file->getClientOriginalExtension()) == 'pdf') {
            
            //A4 paper height and width in pdf points
            $paper_height = 841.68;
            $paper_width = 595.44;

            $filePath = $request->file('pdf_file')->path();

            // Parse PDF file and build necessary objects.
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($filePath);
            $pages = $pdf->getPages();

            //1) To get page count and check for even number of pages
            $pagecount = $pdf->getDetails()['Pages'];

            if ($pagecount % 2 != 0) {
                $has_error = true;
                $return_messages['page_count'] = false;
            }

            //2) To check for blank pages in 2nd and 2nd last pages
            

            if($pagecount <= 2)
            {
                // If less than 2 pages, checking finished
                $return_messages['empty_pages'] = false;
                $has_error = true;
            } else {

                //Using mediabox to find height and width
                $second_page = $pages[1];
                $second_last_page = $pages[$pagecount-2];

                $sp_mediabox = $second_page->getDetails()['MediaBox'];
                $slp_mediabox = $second_last_page->getDetails()['MediaBox'];


                //getTextXY(x,y, x-offset, y-offset) Checking if there are texts in that region. width and height used as offset
    
                if (!$this->isTextsEmpty($second_page->getTextXY(0, 0, $sp_mediabox[2], $sp_mediabox[2])) || 
                !$this->isTextsEmpty($second_last_page->getTextXY(0, 0, $slp_mediabox[2], $slp_mediabox[2]))){
                    $return_messages['empty_pages'] = false;
                    $has_error = true;
                }
            }
            foreach ($pages as $page) {
                $mediabox = $page->getDetails()['MediaBox'];

                //getting width and height of each page
                $width = $mediabox[2];
                $height = $mediabox[3];

                //checking height and width with uncertainty 1 points
                if (abs($paper_height - $height) > 1 || abs($paper_width - $width) > 1) {
                    $return_messages['size_match'] = false;
                    $has_error = true;
                }
                // safe_margin is 1.5 cm and 1 inch = 72 points which means its 42.5 points;
                $safe_margin = 42.5;

                //getTextXY(x,y, x-offset, y-offset) Checking if there are texts in that region.
                //42.5 used as offset to create rectangles to see if any texts are there
                $has_left_margin = $this->isTextsEmpty($page->getTextXY(0, null, $safe_margin, 0));
                $has_top_margin = $this->isTextsEmpty($page->getTextXY(null, $height, 0, $safe_margin));
                $has_right_margin = $this->isTextsEmpty($page->getTextXY($width, null, $safe_margin, 0));
                $has_bottom_margin = $this->isTextsEmpty($page->getTextXY(null, 0, 0, $safe_margin));

                $has_safe_margin = $has_left_margin && $has_top_margin && $has_right_margin && $has_bottom_margin;
                
                //if all four regions are empty, margin is safe
                if (!$has_safe_margin) {
                    $return_messages['safe_margin'] = false;
                    $has_error = true;
                }
            }
        }
     return response()->json(['status' => $has_error ? 'error' : 'success', 'checklist' => $return_messages]);

        
    }

    //Checking for empty spaces
    function isTextsEmpty(array $lines) : bool{
        $is_empty = true;
        foreach ($lines as $line){
            $text = trim($line[1]);
            if ($text != ''){
                return false;
            }
        }
        return true;
    }

    function checkIfPageEmpty(int $pageNumber) : bool{

    }


}



