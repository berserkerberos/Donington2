<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicios\srvMedico;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class loginController extends Controller
{
    public function login(Request $rq)
    {
        //cerrar sesion
        return view('sitio/login');
    }

    public function logout(Request $rq)
    {
        //cerrar sesion
        Session::put("usuario", null);        
        return redirect()->route('padron.ingreso');
    }

    public function validaUsuario(Request $rq)
    {
        $usu =  strtoupper($rq->input('txUsuario'));
        $pass =  ($rq->input("txPassword"));
        //$pass =  base64_encode($rq->input("txPassword"));
        $usuario =  "";
        if (!empty($usu)) {

            //TODO: implementar
            //$srv = \App\Servicios\srvMedico::valUsuario($usu, $pass);
            $usuario = \App\Models\Usuario::where('nombre', '=', $usu)
            ->where('password', '=', $pass)
            ->get()->first();
        }

        if (!empty($usuario)) {
            //cargo la session            
            Session::put("usuario", $usuario);
            return redirect()->route('padron.inicio');
        } else {
            $resul = ["tipo" => "danger", "mensaje" => "No se identificó al usuario"];
            return back()->with("mensaje", $resul);
        }
    }

    public function inicio(Request $rq)
    {
        return view('home');
    }
   
    public function configUsu(Request $rq)
    {
        $usuario = \Session::get("usuario");                            
        return view('frmConfigUsu', compact("usuario"));
    }

    public function actualizaUsuario(Request $rq)
    {
        $usuario = Session::get("usuario");
        $this->validate($rq, [
			'nombre' => 'required|max:60',
			'nombre_completo' => 'required|max:60',
            'password' => 'required',			
            'confirme_su_password' => 'required|same:password',
			'direccion' => 'required',
			'mail' => 'required',
			'localidad' => 'required',
			'telefono' => 'required',            
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
		]);
        $requestData = $rq->all();
        if ($rq->hasFile('avatar')) {
            $requestData['avatar'] = $rq->file('avatar')->store('uploads', 'public');
        }

        $usuario->update($requestData);        
        $resul = ["tipo" => "success", "mensaje" => "Se actualizaron los datos correctamente"];
        
        return back()->with("mensaje", $resul);
    }
}
