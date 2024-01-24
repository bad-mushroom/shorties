<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    use HasFactory;
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'url_id',
        'fingerprint',
        'visited_at',
    ];

    // -- Relationships

    public function url()
    {
        return $this->belongsTo(Url::class);
    }

    // -- Accessors

    //
}
