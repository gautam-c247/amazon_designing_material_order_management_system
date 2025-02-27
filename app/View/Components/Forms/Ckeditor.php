<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ckeditor extends Component
{
    public $name;
    public $id;
    public $value;
    public $label;
    public $required;
    public $placeholder;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $id = null, $value = '', $placeholder = 'Enter text...', $required = false )
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id ?? $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.ckeditor');
    }
}
