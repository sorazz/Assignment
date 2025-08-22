<?php

namespace App\Models;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model {
    use HasFactory;
    public $table = 'company_category';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'title',

    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }


}
