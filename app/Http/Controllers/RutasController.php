<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RutasController extends Controller
{
    //buscar las rutas
    public function searchRutas(Request $r){
        $data = DB::table('consulta_ruta')
        ->where('lugar_salida','like','%'.strtoupper($r->origen).'%')
        ->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }

    //Registro de la Rutas
    public function registerRuta(Request $request)
    {
        

        $insert[] = [
            'placa_bus' => $request->placa_bus,
            'lugar_salida' => $request->lugar_salida,
            'lugar_destino'=> $request->lugar_destino,
            'hora'=> $request->hora,
            'precio'=> $request->precio,
            
        ];
        // return $insert;
        //$ip= request()->ip(); esto es web
        $ip='';
        
        $sqlInsert = json_encode($insert);
        $noticia = DB::select('CALL proc_registrar_ruta(?,?)',[$sqlInsert,$ip]);
        
        if ($noticia!='[]') {
            return response()->json(["RES"=>$noticia]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }

    //Ruta para buscar las rutas existentes por el lugar al que se quiere ir
    public function searchRutasbyPlaces(Request $r){
        $data = DB::table('consulta_ruta')
        ->where('lugar_destino','like','%'.strtoupper($r->name).'%')
        ->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }
    //lista de rutas
    public function listRutas(){
        $users = DB::table('consulta_ruta')->get();
        

        return response()->json(["RES"=>$users]);



    }


}
