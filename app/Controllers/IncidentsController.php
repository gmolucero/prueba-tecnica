<?php

namespace App\Controllers;

use App\Models\IncidentModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


/**
 * IncidentsController
 */
class IncidentsController extends BaseController
{

    /**
     * @var array
     */
    private const STATUS = [
        'Nuevo' => 'Nuevo',
        'Pendiente' => 'Pendiente',
        'En progreso' => 'En progreso',
        'Resuelto' => 'Resuelto',
        'Rechazado' => 'Rechazado',
        'Duplicado' => 'Duplicado',
        'Revisión' => 'Revisión',
        'Reabierto' => 'Reabierto',
        'En espera' => 'En espera',
        'Cerrado' => 'Cerrado',
    ];

    /**
     * @var IncidentModel
     */
    private $incidentModel;

    /**
     * initController
     *
     * @param  mixed $request
     * @param  mixed $response
     * @param  mixed $logger
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->incidentModel = model(IncidentModel::class);
        helper('form', 'url', 'auth', 'session', 'security');
    }

    /**
     * Display a listing of incidents.
     *
     * @return mixed
     */
    public function index()
    {
        $incidents = $this->incidentModel->getAll();
        return view('incidents/index', ['title' => "Incidentes", 'incidents' => $incidents]);
    }

    /**
     * Display the specified incident.
     *
     * @param int $id
     * @return mixed
     */
    public function create()
    {
        $incident = null;
        if ($this->request->is('post')) {

            $rules = $this->incidentModel->getValidationRules(['except' => ['id', 'status', 'reported_by']]);
            $errors = $this->incidentModel->getValidationMessages();
            $incident = (object) $this->request->getPost();

            if (!$this->validate($rules, $errors)) {
                return view(
                    'incidents/create',
                    [
                        'title' => "Nuevo incidente",
                        'errors' => (object) $this->validator->getErrors(),
                        'incident' => $incident,
                        'statusList' => self::STATUS,
                        'error_message' => "El Formulario contiene errores, por favor revisa y corrige antes de continuar."
                    ]
                );
            }
            $validData = $this->validator->getValidated();
            $value  = $this->incidentModel->newIncident($validData);
            if (!$value) {
                return view(
                    'incidents/create',
                    [
                        'title' => "Nuevo incidente",
                        'errors' => (object) $this->validator->getErrors(),
                        'incident' => $incident,
                        'statusList' => self::STATUS,
                        'error_message' => "Error al guardar!!!!"
                    ]
                );
            }

            return redirect()->to('/incidents')->with('success', 'Incidente creado correctamente');
        }
        return view('incidents/create', ['title' => "Nuevo incidente"]);
    }

    /**
     * Display the specified incident and edit it. 
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
        $incident = $this->incidentModel->getById($id);
        $title = "Editar incidente";
        if ($this->request->is('post')) {

            $rules = $this->incidentModel->getValidationRules();
            $errors = $this->incidentModel->getValidationMessages();
            $incident = (object) $this->request->getPost();

            if (!$this->validate($rules, $errors)) {
                return view(
                    'incidents/create',
                    [
                        'title' => $title,
                        'errors' => (object) $this->validator->getErrors(),
                        'incident' => $incident,
                        'hidden' => ['id' => $incident->id, 'reported_by' => $incident->reported_by],
                        'statusList' => self::STATUS,
                        'error_message' => "El Formulario contiene errores, por favor revisa y corrige antes de continuar."
                    ]
                );
            }
            $validData = $this->validator->getValidated();
            $value  = $this->incidentModel->updateIncident($incident->id, $validData);
            if (!$value) {
                return view(
                    'incidents/create',
                    [
                        'title' => $title,
                        'errors' => (object) $this->validator->getErrors(),
                        'incident' => $incident,
                        'hidden' => ['id' => $incident->id, 'reported_by' => $incident->reported_by],
                        'statusList' => self::STATUS,
                        'error_message' => "Error al guardar!!!!"
                    ]
                );
            }
            return redirect()->to('/incidents')->with('success', 'Incidente actualizado correctamente');
        }
        return view(
            'incidents/create',
            [
                'title' => $title,
                'incident' => $incident,
                'statusList' => self::STATUS,
                'hidden' => ['id' => $incident->id, 'reported_by' => $incident->reported_by],
            ]
        );
    }

    /**
     * Delete the specified incident.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        if ($this->request->is('post')) {
            if (!$this->incidentModel->delete($id)) {
                return redirect()->to('/incidents')->with('error', 'Error al eliminar el incidente');
            }
        }
        return redirect()->to('/incidents');
    }
}
