<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Content extends Model
{
    use HasFactory;
    use HasSEO;

    protected $fillable = ['view_count'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->slug,
            url: route('content.show', ['content' => $this->slug]),
            published_time: $this->created_at,
            modified_time: $this->updated_at,
        );
    }
}
