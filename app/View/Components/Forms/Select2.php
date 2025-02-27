<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2 extends Component
{
    public $name;
    public $id;
    public $options;
    public $selected;
    public $placeholder;
    public $multiple;
    public $required;
    public $label;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $id = null, $options = [], $selected = null, $placeholder = 'Select an option', $multiple = false, $required = false)

    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id ?? $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->multiple = $multiple;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select2');
    }
}
