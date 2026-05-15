<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasUuids;
    /**
     *  Define quais colunas devem receber UUID automaticamente.
     *  Necessário porque o PK é 'id' (int), e não o uuid.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
