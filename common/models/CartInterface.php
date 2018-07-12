<?php 

namespace common\models;
/**
 * All objects that can be added to the cart must implement this interface
 *
 * @package yii2mod\cart\models
 */
interface CartInterface
{
    /**
     * Returns the price for the cart item
     *
     * @return int
     */
    public function getPrice();
    /**
     * Returns the label for the cart item (displayed in cart etc)
     *
     * @return int|string
     */
    public function getLabel();
    /**
     * Returns unique id to associate cart item with product
     *
     * @return int|string
     */
    public function getUniqueId();
}