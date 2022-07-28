<?php

namespace Modules\Employeerole\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employeerole extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'employeeroles';

    /**
     * Get all of the posts that are assigned this employeerole.
     */
    public function posts()
    {
        return $this->morphedByMany('Modules\Article\Entities\Post', 'employeerolegable');
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
        return \Modules\Employeerole\Database\Factories\EmployeeroleFactory::new();
    }

    /**

     * Boot the model.

     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($product) {

            $product->slug = $product->createSlug($product->name);

            $product->save();
        });
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    private function createSlug($name)
    {
        if (static::whereSlug($slug = Str::slug($name))->exists()) {

            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');

            if (isset($max[-1]) && is_numeric($max[-1])) {

                return preg_replace_callback('/(\d+)$/', function ($mathces) {

                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}";
        }
        return $slug;
    }
}
