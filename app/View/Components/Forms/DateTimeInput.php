<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateTimeInput extends Component
{
    public $id;
    public $name;
    public $value;
    public $required;
    public $label;
    public $min;
    public $max;

    /**
     * Create a new component insta nce.
     */

    public function __construct($id, $name, $label, $value = '', $required = false, $min = null, $max = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.date-time-input');
    }
}
