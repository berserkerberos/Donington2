<?php

namespace App\Http\Middleware;

use App\Helpers\miPrint;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class valPermisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,String $grupo_rol)
    {
        $usuArr = Session::get("usuario");    

        if (!empty($usuArr)) {
            
            $roles = explode("_",$grupo_rol);

            //se validan requerimientos de perfil
            //por el momento solo tiene que tener la firma cargada
            $existe = false;
            /*
            if (empty(strpos($usuArr->med_firmaimg, "public/firma"))){                
                $existe =  file_exists( Storage::path($usuArr->med_firmaimg));                
            }            
            if (!empty(strpos($usuArr->med_firmaimg, "public/firma")) || $existe === false ){                                
                if ( $request->getRequestUri() != "/configUsu" and $request->getRequestUri() != "/actualizaUsuario"){
                    $print =  "Para uso del sistema es necesario que primero, cargue en su perfil una imagen de su firma digitalizada 
                    y además cambie su clave inicial/anterior por una nueva";                    
                    $resul = ["tipo" => "danger", "mensaje" => $print];
                    $request->session()->flash('mensaje', $resul);
                    return redirect("/configUsu");
                }                
            }
            **/
            //se valida el rol segun eñ archivo web config
            // TODO: implementar compo tipo para validar el perfil
            //$tipo =  $usuArr->med_tipo;
            $tipo =  1;
            if( in_array($tipo, $roles)){
                Session::put("mensaje_error", "");
                return $next($request);
            }else{
                $print =  'No cuenta con los permisos necesarios para realizar esta opción!';
                $resul = ["tipo" => "danger", "mensaje" => $print];
                $request->session()->flash('mensaje_error', $resul);                
                return redirect("/msgError");
            }            

        } else {            
            return redirect("/ingreso");
        }
    }
}
