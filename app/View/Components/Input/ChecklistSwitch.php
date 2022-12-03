<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class ChecklistSwitch extends Component
{
  public string $id;
  public string $label;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($id, $label = "")
  {
    $this->id = $id;
    $this->label = $label ? $label : ucwords(str_replace('_', ' ', $id));
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.input.checklist-switch');
  }
}