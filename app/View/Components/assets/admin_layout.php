<?php

namespace App\View\Components\assets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class admin_layout extends Component
{
    /**
     * Create a new component instance.
     */
    public $target = '';
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.assets.admin_layout');
    }
}
