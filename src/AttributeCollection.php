<?php
namespace Phreact;

class AttributeCollection extends Collection {
    public function __construct(array $attributes) {
        foreach ($attributes as $key => $value) {
            $this->items[$key] = new Attribute($key, $value);
        }
    }

    public function render() {
        return join(' ', array_filter(array_map(function($attribute) {
            return $attribute->render();
        }, $this->getItems())));
    }
}
