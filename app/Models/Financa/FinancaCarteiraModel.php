<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaCarteiraModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'fnct_id';

    protected $table = "api_crm_financa_carteira";
    
    protected $fillable = [
        'fnct_description',
        'fnct_json',
        'fnct_enable',
        'fnct_panel',
    ];

    protected $hidden = [
        'usua_id',
    ];
}
