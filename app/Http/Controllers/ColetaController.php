<?php

namespace App\Http\Controllers;

use App\Coleta;
use App\ColetaHistorico;
use App\ColetaProduto;
use App\ColetaStatus;
use App\Endereco;
use App\Http\Middleware\Token;
use App\Http\Resources\Coleta\ColetaResource;
use App\Http\Resources\Coleta\ColetaStatusResource;
// use App\Http\Resources\Endereco\EnderecoResource;
// use App\ProdutoType;
use App\Usuario;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class ColetaController extends Controller
{
    private $payload;
    private $usuario;

    public function __construct(Token $tokenModel, Usuario $usuarioModel)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $this->payload = $tokenModel->get();
        $this->usuario = $usuarioModel::find($this->payload['id']);
        // dd($this->usuario);
    }

    public function index($cole_id = false)
    {
        if ($cole_id) {
            $data = Coleta::where('cole_id', $cole_id)->get();
            if (!$data) return response()->json(['message' => "ID $cole_id não encontrado!"], 400);
        } else {
            # consulta par usuario tipo financeiro
            if ($this->usuario->usut_id == 1) {
                $data = Coleta::All();
            }
            # consulta par usuario tipo motorista
            if ($this->usuario->usut_id == 2) {
                $data = Coleta::where('motr_id', $this->usuario->usua_id)->OrWhere('cols_id', 1)->get();
            }
            # consulta par usuario tipo cliente
            if ($this->usuario->usut_id == 3) {
                $data = Coleta::where(['clie_id' => $this->usuario->usua_id])->get();
            }
        }

        foreach ($data as $key => $value) {
            // $value->cole_date = date('d/m/Y', strtotime($value->cole_date));
            $value->end  = $value->end();
            $value->colh = $value->colh();
            $value->colp = $value->colp();
            $value->cols = $value->cols();
            $value->clie = $value->clie();
            $value->motr = $value->motr();
            $value->finc = $value->finc();
            $data[$key] = new ColetaResource($value);
        }

        return response()->json([
            'data' => ($cole_id) ? $data[0] : $data
        ]);
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function store(Request $request)
    {
        $coletaModel = new Coleta;
        $coletaModel->cole_date          = $request['cole_date'] . ' ' . date('H:m:s');
        $coletaModel->cole_price         = 0;
        $coletaModel->cole_status        = 1;
        $coletaModel->clie_id            = $request['clie_id'];
        $coletaModel->cols_id            = 1;
        $coletaModel->save();

        $coletaHistoricoModel = new ColetaHistorico;
        $coletaHistoricoModel->colh_date = $request['cole_date'] . ' ' . date('H:m:s');
        $coletaHistoricoModel->cole_id   = $coletaModel->cole_id;
        $coletaHistoricoModel->cols_id   = 1;
        $coletaHistoricoModel->usua_id   = $request['clie_id'];
        $coletaHistoricoModel->save();

        $enderecoModel = new Endereco;
        $enderecoModel->end_complement   = $request['end_complement'];
        $enderecoModel->end_address  = $request['end_address'];
        $enderecoModel->end_number   = $request['end_number'];
        $enderecoModel->end_zipcode  = $request['end_zipcode'];
        $enderecoModel->end_district = $request['end_district'];
        $enderecoModel->end_city     = $request['end_city'];
        $enderecoModel->cole_id      = $coletaModel->cole_id;
        $enderecoModel->save();

        $coletaModel->end  = $coletaModel->end();
        $coletaModel->colh = $coletaModel->colh();
        $coletaModel->colp = $coletaModel->colp();
        $coletaModel->cols = $coletaModel->cols();
        $coletaModel->clie = $coletaModel->clie();
        $coletaModel->motr = $coletaModel->motr();
        $coletaModel->finc = $coletaModel->finc();

        return response()->json([
            'message' => 'Coleta cadastrada!',
            'data' => new ColetaResource($coletaModel)
        ]);
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $coletaModel = Coleta::find($id)->first();

        if ($coletaModel) {

            $coletaModel->cole_date   = isset($request['cole_date'])   ? $request['cole_date'] . ' ' . date('H:m:s') : $coletaModel->cole_date;
            $coletaModel->cole_price  = isset($request['cole_price'])  ? $request['cole_price']  : $coletaModel->cole_price;
            $coletaModel->cole_status = isset($request['cole_status']) ? $request['cole_status'] : $coletaModel->cole_status;
            $coletaModel->clie_id     = isset($request['clie_id'])     ? $request['clie_id']     : $coletaModel->clie_id;
            $coletaModel->cols_id     = isset($request['cols_id'])     ? $request['cols_id']     : $coletaModel->cols_id;
            $coletaModel->save();

            $enderecoModel = Endereco::where('cole_id', $coletaModel->cole_id);

            if ($enderecoModel->count()) {
                $enderecoModel = $enderecoModel->first();

                $enderecoModel->end_complement = $request['end_complement'];
                $enderecoModel->end_address  = $request['end_address'];
                $enderecoModel->end_number   = $request['end_number'];
                $enderecoModel->end_zipcode  = $request['end_zipcode'];
                $enderecoModel->end_district = $request['end_district'];
                $enderecoModel->end_city     = $request['end_city'];
                $enderecoModel->cole_id      = $coletaModel->cole_id;
                $enderecoModel->save();
            } else {

                $enderecoModel = new Endereco;
                $enderecoModel->end_complement   = $request['end_complement'];
                $enderecoModel->end_address  = $request['end_address'];
                $enderecoModel->end_number   = $request['end_number'];
                $enderecoModel->end_zipcode  = $request['end_zipcode'];
                $enderecoModel->end_district = $request['end_district'];
                $enderecoModel->end_city     = $request['end_city'];
                $enderecoModel->cole_id      = $coletaModel->cole_id;
                $enderecoModel->save();
            }

            $coletaModel->end  = $coletaModel->end();
            $coletaModel->colh = $coletaModel->colh();
            $coletaModel->colp = $coletaModel->colp();
            $coletaModel->cols = $coletaModel->cols();
            $coletaModel->clie = $coletaModel->clie();
            $coletaModel->motr = $coletaModel->motr();
            $coletaModel->finc = $coletaModel->finc();

            return response()->json([
                'message' => 'Coleta atualizada!',
                'data' => new ColetaResource($coletaModel)
            ]);
        } else {
            return response()->json(['message' => "ID $id não encontrado!"], 400);
        }
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $coleta = Coleta::find($id);

            if ($coleta) {

                // dd($coleta);

                $historico = ColetaHistorico::where('cole_id', $id)->get();
                foreach ($historico as $value) {
                    $value->delete();
                }

                $produto = ColetaProduto::where('cole_id', $id)->get();
                foreach ($produto as $value) {
                    $value->delete();
                }

                $endereco = Endereco::where('cole_id', $id)->get();
                foreach ($endereco as $value) {
                    $value->delete();
                }

                $coleta->delete();

                return response()->json(['message' => 'Coleta deletado!']);
            } else {
                return response()->json(['message' => "ID $id não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function status()
    {
        try {
            $data = ColetaStatus::All();
            foreach ($data as $key => $value) {
                $data[$key] = new ColetaStatusResource($value);
            }
            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function accept(Request $request, $cole_id)
    {
        try {
            $coletaModel = Coleta::where('cole_id', $cole_id)->first();

            if ($coletaModel) {

                $cols_id = $coletaModel->cols_id;
                $message = $this->messages($cols_id, 1);

                if ($cols_id == 1) {

                    $coletaModel->motr_id = $request['motr_id'];
                    $coletaModel->cols_id = 2;
                    $coletaModel->save();

                    $coletaHistoricoModel = new ColetaHistorico;
                    $coletaHistoricoModel->colh_date  = date('Y-m-d h:m:s');
                    $coletaHistoricoModel->cole_id  = $cole_id;
                    $coletaHistoricoModel->cols_id  = 2;
                    $coletaHistoricoModel->usua_id = $request['motr_id'];
                    $coletaHistoricoModel->save();

                    return response()->json(['message' => $message]);
                } else {

                    return response()->json(['message' => $message], 400);
                }
            } else {

                return response()->json(['message' => "ID $cole_id não foi localizado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function deliver(Request $request, $cole_id)
    {
        $coletaModel = Coleta::where('cole_id', $cole_id)->first();

        if ($coletaModel) {

            $cols_id = $coletaModel->cols_id;
            $message = $this->messages($cols_id, 2);

            if ($cols_id == 2) {

                $coletaModel->motr_id = $request['motr_id'];
                $coletaModel->cols_id = 3;
                $coletaModel->save();

                $coletaHistoricoModel = new ColetaHistorico;
                $coletaHistoricoModel->colh_date  = date('Y-m-d h:m:s');
                $coletaHistoricoModel->cole_id  = $cole_id;
                $coletaHistoricoModel->cols_id  = 3;
                $coletaHistoricoModel->usua_id = $request['motr_id'];
                $coletaHistoricoModel->save();

                return response()->json(['message' => $message]);
            } else {

                return response()->json(['message' => $message], 400);
            }
        } else {

            return response()->json(['message' => "ID $cole_id não foi localizado!"], 400);
        }
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function delivered(Request $request, $cole_id)
    {
        try {
            $coletaModel = Coleta::where('cole_id', $cole_id)->first();

            if ($coletaModel) {

                $cols_id = $coletaModel->cols_id;
                $message = $this->messages($cols_id, 3);

                if ($cols_id == 3) {

                    $coletaModel->motr_id = $request['motr_id'];
                    $coletaModel->cols_id = 4;
                    $coletaModel->save();

                    $coletaHistoricoModel = new ColetaHistorico;
                    $coletaHistoricoModel->colh_date  = date('Y-m-d h:m:s');
                    $coletaHistoricoModel->cole_id  = $cole_id;
                    $coletaHistoricoModel->cols_id  = 4;
                    $coletaHistoricoModel->usua_id = $request['motr_id'];
                    $coletaHistoricoModel->save();

                    return response()->json(['message' => $message]);
                } else {

                    return response()->json(['message' => $message], 400);
                }
            } else {

                return response()->json(['message' => "ID $cole_id não foi localizado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function completed(Request $request, $cole_id)
    {
        if ($this->usuario->usut_id !== 1)
            return response()->json(['message' => 'Apenas um Administrador pode concluir o pedido'], 400);

        $coletaModel = Coleta::where('cole_id', $cole_id)->first();

        if ($coletaModel) {

            $cols_id = $coletaModel->cols_id;
            $message = $this->messages($cols_id, 4);

            if ($cols_id == 4) {

                $coletaProduto = (new ColetaProduto)->apurarPrecoProduto(['cole_id' => $cole_id]);

                /*
                dd($coletaProduto);

                $coleta_produtos = ColetaProduto::where('cole_id', $cole_id)->get();

                // apura preço de cada 'coleta produto'
                $total_price = 0;
                $arrProdutoTypes = [];
                foreach ($coleta_produtos as $key => $coleta_produto) {

                    $copt_id = $coleta_produto->copt_id;

                    if (!isset($arrProdutoTypes[$copt_id])) {
                        $arrProdutoTypes[$copt_id] = ProdutoType::where('copt_id', $copt_id)->first();
                    }
                    # preço do tipo de produto
                    $copt_price = $arrProdutoTypes[$copt_id]->copt_price;
                    # preço * quantidade do produto 
                    $colp_price_unit = $copt_price * $coleta_produto->colp_quantity;
                    # soma dos valores totais por produto
                    $total_price += $colp_price_unit;

                    # atualiza produto
                    $coleta_produto->colp_price_unit = $colp_price_unit;
                    $coleta_produto->colp_price      = number_format($colp_price_unit, 2, '.', '');
                    $coleta_produto->save();
                }
                unset($arrProdutoTypes, $coleta_produtos, $coleta_produto, $copt_id);

                dd($total_price);
                */

                # atualiza coleta
                $coletaModel->cole_price = $coletaProduto['cole_price'];
                $coletaModel->cols_id    = 5;
                $coletaModel->finc_id    = $request['finc_id'];
                $coletaModel->save();

                $coletaHistoricoModel = new ColetaHistorico;
                $coletaHistoricoModel->colh_date  = date('Y-m-d h:m:s');
                $coletaHistoricoModel->cole_id  = $cole_id;
                $coletaHistoricoModel->cols_id  = 5;
                $coletaHistoricoModel->usua_id = $request['finc_id'];
                $coletaHistoricoModel->save();

                return response()->json(['message' => $message]);
            } else {

                return response()->json(['message' => $message], 400);
            }
        } else {

            return response()->json(['message' => "ID $cole_id não foi localizado!"], 400);
        }

        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function syncPrice($cole_id)
    {
        $coletaModel = Coleta::where('cole_id', $cole_id)->first();

        if ($coletaModel) {
            $coletaProduto = (new ColetaProduto)->apurarPrecoProduto(['cole_id' => $cole_id]);
            $coletaModel->cole_price = $coletaProduto['cole_price'];
            $coletaModel->save();

            $coletaModel->end  = $coletaModel->end();
            $coletaModel->colh = $coletaModel->colh();
            $coletaModel->colp = $coletaModel->colp();
            $coletaModel->cols = $coletaModel->cols();
            $coletaModel->clie = $coletaModel->clie();
            $coletaModel->motr = $coletaModel->motr();
            $coletaModel->finc = $coletaModel->finc();

            return response()->json([
                'message' => 'Coleta atualizada!',
                'data' => new ColetaResource($coletaModel)
            ]);
        } else {

            return response()->json(['message' => "ID $cole_id não foi localizado!"], 400);
        }

        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    private function messages($status_id, $status)
    {
        // echo $status_id, $status;
        // exit;
        // $status_id++;

        $successMessages[1] = 'Coleta aceita!';
        $successMessages[2] = 'Coleta realizada!';
        $successMessages[3] = 'Coleta entregue!';
        $successMessages[4] = 'Coleta concluida!';

        $concludedMessages[1] = 'Coleta já aceita!';
        $concludedMessages[2] = 'Coleta já retirada!';
        $concludedMessages[3] = 'Coleta já entregue!';
        $concludedMessages[4] = 'Coleta já concluida!';

        $pendingMessages[1] = 'Coleta em fazer de aceitar!';
        $pendingMessages[2] = 'Coleta em fazer de retirada!';
        $pendingMessages[3] = 'Coleta em fazer de entrega!';
        $pendingMessages[4] = 'Coleta em fazer de conclusão!';

        if ($status_id == $status) {
            return $successMessages[$status];
        } else if ($status_id > $status) {

            return $concludedMessages[$status];
        } else if ($status_id < $status) {

            return $pendingMessages[$status_id];
        }
    }
}
