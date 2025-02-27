<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component
{
    public $name;
    public $id;
    public $label;
    public $required;
    public $accept;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $id = null, $required = false, $accept = '*')
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id ?? $name;
        $this->required = $required;
        $this->accept = $accept;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.file');
    }
}
