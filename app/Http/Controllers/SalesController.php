<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('upload-file');
    }
    public function upload(Request $request)
    {
        ini_set('memory_limit', '100M');
        if ($request->has('mycsv')) {
            // $data = array_map('str_getcsv', file($request->mycsv));
            $data = file($request->mycsv);
            // $header = $data[0];
            // unset($data[0]);

            // Chunking file 
            $chunks = array_chunk($data, 1000);

            // $dir_path = public_path("temp"); // create dir path if not exists
            $dir_path = resource_path("temp"); // create dir path if not exists
            if (!file_exists($dir_path)) {
                mkdir($dir_path);
            }

            // Convert 1000 records into a new csv file
            foreach ($chunks as $key => $chunk) {
                $file_name = "/tmp{$key}.csv";
                file_put_contents($dir_path . $file_name, $chunk);
            }

            /* foreach ($data as $value) {
                $sales_data = array_combine($header, $value);
                Sales::create($satas_data);
            } */
        }
        return 'done';
    }

    public function store()
    {
        $dir_path = resource_path("temp"); // create dir path if not exists
        $files = glob($dir_path . '/*.csv');

        $header = [];
        foreach ($files as $key => $file) {
            $data = array_map('str_getcsv', file($file));

            if ($key === 0) {
                $header = $data[0];
                unset($data[0]);
            }

            foreach ($data as $sale_data) {
                $sales_data = array_combine($header, $sale_data);
                Sales::create($sales_data);
            }
        }

        return 'stored';
    }
}
