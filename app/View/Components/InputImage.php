<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputImage extends Component
{
  public string $id;
  public string $label;
  public bool $required;
  public string $imagePath;

  public function __construct(string $id, string $label, bool $required = false, string $imagePath = "")
  {
    $this->id = $id;
    $this->label = $label;
    $this->required = $required;
    $this->imagePath = $imagePath;
  }

  public function render()
  {
    return view('components.input-image');
  }
}