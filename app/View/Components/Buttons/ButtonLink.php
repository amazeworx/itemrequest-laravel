<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class ButtonLink extends Component
{
  public $style, $theme, $icon;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($style = '', $theme = '', $icon = '')
  {
    $this->style = $style;
    $this->theme = $theme;
    $this->icon = $icon;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.buttons.button-link');
  }
}
