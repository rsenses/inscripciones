<?php

namespace App\View\Components\Registrations;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    public $registrations;
    public $product;
    public $showProduct;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $registrations, Product $product, $showProduct = true)
    {
        $this->registrations = $registrations;
        $this->product = $product;
        $this->showProduct = $showProduct;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.registrations.table');
    }
}
