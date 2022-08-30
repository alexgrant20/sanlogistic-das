<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
  public string $id;
  public string $class;
  public string $title;
  public string $size;

  public function __construct($id, $title = '', $class = '', $size = '')
  {
    $this->id = $id;
    $this->class = $class;
    $this->title = $title;
    $this->size = $size;
  }

  public function render()
  {
    return view('components.modal');
  }
}