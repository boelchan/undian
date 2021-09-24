<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hadiah extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hadiahs';

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
    protected $fillable = ['hadiah', 'status', 'icon'];

    /**
     * Get the pemenang associated with the Hadiah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pemenang()
    {
        return $this->hasOne(Partisipan::class, 'hadiah', 'id');
    }

    
}
