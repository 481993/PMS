<?php

namespace Modules\Milestone\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Milestone extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'milestones';

    /**
     * Get all of the posts that are assigned this milestone.
     */
    public function posts()
    {
        return $this->morphedByMany('Modules\Article\Entities\Post', 'milestonegable');
    }

    /**
     * Set the 'meta title'.
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setMetaTitleAttribute($value)
    {
        $this->attributes['meta_title'] = $value;

        if (empty($value)) {
            $this->attributes['meta_title'] = $this->attributes['name'];
        }
    }

    /**
     * Set the 'meta description'
     * If no value submitted use the default 'meta_description'.
     *
     * @param [type]
     */
    public function setMetaDescriptionAttribute($value)
    {
        $this->attributes['meta_description'] = $value;

        if (empty($value)) {
            $this->attributes['meta_description'] = setting('meta_description');
        }
    }

    /**
     * Set the 'meta description'
     * If no value submitted use the default 'meta_description'.
     *
     * @param [type]
     */
    public function setMetaKeywordAttribute($value)
    {
        $this->attributes['meta_keyword'] = $value;

        if (empty($value)) {
            $this->attributes['meta_keyword'] = setting('meta_keyword');
        }
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Milestone\Database\Factories\MilestoneFactory::new();
    }

     
}
