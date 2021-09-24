<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partisipan extends Model
{

    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partisipans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nik', 'nama', 'alamat', 'hadiah'];

    
}
