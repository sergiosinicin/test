<?php

namespace App\Controller;

use App\Service\PropertyService;
use App\System\Library\Controller;


class PropertyController extends Controller
{
    /** @var PropertyService */
    private $propertyService;

    public function __construct()
    {
        parent::__construct();
        $this->propertyService = new PropertyService();
    }

    public function index()
    {
        $data['scripts'] = [
            '/assets/js/datatables.min.js',
            '/assets/js/property.js',
        ];
        $data['styles'] = [
            '/assets/css/datatables.css',
        ];

        $data['property_type'] = $this->propertyService->getPropertyTypes();

        $this->response->output($this->view('property/list', $data));
    }

    /**
     * @param  int  $propertyId
     */
    public function show(int $propertyId)
    {
        try {
            $json['data'] = $this->propertyService->getPropertyById($propertyId);
        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->jsonOutput($json);
    }

    public function delete()
    {
        try {
            $propertyId = $this->request->post('propertyId');
            $this->propertyService->deleteProperty($propertyId);
            $json = ['success' => 'Property deleted successfully'];
        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->jsonOutput($json);
    }

    public function update()
    {
        try {
            $propertyId = $this->request->post('propertyId');
            $data = $this->request->postAll();
            $this->propertyService->updateProperty($propertyId, $data);
            $json = ['success' => 'Property updated successfully'];
        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->jsonOutput($json);
    }

    public function store()
    {
        $data = $this->request->postAll();
        try {
            $this->propertyService->addProperty($data);
            $json = ['success' => 'Property added successfully'];
        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->jsonOutput($json);
    }

    public function fetch()
    {
        $data = $this->request->getAll();
        try {
            $this->propertyService->getProperties($data);
        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }
    }
}
