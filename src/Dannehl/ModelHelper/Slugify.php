<?php namespace Dannehl\ModelHelper;

use Dannehl\ModelHelper\Lib\StrSlug;

/**
 * Trait Slugify
 *
 * @package Dannehl\ModelHelper
 */
trait Slugify {

    /**
     * @param $model
     * @param string $nameColumn
     * @param string $slugColumn
     */
    protected static function createSlug($model, $nameColumn = 'name', $slugColumn = 'slug')
    {
        $model->{$slugColumn} = StrSlug::make($model->{$nameColumn});

        $latestSlug = self::whereRaw("slug RLIKE '^{$model->{$slugColumn}}(-[0-9]*)?$'")->latest('id')->value($slugColumn);

        if ($latestSlug) {
            $pieces = explode('-', $latestSlug);
            $model->{$slugColumn} .= '-' . (intval(end($pieces)) + 1);
        }
    }

    /**
     * @param $model
     * @param string $nameColumn
     * @param string $slugColumn
     */
    protected static function updateSlug($model, $nameColumn = 'name', $slugColumn = 'slug')
    {
        $model->{$slugColumn} = StrSlug::make($model->{$nameColumn});

        $latestSlug = self::whereRaw("slug RLIKE '^{$model->{$slugColumn}}(-[0-9]*)?$' and id != '{$model->id}'")->latest('id')->value($slugColumn);

        if ($latestSlug) {
            $pieces = explode('-', $latestSlug);
            $model->{$slugColumn} .= '-' . (intval(end($pieces)) + 1);
        }
    }
    
}