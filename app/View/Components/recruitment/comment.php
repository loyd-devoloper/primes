<?php

namespace App\View\Components\recruitment;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class comment extends Component
{
    public $comments = [];
    public $id = '';
    /**
     * Create a new component instance.
     */
    public function __construct($comments,$id)
    {
        $this->comments = $comments;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recruitment.comment');
    }
}
