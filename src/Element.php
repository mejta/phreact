<?php
namespace Phreact;

class Element {
    public $tag;
    public $attributes;
    public $children = [];
    public $isSelfClosing = false;

    private $defaultType = Element::class;
    private $types = [
        'meta' => SelfClosingElement::class,
        'link' => SelfClosingElement::class,
        'img' => SelfClosingElement::class,
        'br' => SelfClosingElement::class,
        'hr' => SelfClosingElement::class,
        'source' => SelfClosingElement::class,
    ];

    public function __construct(string $tag, array $attributes = [], array $children = []) {
        $this->tag = $tag;
        $this->attributes = new AttributeCollection($attributes);

        foreach ($children as $child) {
            if (!is_array($child)) {
                $this->children[] = $child;
                continue;
            }

            $tag = $child[0];
            $props = isset($child[1]) ? $child[1] : [];
            $children = isset($child[2]) ? $child[2] : [];
            $type = isset($this->types[$tag]) ? $this->types[$tag] : $this->defaultType;

            $this->children[] = new $type($tag, $props, $children);
        }
    }

    public function render($display = false) {
        $openingTag = '<' . join(' ', array_filter([$this->tag, $this->attributes->render()])) . '>';

        $content = $this->isSelfClosing ? '' : join(array_map(function($child) {
            if (is_callable($child)) {
                return $child($this->attributes);
            }
            
            if (is_object($child)) {
                return $child->render();
            }

            return $child;
        }, $this->children));
    
        $closingTag = $this->isSelfClosing ? '' : '</' . $this->tag . '>';

        $html = $openingTag . $content . $closingTag;

        if ($display) {
            echo $html;
        }

        return $html;
    }
}
