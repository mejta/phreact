<?php
namespace Phreact;

class Component {
    public $tag;
    public $props;
    public $children;
    public $isSelfClosing = false;

    public function __construct(string $tag, array $props = [], array $children = []) {
        $this->tag = $tag;
        $this->props = $props;
        $this->children = $children;
    }

    protected function renderProps() {
        $atts = array_filter($this->props);

        return join(' ', array_map(function(string $attribute, $value) {
            if ($value === true) {
                return $attribute;
            }
    
            if (is_int($value)) {
                return $attribute . '=' . $value;
            }
    
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }
    
            if (is_callable($value)) {
                $value = $value();
            }
    
            return $attribute . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
        }, array_keys($atts), array_values($atts)));
    }

    public function render($display = false) {
        $openingTag = '<' . join(' ', array_filter([$this->tag, $this->renderProps()])) . '>';

        $content = join(array_map(function($child) {
            if (is_callable($child)) {
                return $child($this->props);
            }
            
            if (is_object($child)) {
                return $child->render();
            }

            return $child;
        }, $this->children));
    
        $closingTag = '</' . $this->tag . '>';

        $html = $this->isSelfClosing ? $openingTag : $openingTag . $content . $closingTag;

        if ($display) {
            echo $html;
        }

        return $html;
    }
}
