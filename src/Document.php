<?php
namespace Phreact;

class Document {
    private $defaultType = Component::class;

    private $types = [
        'meta' => SelfClosingComponent::class,
        'link' => SelfClosingComponent::class,
        'img' => SelfClosingComponent::class,
        'br' => SelfClosingComponent::class,
        'hr' => SelfClosingComponent::class,
        'source' => SelfClosingComponent::class,
    ];

    public $components = [];

    public function __construct(array $components = []) {        
        if (empty($components)) {
            return;
        }

        if (is_array($components[0])) {
            $this->components = array_map(function($component) {
                return $this->createComponent($component);
            }, $components);
        } else {
            $this->components[] = $this->createComponent($components);
        }
    }

    private function createComponent($component) {
        if (!is_array($component)) {
            $this->components = [$component];
        }

        $tag = $component[0];
        $props = isset($component[1]) ? $component[1] : [];
        $children = array_map(function($child) {
            if (is_array($child)) {
                return $this->createComponent($child);
            }
    
            return $child;
        }, isset($component[2]) ? $component[2] : []);

        $type = isset($this->types[$tag]) ? $this->types[$tag] : $this->defaultType;
    
        return new $type($tag, $props, $children);
    }

    public function render($display = false) {
        $document = join(array_map(function($component) {
            return $component->render();
        }, $this->components));

        if ($display) {
            echo $document;
        }

        return $document;
    }
}
