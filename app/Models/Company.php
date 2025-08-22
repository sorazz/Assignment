<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Eloquent as Model;

class Company extends Model {
    use HasFactory;
    public $table = 'company';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'category_id',
        'title',
        'status',
        'image',
        'description',

    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'title' => 'string',
         'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function category() {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }


}
