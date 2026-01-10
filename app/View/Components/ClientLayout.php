<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ClientLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // resources/views/layouts/client.blade.php を読み込む指定
        return view('layouts.client');
    }
}
