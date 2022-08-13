<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;

class AddAbonementModal extends Component
{
    public $abonementCost;

    public function __construct()
    {
        $this->abonementCost = Setting::whereName('ticketAmount')->pluck('value')->first();
    }

    public function render()
    {
        return view('components.add-abonement-modal');
    }
}
