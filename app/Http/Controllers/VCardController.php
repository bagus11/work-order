<?php

namespace App\Http\Controllers;

use App\Models\VcardModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use \Mpdf\Mpdf as PDF;
use Spatie\Browsershot\Browsershot;
class VCardController extends Controller
{
    function index() {
        return view('v_card.v_card-index');
    }

    function getCard(Request $request) {
        $data = VcardModel::with([
            'userRelation',
            'userRelation.departmentRelation',
            'userRelation.locationRelation',

        ])->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                    <i class="fas fa-edit"></i>
                    </button>';
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>';
                    $return =
                    ' '
                    .$printBtn ;
                    return $return;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }

    // function generateCard($nik) {
    //     try {
    //         ini_set('memory_limit', '1024M');
    //         $employee = VcardModel::with([
    //                     'userRelation',
    //                     'userRelation.departmentRelation',
    //                     'userRelation.locationRelation',
            
    //                     ])->where('nik', $nik)->first();
    //             $data = [
    //                 'employee'=> $employee
    //             ];
    //             $cetak              = view('v_card.modal.employee_card',$data);        
    //             $mpdf           = new PDF();
    //             $mpdf->AddPage(
    //                 'P', // L - landscape, P - portrait 
    //                 '',
    //                 '',
    //                 '',
    //                 '',
    //                 5, // margin_left
    //                 5, // margin right
    //                 25, // margin top
    //                 20, // margin bottom
    //                 5, // margin header
    //                 5
    //             ); // margin footer
    //             $mpdf->WriteHTML($cetak);
    //             // Output a PDF file directly to the browser
    //             ob_clean();
    //             $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');

    //     } catch (\Mpdf\MpdfException $e) {
    //         // Process the exception, log, print etc.
    //         echo $e->getMessage();
    //     }
    // }

    function generateCard($nik) {
        try {
            ini_set('memory_limit', '1024M');
    
            // Fetch employee data
            $employee = VcardModel::with([
                'userRelation',
                'userRelation.departmentRelation',
                'userRelation.locationRelation',
            ])->where('nik', $nik)->first();
    
            $data = [
                'employee' => $employee,
            ];
    
            // Render the HTML content for the card
            $htmlContent = view('v_card.modal.employee_card', $data)->render();
    
            // Create the PDF using mPDF
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($htmlContent);
    
            // Save the PDF to a temporary file
            $pdfFilePath = tempnam(sys_get_temp_dir(), 'card') . '.pdf';
            $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);
    
            // Use Imagick to convert the PDF to PNG
            $imagick = new \Imagick();
            $imagick->setResolution(300, 300); // High resolution for quality
            $imagick->readImage($pdfFilePath); // Read the PDF file
            $imagick->setImageFormat('png');  // Set the output format to PNG
    
            // Output the PNG to the browser
            header('Content-Type: image/png');
            echo $imagick;
    
            // Clean up temporary files
            unlink($pdfFilePath);
    
        } catch (\Mpdf\MpdfException $e) {
            echo "mPDF Error: " . $e->getMessage();
        } catch (\ImagickException $e) {
            echo "Imagick Error: " . $e->getMessage();
        } catch (\Exception $e) {
            echo "General Error: " . $e->getMessage();
        }
    }
    
 
}
