<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = 'application.urls';

    /**
     * @var string
     */
    protected $primaryKey = 'hash';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'hash',
        'original_url',
        'expiration_date',
        'custom_alias',
        'user_id',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
