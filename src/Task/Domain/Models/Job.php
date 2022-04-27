<?php

namespace Freelance\Task\Domain\Models;

use Filterable\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Job extends Model
{
    use HasFactory;
    use HasFilters;

    protected $fillable = [
        'name',
        'description',
    ];
}
