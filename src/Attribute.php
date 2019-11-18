<?php
namespace Phreact;

class Attribute {
    private $name;
    private $value;

    public function __construct(string $name, $value = true) {
        $this->name = $name;
        $this->value = $value;
    }

    public function render() {
        $value = $this->value;
        $name = $this->name;

        if (!boolval($value)) {
            return false;
        }

        if ($value === true) {
            return $name;
        }

        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        if (is_callable($value)) {
            $value = $value();
        }

        return $this->name . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
    }
}