<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RemoveFromGroupModal extends Component
{
    public function __construct(public $groupId)
    {
    }

    public function render()
    {
        return view('components.remove-from-group-modal');
    }
}
