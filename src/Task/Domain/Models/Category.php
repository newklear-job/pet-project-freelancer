<?php

namespace Freelance\Task\Domain\Models;

use Filterable\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Category extends Model
{
    use HasFactory;
    use HasFilters;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
