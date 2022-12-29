<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
  public $alertId, $type, $icon, $dismiss;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($alertId = "", $type = "", $icon = false, $dismiss = false)
  {
    $this->alertId = $alertId;
    $this->type = $type;
    $this->icon = $icon;
    $this->dismiss = $dismiss;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.alert');
  }
}
