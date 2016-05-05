<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    public function getMedia($paging = 1, $year = null, $month = null)
    {
        if ($year != null && $month != null) {
            return $this->orderBy('created_at', 'desc')
                ->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->forPage($paging, env('PAGING_MEDIA'))
                ->get();
        } else {
            return $this->orderBy('created_at', 'desc')
                ->forPage($paging, env('PAGING_MEDIA'))
                ->get();
        }
    }
}