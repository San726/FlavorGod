<?php namespace Flavorgod\Services;

use Flavorgod\Models\Eloquent\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Exception;

final class ProductPricing
{
    public static function getMSRP($product)
    {
        return static::getPrice($product);
    }

    public static function getPrice($product, $reference = 1)
    {
        if (is_numeric($product)) {
            $product = ProductVariant::find($product);
        }

        if ($reference instanceof Model && isset($reference->product_price_id)) {
            $reference = (int) $reference->product_price_id;
        } elseif (!is_numeric($reference)) {
            $reference = 1;
        }

        if ($product instanceof ProductVariant) {
            try {
                $price = $product->prices()->where('product_prices.id', $reference)->firstOrFail();
            } catch (Exception $e) {
                $price = $product->prices()->where('product_prices.id', 1)->first();
            }

            return (double) $price->pivot->price;
        }

        throw new Exception('Product does not exist.');

    }
}