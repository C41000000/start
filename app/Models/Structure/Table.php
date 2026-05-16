<?php

namespace App\Models\Structure;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'status',
        'capacity',
    ];

    /**
     * Define que o UUID será usado para o Route Model Binding.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Casts para garantir os tipos de dados ao recuperar do banco.
     */
    protected $casts = [
        'capacity' => 'integer',
        'deleted_at' => 'datetime',
    ];
}
