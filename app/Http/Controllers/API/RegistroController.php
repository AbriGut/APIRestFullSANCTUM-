<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Registro;
use App\Http\Resources\Registro as RegistroResource;
   
class RegistroController extends BaseController
{
    public function index()
    {
        $registros = Registro::all();
        return $this->sendResponse(RegistroResource::collection($registros), 'Registros encontrados.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'usuario' => 'required',
            'entrada' => 'required',
            'salida' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $registro = Registro::create($input);
        return $this->sendResponse(new RegistroResource($registro), 'Post Creado.');
    }
   
    public function show($id)
    {
        $registro = Registro::find($id);
        if (is_null($registro)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new RegistroResource($registro), 'Post encontrado.');
    }
    
    public function update(Request $request, Registro $registro)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'usuario' => 'required',
            'entrada' => 'required',
            'salida' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $registro->usuario = $input['usuario'];
        $registro->entrada = $input['entrada'];
        $registro->salida = $input['salida'];
        $registro->save();
        
        return $this->sendResponse(new RegistroResource($registro), 'Post updated.');
    }
   
    public function destroy(Registro $registro)
    {
        $registro->delete();
        return $this->sendResponse([], 'Registro Borrado.');
    }
}