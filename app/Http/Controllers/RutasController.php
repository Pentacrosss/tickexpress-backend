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
        ->where('lugar_salida','like','%'.strtoupper($r->origen).'%')->where('lugar_destino','like','%'.strtoupper($r->destino).'%')
        ->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }

    //devolver los buses
    public function buses(Request $r){
        $data = DB::table('view_bus')->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }
    //devolver las coperativas
    public function cooperativas(Request $r){
        $data = DB::table('consultar_coperativas')->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }

    //devolver todos los datos de los buses
    public function listBuses(Request $r){
        $data = DB::table('consultar_buses')->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }
    //devolver las coperativas
    public function listLugares(Request $r){
        $data = DB::table('consultar_lugares')->get();
        if ($data!='[]') {
            return response()->json(["RES"=>$data]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }


    //Registro de la Rutas
    public function registerRuta(Request $request)
    {
        

        // $insert[] = [
        //     'placa_bus' => $request->placa_bus,
        //     'lugar_salida' => $request->lugar_salida,
        //     'lugar_destino'=> $request->lugar_destino,
        //     'hora'=> $request->hora,
        //     'precio'=> $request->precio,
            
        // ];
        $insert = (object)array();
        $insert->placa_bus = $request->placa_bus;
        $insert->lugar_salida = $request->lugar_salida;
        $insert->lugar_destino = $request->lugar_destino;
        $insert->hora = $request->hora;
        $insert->precio = $request->precio;
        // return $insert;
        //$ip= request()->ip(); esto es web
        $ip='';
        
        $sqlInsert = json_encode($insert);
        $noticia = DB::select('call proc_registrar_ruta(?,?)',[$sqlInsert,$ip]);
        
        if ($noticia!='[]') {
            return response()->json(["RES"=>$noticia]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }
        //registrar los usuaarios
    public function registerUser(Request $request)
    {
        

        // $insert[] = [
        //     'placa_bus' => $request->placa_bus,
        //     'lugar_salida' => $request->lugar_salida,
        //     'lugar_destino'=> $request->lugar_destino,
        //     'hora'=> $request->hora,
        //     'precio'=> $request->precio,
            
        // ];
        $insert = (object)array();
        $insert->id= $request->id;
        $insert->nombre = $request->nombre;
        $insert->email = $request->email;
        $insert->password = $request->password;
        $insert->telefono = $request->telefono;
        $insert->direccion = $request->direccion;
        // return $insert;
        //$ip= request()->ip(); esto es web
        
        $sqlInsert = json_encode($insert);
        $noticia = DB::select('call registrar_cliente(?)',[$sqlInsert]);
        
        if ($noticia!='[]') {
            return response()->json(["RES"=>$noticia]);
        } else {
            return response()->json(["RES"=>false]);
        }
    }

     //registrar los buses
     public function registerBuses(Request $request)
     {
         
 
        
         $insert = (object)array();
         $insert->placa= $request->placa;
         $insert->numero_bus = $request->numero_bus;
         $insert->tipo = $request->tipo;
         $insert->n_asientos = $request->n_asientos;
         $insert->id_coperativa = $request->id_coperativa;
         
         // return $insert;
         //$ip= request()->ip(); esto es web
         
         $sqlInsert = json_encode($insert);
         $noticia = DB::select('call registrar_bus(?)',[$sqlInsert]);
         
         if ($noticia!='[]') {
             return response()->json(["RES"=>$noticia]);
         } else {
             return response()->json(["RES"=>false]);
         }
     }

     //registrar destinos
     public function registerDestinos(Request $request)
     {
         
 
        
         $insert = (object)array();
         $insert->lugar= $request->lugar;
         
         
         // return $insert;
         //$ip= request()->ip(); esto es web
         
         $sqlInsert = json_encode($insert);
         $noticia = DB::select('call registrar_destinos(?)',[$sqlInsert]);
         
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

    
    //fnion para el login
    public function login(Request $request)
    {
        // return response()->json($request);
        $logi = DB::table('login')->where('correo',$request->email)->get();
        //empty
        // return response()->json($logi);
        if ($logi=='[]') {
            return response()->json(["RES"=>false]);
        }else{
            // return $logi[0]->pass;
            if($request->pass == $logi[0]->contraseña){
                return  response()->json(["RES"=>[
                        'id'   =>      $logi[0]->cedula,            
                        'nombres'=>      $logi[0]->nombres,
                        'email'=>      $logi[0]->correo,
                        'direccion'=>   $logi[0]->direccion,
                        'telefono'=>   $logi[0]->telefono,
                        'password'=>   $logi[0]->contraseña,
                        
                    ]
                ]);    
            } else {
                return response()->json(["RES"=>false]);
            }
        
        }
    }


}
