<?php
/*
 * User: fabien.sanchez
 * Date: 04/02/2015
 * Time: 12:12
 */

namespace Core\Helper;

/**
 * Class Collection
 * @package Core\Helper
 */
class Collection implements \ArrayAccess, \IteratorAggregate
{

    /**
     * @var array
     */
    private $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param $item
     * @return Collection|mixed|null
     */
    public function __get($item){
        return $this->get($item);
    }

    /**
     * @param $item
     * @param $value
     */
    public function __set($item, $value){
        $this->set($item, $value);
    }

    /**
     * @param $item
     * @return Collection|mixed|null
     */
    public function get($item){
        if($this->has($item)){
            $tmpGet = self::getValue(explode('.', $item), $this->items);
            if(is_array($tmpGet)){
                return new Collection($tmpGet);
            }else{
                return $tmpGet;
            }
        } else {
            return NULL;
        }
    }

    /**
     * @param array $indexes
     * @param $items
     * @return mixed
     */
    private static function getValue(array $indexes, $items)
    {
        $key = array_shift($indexes);
        if( empty($indexes) ){
            return $items[$key];
        } else {
            return self::getValue($indexes, $items[$key]);
        }
    }

    /**
     * @param $item
     * @param $value
     */
    public function set($item, $value)
    {
        $this->items[$item] = $value;
    }

    /**
     * @param $item
     * @return bool
     */
    public function has($item)
    {
        return self::hasKey(explode('.', $item), $this->items);
    }

    /**
     * @param array $indexes
     * @param $items
     * @return bool
     */
    private static function hasKey(array $indexes, $items){
        $key = array_shift($indexes);
        return array_key_exists($key, $items) && self::hasKey($indexes, $items[$key]);
    }

    /**
     * @param $item
     */
    public function del($item){
        if ($this->has($item)) {
            unset($this->items[$item]);
        }
    }

    /**
     * @param $key
     * @param $value
     * @return Collection
     */
    public function liste($key, $value){
        $result = array();
        foreach($this->items as $item){
            $result[$item[$key]] = $item[$value];
        }
        return new Collection($result);
    }

    /**
     * @param $key
     * @return Collection
     */
    public function extract($key){
        $result = array();
        foreach($this->items as $item){
            $result[] = $item[$key];
        }
        return new Collection($result);
    }

    /**
     * @param $separateur
     * @return string
     */
    public function join($separateur){
        return implode($separateur, $this->items);
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function max($key = NULL){
        if(is_null($key)){
            return max($this->items);
        }else{
            return $this->extract($key)->max();
        }
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function min($key = NULL){
        if(is_null($key)){
            return min($this->items);
        }else{
            return $this->extract($key)->min();
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return Collection|mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->del($offset);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}