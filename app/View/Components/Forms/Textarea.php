<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $id;
    public $name;
    public $value;
    public $placeholder;
    public $required;
    public $label;
    public $rows;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $name, $label, $value = '', $placeholder = '', $required = false, $rows = 4)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->rows = $rows;


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.textarea');
    }
}
