<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $colorClass;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($colorClass, $text)
    {
        $this->colorClass = $colorClass;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.badge');
    }
}
