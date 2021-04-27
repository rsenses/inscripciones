<?php

namespace App\View\Components\Invoices;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    public $invoices;
    public $toggle;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $invoices, bool $toggle = false)
    {
        $this->invoices = $invoices;
        $this->toggle = $toggle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.invoices.table');
    }
}
