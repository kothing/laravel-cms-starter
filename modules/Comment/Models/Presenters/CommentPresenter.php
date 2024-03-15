<?php

namespace Modules\Comment\Models\Presenters;

use Carbon\Carbon;

trait CommentPresenter
{
    public function getPublishedAtFormattedAttribute()
    {
        $diff = Carbon::now()->diffInHours($this->published_at);

        if ($diff < 24) {
            return $this->published_at->diffForHumans();
        }

        return $this->published_at->isoFormat('llll');
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status) {
            case '0':
                return '<span class="badge bg-warning text-dark">@lang("Pending")</span>';
                break;

            case '1':
                return '<span class="badge bg-success">@lang("Pubished")</span>';
                break;

            case '2':
                return '<span class="badge bg-danger">@lang("Rejected")</span>';
                break;

            default:
                return '<span class="badge bg-primary">@lang("Status"):'.$this->status.'</span>';
                break;
        }
    }
}
