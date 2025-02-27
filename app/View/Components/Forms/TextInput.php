<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class TextInput extends Component
{
    public $id;
    public $name;
    public $label;
    public $value;
    public $placeholder;
    public $required;

    public function __construct($id, $name, $label, $value = '', $placeholder = '', $required = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.forms.text-input');
    }
}
