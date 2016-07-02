<?php

namespace Testing\Functional\Staff\Products;

use ChingShop\Catalogue\Product\Product;
use ChingShop\Image\Image;
use Testing\Functional\FunctionalTest;
use Testing\Functional\Util\CreateCatalogue;

/**
 * Class ProductTest.
 */
abstract class ProductTest extends FunctionalTest
{
    use CreateCatalogue;

    /**
     * @param Product $product
     *
     * @return Image
     */
    protected function attachImageToProduct(Product $product): Image
    {
        $image = Image::create([
            'alt_text' => str_random(),
            'url'      => $this->generator()->anySlug(),
        ]);
        $product->images()->attach($image->id);

        return $image;
    }
}
