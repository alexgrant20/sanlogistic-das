<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuItem extends Component
{

  public string $icon;
  public string $link;
  public string $backgroundColor;
  public string $label;
  public string $description;


  public function __construct(string $icon, string $link, string $backgroundColor, string $label, string $description)
  {
    $this->icon = $icon;
    $this->link = $link;
    $this->backgroundColor = $backgroundColor;
    $this->label = $label;
    $this->description = $description;
  }
  public function render()
  {
    return view('components.ui.menu-item');
  }
}