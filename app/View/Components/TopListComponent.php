<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\Casino;

class TopListComponent extends Component
{
  public $for;
  public $count;
  public $visibleCount;

  public function __construct($for, $count = 10, $visibleCount = 5, $topListItems = [])
  {
    $this->for = $for;
    $this->count = $count;
    $this->visibleCount = $visibleCount;
  }

  public function render()
  {
    $user = Auth::user();

    if ($this->for === 'game') {
      $itemsQuery = Game::orderBy('numberOfPlays', 'desc');
    } elseif ($this->for === 'casino') {
      $itemsQuery = Casino::orderBy('rank', 'desc');
    } else {
      // Invalid type, handle the error or redirect as needed
      abort(404);
    }

    if (Auth::check()) {
      // Get the user's country from the database
      $userCountry = $user->country;

      if ($userCountry) {
        $itemsQuery->where('market', $user->country);
      }
    }

    $topItems = $itemsQuery->take($this->count)->get();

    $topListItems = $topItems->take($this->visibleCount);

    return view('components.top-list', [
      'topListItems' => $topListItems,
      'logoOrScreenshotKey' => $this->for === 'game' ? 'screenshot' : 'logo',
      'linkOrUrlKey' => $this->for === 'game' ? 'link' : 'url',
    ]);
  }
}
