<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmailInput extends Component
{
    public $id;
    public $name;
    public $label;
    public $value;
    public $required;
    public $placeholder;
    /**
     * Create a new component instance.
     */
    public function __construct($id, $name, $label, $value = '', $required = false, $placeholder = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.email-input');
    }
}
