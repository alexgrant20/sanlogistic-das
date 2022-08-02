<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuItem extends Component
{

  public string $icon;
  public string $link;
  public string $backgroundColor;
  public string $label;


  public function __construct(string $icon, string $link, string $backgroundColor, string $label)
  {
    $this->icon = $icon;
    $this->link = $link;
    $this->backgroundColor = $backgroundColor;
    $this->label = $label;
  }
  public function render()
  {
    return view('components.ui.menu-item');
  }
}