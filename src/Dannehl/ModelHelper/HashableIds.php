<?php namespace Dannehl\ModelHelper;

use Hashids\Hashids;

/**
 * Trait HashableIds
 *
 * @package Dannehl\ModelHelper
 * 
 * Add "public_id" to your list off appendings (protected $appends = ['public_id'];).
 * Per default the hashed ids are 10 character long. If you need them in a different size, just
 * assign a property with the required size within your model (ex.: protected $hashSize = 15;)
 * 
 */
trait HashableIds {

    /**
     * @param $public_id
     * @return mixed
     */
    public function findByPublicId($public_id)
    {
        return $this->find($this->_hashIds($public_id));
    }

    /**
     * @param $query
     * @param $public_id
     * @return mixed
     */
    public function scopeByPublicId($query, $public_id)
    {
        return $this->findByPublicId($public_id);
    }

    /**
     * @return mixed
     */
    public function getPublicIdAttribute()
    {
        return $this->_hashIds($this->{$this->getKeyName()});
    }

    /**
     * @param $id
     * @return array|bool|string
     */
    private function _hashIds($id)
    {
        $hashids = new Hashids(
            getenv('APP_HASH_SALT'),
            property_exists($this,'hashSize') ? $this->hashSize : 10
        );

        if (preg_match("/^[0-9]+$/",$id)) {

            if ($id < 0) return null;
            return $hashids->encode(intval($id));

        } else {

            return $hashids->decode($id);

        }
    }
    
}