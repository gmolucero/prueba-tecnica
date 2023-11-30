<?php

namespace App\Controllers;

use App\Models\IncidentModel;

class IncidentsController extends BaseController
{



    public function index()
    {
        $model = model(IncidentModel::class);
        $incidents = $this->incidentModel->getAll();
        return view('incidents/index', ['incidents' => $incidents]);
    }

    // public function create()
    // {

    //     return view('incidents/create');
    // }


    // public function edit($id)
    // {
    //     $this->load->model->getIncident($id);
    //     return view('incidents/create');
    // }


    // public function delete($id)
    // {
    //     $this->load->model->delete($id);
    //     return redirect()->to('/incidents');
    // }
}
