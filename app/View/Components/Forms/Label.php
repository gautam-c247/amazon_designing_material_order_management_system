<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Label extends Component
{
    public $for;
    public $text;
    public $required;

    public function __construct($for, $text, $required = false)
    {
        $this->for = $for;
        $this->text = $text;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.forms.label');
    }
}
