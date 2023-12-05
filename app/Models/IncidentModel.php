<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class IncidentModel
 * @package App\Models
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property string $date
 * @property string $status
 * @property int $reported_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class IncidentModel extends Model
{
    // Database table
    protected $table = 'incidents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';

    // Soft deletes
    protected $useSoftDeletes = true;

    // Fields
    protected $allowedFields = ['title', 'description', 'location', 'date', 'status', 'reported_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[30]',
        'location' => 'required|min_length[3]|max_length[255]',
        'date' => 'required',
        'status' => 'required',
        'reported_by' => 'required',
    ];
    protected $validationMessages   = [
        'title' => [
            'required' => 'El titulo es requerido',
            'min_length' => 'El titulo debe tener al menos 3 caracteres',
            'max_length' => 'El lugar debe tener maximo 255 caracteres',
        ],
        'description' => [
            'required' => 'La descripcion es requerida',
            'min_length' => 'La descripcion debe tener al menos 50 caracteres',
        ],
        'location' => [
            'required' => 'El lugar es requerido',
            'min_length' => 'El lugar debe tener al menos 3 caracteres',
            'max_length' => 'El lugar debe tener maximo 255 caracteres',
        ],
        'date' => [
            'required' => 'La fecha es requerida',
        ],
        'status' => [
            'required' => 'El estado es requerido',
        ],
        'reported_by' => [
            'required' => 'El reportado por es requerido',
        ],
    ];


    // Callbacks
    protected $allowCallbacks = true;
    protected $afterInsert = ['logCreate'];
    protected $afterUpdate = ['logUpdate'];
    protected $afterDelete = ['logDelete'];

    /**
     * @param array $options
     * @return array
     */
    public function getAll()
    {
        $result = $this->select('incidents.*, users.username AS user')
            ->join('users', 'incidents.reported_by = users.id', 'inner')
            ->findAll();
        return $result;
    }

    /**
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        $result = $this->select('incidents.*, users.username AS user')
            ->join('users', 'incidents.reported_by = users.id', 'inner')
            ->find($id);
        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function newIncident($data)
    {
        $data['status'] = "Nuevo";
        $data['reported_by'] = user_id();
        return $this->insert($data);
    }

    /**
     * @param array $options
     * @return array
     */
    public function updateIncident($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param array $options
     * @return array
     */
    public function logCreate(array $dataArray)
    {
        $this->logger($dataArray, 'create');
    }

    /**
     * @param array $options
     * @return array
     */
    public function logUpdate(array $dataArray)
    {
        $this->logger($dataArray, 'update');
    }

    /**
     * @param array $options
     * @return array
     */
    public function logDelete(array $dataArray)
    {
        $this->logger($dataArray, 'delete');
    }

    /**
     * @param array $options
     * @return array
     */
    public function logger($dataArray, $action)
    {
        $db = \Config\Database::connect();
        $id = (is_array($dataArray['id']) ? $dataArray['id'][0] : $dataArray['id']);
        $data = (isset($dataArray['data']) ? $dataArray['data'] : []);
        $insertData = array_merge(
            $data,
            [
                'incident_id' => $id,
                'action' => $action,
                'user_id' => user_id(),
                'action_date' => date('Y-m-d H:i:s'),
                'success' => $dataArray['result'],
            ]
        );
        $builder = $db->table('incidents_history');
        $builder->insert($insertData);
    }
}
