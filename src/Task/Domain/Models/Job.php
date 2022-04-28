<?php

namespace Freelance\Task\Domain\Models;

use Filterable\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class Job extends Model implements HasMedia
{
    use HasFactory;
    use HasFilters;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
