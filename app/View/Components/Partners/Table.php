<?php

namespace App\View\Components\Partners;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    public $partners;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $partners)
    {
        $this->partners = $partners;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partners.table');
    }
}
