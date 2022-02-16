<?php

namespace App\View\Components;

use App\Models\Campaign;
use Illuminate\View\Component;

class Analytics extends Component
{
    public $campaign;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analytics');
    }
}
