<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Page\Models\Page;

class RecentPages extends Component
{
    public $limit;

    public function render()
    {
        $limit = $this->limit;

        $limit = $limit > 0 ? $limit : 5;

        $recentPages = Page::recentlyPublished()->take($limit)->get();

        return view('livewire.recent-pages', compact('recentPages'));
    }
}
