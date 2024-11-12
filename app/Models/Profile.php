<?php

namespace App\Models;

use App\Enums\ProfileStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Profile extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $casts = [
        'status' => ProfileStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'status',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('sm')
                    ->fit(Fit::Max, 360, 360)
                    ->nonQueued();

                $this
                    ->addMediaConversion('md')
                    ->fit(Fit::Max, 720, 720)
                    ->nonQueued();

                $this
                    ->addMediaConversion('hd')
                    ->fit(Fit::Max, 1080, 1080)
                    ->nonQueued();
            });
    }
}
