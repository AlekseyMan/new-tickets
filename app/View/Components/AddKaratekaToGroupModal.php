<?php

namespace App\View\Components;

use App\Models\Group;
use App\Models\Profile;
use Illuminate\View\Component;

class AddKaratekaToGroupModal extends Component
{
    public $karateki;
    public $group;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($groupId)
    {
        $this->karateki =  Profile::karateki()->get();
        $this->group = Group::find($groupId);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-karateka-to-group-modal');
    }
}
