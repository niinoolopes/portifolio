<?php

namespace App;

use App\Http\Resources\Produto\ProdutoResource;
use Illuminate\Database\Eloquent\Model;
use App\ProdutoType;

// use Illuminate\Support\Facades\DB;

class ColetaProduto extends Model
{
    protected $table = 'sc__coleta_produto';

    protected $primaryKey = 'colp_id';


    // public function type()
    // {
    //     return $this->hasOne('App\ProdutoType', 'copt_id', 'colp_id');
    // }

    public function copt()
    {
        $model = $this->hasOne('App\ProdutoType', 'copt_id', 'copt_id');
        return new ProdutoResource($model->first());
    }

    public function apurarPrecoProduto($params)
    {
        $cole_id = isset($params['cole_id']) ? $params['cole_id'] : false;
        $colp_id = isset($params['colp_id']) ? $params['colp_id'] : false;

        if ($cole_id)
            $coleta_produtos = ColetaProduto::where('cole_id', $cole_id)->get();

        if ($colp_id)
            $coleta_produtos = ColetaProduto::where('colp_id', $colp_id)->get();


        $cole_price = 0;
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
            $cole_price += $colp_price_unit;

            # atualiza produto
            $coleta_produto->colp_price_unit = $colp_price_unit;
            $coleta_produto->colp_price      = number_format($colp_price_unit, 2, '.', '');
            $coleta_produto->save();
        }
        unset($coleta_produtos, $key, $coleta_produto, $copt_id, $copt_price, $arrProdutoTypes);

        $cole_price = number_format($cole_price, 2, '.', '');

        return [
            'cole_price' => $cole_price
        ];
    }
}
