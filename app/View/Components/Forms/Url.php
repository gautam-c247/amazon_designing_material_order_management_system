<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Url extends Component
{
    public $id;
    public $name;
    public $label;
    public $placeholder;
    public $required;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $id = null, $placeholder = '', $required = false, $value = '')
    {
        $this->id = $id ?? $name;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.url');
    }
}
