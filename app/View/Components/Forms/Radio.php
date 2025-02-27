<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public $name;
    public $id;
    public $label;
    public $required;
    public $checked;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $id = null, $required = false, $checked = false, $value = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->required = $required;
        $this->checked = $checked;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.radio');
    }
}
