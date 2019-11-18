<?php
namespace Phreact;

class Document {
    public $root;

    public function __construct(array $element = []) {        
        $this->root = new Element(...$element);
    }

    public function render($display = false) {
        $document = $this->root->render();

        if ($display) {
            echo $document;
        }

        return $document;
    }
}
