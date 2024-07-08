<?php

namespace App\Services;

use App\Models\Status;

class StatusService {

    public function getAllStatuses()
    {
        $statuses = Status::all();

        return $statuses;
    }

    public function getStatus($id)
    {
        $status = Status::find($id);
        
        return $status;
    }
}