<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Mensagem extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'mensagems';

    protected $fillable = [
        'contato_id',
        'mensagem',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id'            => 'int',
        'contato_id'    => 'int',
        'mensagem'      => 'string',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'mensagem';

    protected static $logOnlyDirty = true;

    /* ******* *** Relacionamentos *** ******* */

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }
}
