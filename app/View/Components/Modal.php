<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $footer;
    public $size;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $footer, $size = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->footer = $footer;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
