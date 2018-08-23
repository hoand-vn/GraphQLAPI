<?php
/*
 * This file is part of the Custom Csv Export Plugin
 *
 * Copyright (C) 2017 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GraphQLAPI\Type;


class TypesInitial
{
    protected static $categoryType;
    protected static $classCategoryType;
    protected static $productType;
    protected static $productClassType;

    /**
     * @return CategoryType
     */
    public static function getCategoryType()
    {
        return self::$categoryType ?: (self::$categoryType = new CategoryType());
    }
    /**
     * @return ClassCategoryType
     */
    public static function getClassCategoryType()
    {
        return self::$classCategoryType ?: (self::$classCategoryType = new ClassCategoryType());
    }
    /**
     * @return ProductType
     */
    public static function getProductType()
    {
        return self::$productType ?: (self::$productType = new ProductType());
    }
    /**
     * @return ProductClassType
     */
    public static function getProductClassType()
    {
        return self::$productClassType ?: (self::$productClassType = new ProductClassType());
    }
}