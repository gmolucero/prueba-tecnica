<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidentModel extends Model
{
    protected $table = 'incidents';

    public function getAll()
    {
        return $this->findAll();
    }

    public function getIncident($id)
    {
        return $this->find($id);
    }
}
