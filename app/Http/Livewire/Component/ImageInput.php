<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImageInput extends Component
{

  use WithFileUploads;

  public $label;
  public $name;
  public $image;

  public function render()
  {
    return view('livewire.component.image-input');
  }
}