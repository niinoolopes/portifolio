<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MotivoCancelamento;

class Controller_config_motivoCencelamento extends Controller
{
    public function index()
    {
        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['motivos'] = MotivoCancelamento::all();

        $this->dados['titulo'] = 'Config Motivo cancelamento';

        return view('pages.config_motivoCancelamento', $this->dados);
    }

    public function post(Request $request)
    {
        $motivo = new MotivoCancelamento;
        $motivo->DESCRICAO = $request->post('DESCRICAO');
        $motivo->STATUS = 1;
        $motivo->save();

        $request->session()->flash('_msg', ['text' => 'Motivo de cancelamento cadastrado!', 'tipo' => 'success']);

        return redirect()->route('config.motivoCancel');
    }

    public function put(Request $request)
    {
        $motivo_id = $request->post('MOTIVO_ID');
        $descricao = $request->post('DESCRICAO');
        $status = $request->post('STATUS');

        $motivo = MotivoCancelamento::find($motivo_id);
        $motivo->DESCRICAO = $descricao;
        $motivo->STATUS = $status ? 1 : 0;
        $motivo->save();

        $request->session()->flash('_msg', ['text' => 'Motivo de cancelamento atualizado!', 'tipo' => 'success']);

        return redirect()->route('config.motivoCancel');
    }

    public function del(Request $request, $MOTIVO_ID)
    {
        $motivo = new MotivoCancelamento;

        $motivo = $motivo::where('MOTIVO_ID', '=', $MOTIVO_ID)->first();

        $motivo->delete();

        $request->session()->flash('_msg', ['text' => "Motivo deletado!", 'tipo' => 'success']);

        return redirect()->route('config.motivoCancel');
    }
}
