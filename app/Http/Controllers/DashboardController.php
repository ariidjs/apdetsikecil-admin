<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\GrowAnak;
use App\Models\IdentitasAnak;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Throwable;

class DashboardController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
        
            // return dd($response);
            $data = Anak::get();
    
        return view('layouts.dashboard', [
            "title" => "Dashboard",
            "data" => $data]);
            
        } catch (Throwable $exception) {
            // return $exception;

            // return view('layouts.driver.index');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function ExportExcel($data,$nik){
        ob_start();
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($data);
            $excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$nik.'_pertumbuhan_anak.xls');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function exportData($nik){
        $data = GrowAnak::wherenik($nik)->orderBy('created_at', 'ASC')->get();
        $idennama = IdentitasAnak::wherenik($nik)->first();
        $data_array [] = array("Nama","Tanggal Pengukuran","Tempat Pengukuran","Tinggi Badan","Berat Badan","Lingkar Kepala","Lingkar Lengan");
        
        foreach($data as $data_item)
        {
            $data_array[] = array(
                'Nama' =>$idennama->nama,
                'Tanggal Pengukuran' => $data_item->tgl_ukur,
                'Tempat Pengukuran' => $data_item->tmpt_ukur,
                'Tinggi Badan' => $data_item->tinggi,
                'Berat Badan' => $data_item->berat,
                'Lingkar Kepala' =>$data_item->lingkar_kepala,
                'Lingkar Lengan' =>$data_item->lingkar_lengan
            );
        }
        $this->ExportExcel($data_array,$nik);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // try {
        //     $response =  json_decode($this->successResponse($this
        //         ->serviceAPi
        //         ->getDriver($id))
        //         ->original, true);

        //         // return dd($response);
        //     if ($response['success']) {
        //         return view('layouts.driver.detail', [
        //             "title" => "Detail Driver",
        //              "driver" => $response["driver"],
        //              "transaction" => $response["transaction"],
        //         ]);
        //     }
        // } catch (Throwable $exception) {
        //     return view('layouts.error.index',["title" => "Customer"]);
        //     // return $exception;
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $driver = $this->getDriver($id);
        // return dd($driver);
        // return response()->json([
        //     "name_driver"=>$request->nameDriver,
        //     "email"=>$request->nameDriver,
        //     "nomor_stnk"=>$request->nomorstnk,
        //     "plat_kendaraan"=>$request->nomor_kendaraan,
        //     "phone"=>$request->nohp,
        // ],201);
        // if ($driver) {
        //     $driver["name_driver"] = $request->nameDriver;
        //     $driver["email"] = $request->email;
        //     $driver["nomor_stnk"] = $request->nomorstnk;
        //     $driver["nik"] = $request->nik;
        //     $driver["plat_kendaraan"] = $request->nomor_kendaraan;
        //     $driver["phone"] = $request->nohp;

        //     try {
        //         $response =  json_decode($this->successResponse($this
        //             ->serviceAPi
        //             ->updatedDriver($driver, $id))
        //             ->original, true);

        //         if ($response["success"]) {
        //             return redirect('drivers');
        //         }
        //     } catch (Throwable $exception) {
        //         return $exception;
        //         if ($exception instanceof ClientException) {
        //             $message = $exception->getResponse()->getBody();
        //             $code = $exception->getCode();
        //             $erorResponse = json_decode($this->errorMessage($message, $code)->original, true);
        //             return var_dump($erorResponse);
        //             // return back()->with('loginError', $erorResponse["message"]);
        //         } else {
        //             // return back()->with('loginError', "Check your connection");
        //         }
        //     }
        // }
    }

    public function getDriver($id)
    {
        // try {
        //     $response =  json_decode($this->successResponse($this
        //         ->serviceAPi
        //         ->getDriver($id))
        //         ->original, true);
        //     return $response["driver"];
        // } catch (Throwable $e) {
        //     return null;
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
