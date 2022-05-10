<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Campaigns extends Component
{
    public $campaigns;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.campaigns');
    }
}
