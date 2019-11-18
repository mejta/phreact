<?php
namespace Phreact;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate {
    protected $items = [];

    public function __construct(array $items = []) {
        $this->items = $items;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function count() {
        return count($this->items);
    }

    public function getIterator() {
        return new \ArrayIterator($this);
    }

    public function getItems() {
        return $this->items;
    }
}
