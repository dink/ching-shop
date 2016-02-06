<?php

namespace ChingShop\Catalogue\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use ChingShop\Image\Image;

/**
 * ChingShop\Catalogue\Product\Product
 *
 * @property integer $id
 * @property string $sku
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\Catalogue\Product\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\Catalogue\Product\Product whereSku($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\Catalogue\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\Catalogue\Product\Product whereUpdatedAt($value)
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\Catalogue\Product\Product whereName($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Image[] $images
 * @property string $slug
 * @property string $description
 */
class Product extends Model
{
    /** @var array */
    protected $fillable = ['name', 'sku', 'slug'];

    /** @var array */
    protected $guarded = ['id'];

    /**
     * @return bool
     */
    public function isStored(): bool
    {
        return (bool) $this->id;
    }

    /**
     * @return BelongsToMany
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class);
    }

    /**
     * @param int[] $imageIDs
     */
    public function attachImages(array $imageIDs)
    {
        $this->images()->attach($imageIDs);
    }
}