<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SalesCsvProcessJob;
use Illuminate\Support\Facades\Bus;

class SalesController extends Controller
{
    public function index()
    {
        return view('upload-file');
    }
    public function upload(Request $request)
    {
        ini_set('memory_limit', '500M');
        if ($request->has('mycsv')) {
            // $data = array_map('str_getcsv', file($request->mycsv));
            // read data from csv file
            $data = file($request->mycsv);

            // Chunking file 
            $chunks = array_chunk($data, 1000);

            // $dir_path = public_path("temp"); // create dir path if not exists
            // $dir_path = resource_path("temp"); // create dir path if not exists

            /* if (!file_exists($dir_path)) {
                mkdir($dir_path);
            } */

            // Convert 1000 records into a new csv file
            // foreach ($chunks as $key => $chunk) {
            //     $file_name = "/tmp{$key}.csv";
            //     file_put_contents($dir_path . $file_name, $chunk); // upload csv file
            // }

            //  upload csv file
            // $files = glob($dir_path . '/*.csv');

            $header = [];

            $batch = Bus::batch([])->dispatch();

            foreach ($chunks as $key => $file) {
                $data = array_map('str_getcsv', $file);
                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new SalesCsvProcessJob($header, $data));

                // Delete the file after processing
                // unlink($file);
            }
        }
        return $batch;
    }

    public function batch() {
        $batchId = request('id');
        $batch = Bus::findBatch($batchId);
        return $batch;
    }
}
