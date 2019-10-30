<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Contato extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'contatos';

    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'telefone'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id'        => 'int',
        'nome'      => 'string',
        'sobrenome' => 'string',
        'email'    => 'string',
        'telefone'  => 'string',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'contato';

    protected static $logOnlyDirty = true;

    /* ******* *** Relacionamentos *** ******* */

}
