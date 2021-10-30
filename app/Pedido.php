<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'sad__pedido';
    protected $primaryKey = 'PEDIDO_ID';

    public function getAll()
    {
        $sql  = "SELECT pedido.*, banco.NOME B_NOME, banco.SITE B_SITE, banco.CODIGO B_CODIGO, motivo.DESCRICAO M_DESCRICAO, ";
        $sql .= "banco.LOGO B_LOGO, usuario.NOME U_NOME, status.DESCRICAO S_DESCRICAO, empresa.NOME E_NOME, empresa.COR E_COR ";
        $sql .= "FROM sad__pedido pedido ";
        $sql .= "left JOIN sad__banco banco on banco.BANCO_ID = pedido.BANCO_ID ";
        $sql .= "left JOIN sad__usuario usuario on usuario.USUARIO_ID = pedido.USUARIO_ID ";
        $sql .= "LEFT JOIN sad__empresa empresa on empresa.EMPRESA_ID = usuario.EMPRESA_ID ";
        $sql .= "left JOIN sad__pedido_status status on status.STATUS_ID = pedido.STATUS_ID ";
        $sql .= "left JOIN sad__pedido_motivo motivo on motivo.MOTIVO_ID = pedido.MOTIVO_ID ";

        if (session()->get('USUARIO.PERMISSAO_PAINEL') == 'self') {
            $sql .= "WHERE pedido.USUARIO_ID = " . session()->get('USUARIO.USUARIO_ID') . " ";
        }
        $sql .= "order by PEDIDO_ID desc ";
        $sql .= "limit 250; ";
        return DB::select($sql);
    }

    public function getAllFiltro($campos)
    {
        $sql  = "SELECT pedido.*, banco.NOME B_NOME, banco.SITE B_SITE, banco.CODIGO B_CODIGO, motivo.DESCRICAO M_DESCRICAO, ";
        $sql .= "banco.LOGO B_LOGO, usuario.NOME U_NOME, status.DESCRICAO S_DESCRICAO, empresa.NOME E_NOME, empresa.COR E_COR ";
        $sql .= "FROM sad__pedido pedido ";
        $sql .= "left JOIN sad__banco banco on banco.BANCO_ID = pedido.BANCO_ID ";
        $sql .= "left JOIN sad__usuario usuario on usuario.USUARIO_ID = pedido.USUARIO_ID ";
        $sql .= "LEFT JOIN sad__empresa empresa on empresa.EMPRESA_ID = usuario.EMPRESA_ID ";
        $sql .= "left JOIN sad__pedido_status status on status.STATUS_ID = pedido.STATUS_ID ";
        $sql .= "left JOIN sad__pedido_motivo motivo on motivo.MOTIVO_ID = pedido.MOTIVO_ID ";

        if (isset($campos['filtro']) && $campos['filtro'] == 'id')
            $sql .= "WHERE pedido.PEDIDO_ID = '" . $campos['conteudo'] . "' ";
            
        if (isset($campos['filtro']) && $campos['filtro'] == 'numero-atendimento')
        $sql .= "WHERE pedido.N_ATENDIMENTO = '" . $campos['conteudo'] . "' ";

        if (isset($campos['filtro']) && $campos['filtro'] == 'empresa')
            $sql .= "WHERE empresa.NOME like '%" . $campos['conteudo'] . "%' ";

        if (isset($campos['filtro']) && $campos['filtro'] == 'valor')
            $sql .= "WHERE pedido.VALOR like '%" . $campos['conteudo'] . "%' ";

        if (isset($campos['filtro']) && $campos['filtro'] == 'atendimento')
            $sql .= "WHERE pedido.N_ATENDIMENTO like '%" . $campos['conteudo'] . "%' ";

        if (session()->get('USUARIO.PERMISSAO_PAINEL') == 'self')
            $sql .= "AND pedido.USUARIO_ID = " . session()->get('USUARIO.USUARIO_ID') . " ";

        $sql .= "order by PEDIDO_ID desc;";

        return DB::select($sql);
    }

    public function relatorio($campos)
    {
        $dataDe = $campos['DATA_DE'] . ' 00:00:00';
        $dataAte = $campos['DATA_ATE'] . ' 23:59:59';
        
        $sql  = "SELECT pedido.*, banco.NOME B_NOME, banco.SITE B_SITE, banco.CODIGO B_CODIGO, motivo.DESCRICAO M_DESCRICAO, ";
        $sql .= "banco.LOGO B_LOGO, usuario.NOME U_NOME, status.DESCRICAO S_DESCRICAO, empresa.NOME E_NOME, empresa.COR E_COR ";
        $sql .= "FROM sad__pedido pedido ";
        $sql .= "left JOIN sad__banco banco on banco.BANCO_ID = pedido.BANCO_ID ";
        $sql .= "left JOIN sad__usuario usuario on usuario.USUARIO_ID = pedido.USUARIO_ID ";
        $sql .= "LEFT JOIN sad__empresa empresa on empresa.EMPRESA_ID = usuario.EMPRESA_ID ";
        $sql .= "left JOIN sad__pedido_status status on status.STATUS_ID = pedido.STATUS_ID ";
        $sql .= "left JOIN sad__pedido_motivo motivo on motivo.MOTIVO_ID = pedido.MOTIVO_ID ";
        $sql .= "WHERE pedido.STATUS = 1 ";

        if (isset($campos['banco'])) {
            $in = implode(',', $campos['banco']);
            $sql .= "AND pedido.BANCO_ID IN (" . $in . ") ";
        }

        if (isset($campos['vencedor'])) {
            $in = implode(',', $campos['vencedor']);
            $sql .= "AND pedido.USUARIO_ID IN (" . $in . ") ";
        }

        if (isset($campos['empresa'])) {
            $in = implode(',', $campos['empresa']);
            $sql .= "AND usuario.EMPRESA_ID IN (" . $in . ") ";
        }

        $sql .= "AND pedido.created_at between '{$dataDe}' and '{$dataAte}' ";
        $sql .= "order by PEDIDO_ID desc;";
        return DB::select($sql);
    }
}
