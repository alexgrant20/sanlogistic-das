<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SummaryBox extends Component
{
  public string $id;
  public string $size;
  public string $link;
  public string $customCardClass;
  public string $icon;
  public string $summaryTitle;
  public string $summaryTotalColor;
  public string $summaryTotal;
  public bool $detail;
  public bool $active;
  public bool $disabled;

  public function __construct(
    $id,
    $icon,
    $summaryTotal,
    $summaryTitle,
    $size = 'col-md-3 col-sm-6',
    $link = '#',
    $customCardClass = '',
    $summaryTotalColor = 'text-secondary',
    $detail = false,
    $active = false,
    $disabled = false
  ) {
    $this->id = $id;
    $this->size = $size;
    $this->link = $link;
    $this->customCardClass = $customCardClass;
    $this->icon = $icon;
    $this->summaryTitle = $summaryTitle;
    $this->summaryTotalColor = $summaryTotalColor;
    $this->summaryTotal = $summaryTotal;
    $this->detail = $detail;
    $this->active = $active;
    $this->disabled = $disabled;
  }

  public function render()
  {
    return view('components.summary-box');
  }
}