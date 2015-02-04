<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 04/02/2015
 * Time: 12:12
 */

namespace Core\Helper;


use Traversable;

class Collection implements \ArrayAccess, \IteratorAggregate
{

    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function __get($item){
        return $this->get($item);
    }

    public function __set($item, $value){
        $this->set($item, $value);
    }

    public function get($item){
        $index = explode('.', $item);
        return $this->getValue($index, $this);
    }

    private static function getValue(array $indexes, $items)
    {
        $key = array_shift($indexes);
        if ($items->has($key)) {
            $newItems = $items->items[$key];
            if(empty($indexes)){
                if(is_array($newItems)){
                    return new Collection($newItems);
                } else {
                    return $newItems;
                }
            } else {
                return self::getValue($indexes, new Collection($newItems));
            }
        } else {
            return Null;
        }
    }

    public function set($item, $value)
    {
        $this->items[$item] = $value;
    }

    public function has($item)
    {
        return array_key_exists($item, $this->items);
    }

    public function del($item){
        if ($this->has($item)) {
            unset($this->items[$item]);
        }
    }
    public function liste($key, $value){
        $result = array();
        foreach($this->items as $item){
            $result[$item[$key]] = $item[$value];
        }
        return new Collection($result);
    }

    public function extract($key){
        $result = array();
        foreach($this->items as $item){
            $result[] = $item[$key];
        }
        return new Collection($result);
    }

    public function join($separateur){
        return implode($separateur, $this->items);
    }

    public function max($key = NULL){
        if(is_null($key)){
            return max($this->items);
        }else{
            return $this->extract($key)->max();
        }
    }

    public function min($key = NULL){
        if(is_null($key)){
            return min($this->items);
        }else{
            return $this->extract($key)->min();
        }
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->del($offset);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}