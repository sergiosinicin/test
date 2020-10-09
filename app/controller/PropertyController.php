<?php


class PropertyController extends Controller
{
    /** @var PropertyModel */
    private $propertyModel;
    /** @var PropertyTypeModel */
    private $propertyTypeModel;

    public function __construct()
    {
        parent::__construct();
        $this->propertyModel = $this->model('PropertyModel');
        $this->propertyTypeModel = $this->model('PropertyTypeModel');
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

        $data['property_type'] = $this->propertyTypeModel->getAll();

        $this->view('property/list', $data);
    }

    /**
     * @param  int  $page
     * @param  int  $size
     * @return int
     */
    public function populateDb($page = 1, $size = 50)
    {
        $propertyTypeItems = $this->propertyTypeModel->getAllIndexed();
        $size = $size > 100 ? 100 : $size;
        $url = API_ADDRESS.'?api_key='.API_KEY."&page[number]={$page}&page[size]={$size}";
        $curl = new Curl($url);
        $curl->query();
        $result = [];

        if ($curl->getHttpCode() === 200) {
            $result = $curl->getJson();

            foreach ($result['data'] as $item) {

                if (isset($item['property_type']['id'])) {

                    $propertyType = $propertyTypeItems[$item['property_type']['id']] ?? null;

                    if ($propertyType) {
                        if ($propertyType['updated_at'] != $item['property_type']['updated_at']) {
                            $this->propertyTypeModel->updatePropertyType($item['property_type']);
                        }
                    } else {
                        $this->propertyTypeModel->addPropertyType($item['property_type']);
                        $propertyTypeItems = $this->propertyTypeModel->getAllIndexed();
                    }

                    $item['property_type_id'] = $item['property_type']['id'];

                    $item = saveImageByUrl($item);

                    $property = $this->propertyModel->getByUuid($item['uuid']);
                    if ($property) {
                        $propertyId = $property->id;
                        if ($property->updated_at != $item['updated_at']) {
                            $this->propertyModel->updateProperty($propertyId, $item);
                        }
                    } else {
                        $this->propertyModel->addProperty($item);
                    }
                }

            }
        }

        unset($result['data']);

        return $result;
    }

    /**
     * @param  int  $propertyId
     */
    public function getProperty(int $propertyId)
    {
        if ($propertyId) {
            $result = $this->propertyModel->getById($propertyId);
            if ($result) {
                $json['data'] = $result;
            } else {
                $json = ['error' => 'Property not found, refresh page'];
            }
        } else {
            $json = ['error' => 'Unknown id, refresh form'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function delete()
    {
        $propertyId = $this->request->post('property_id');
        if ($propertyId) {
            $this->propertyModel->deleteProperty($propertyId);
            $json = ['success' => 'Property added successfully'];
        } else {
            $json = ['error' => 'Unknown id, refresh form'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function update()
    {
        if ($propertyId = $this->request->post('property_id')) {
            $data = $this->request->postAll();
            $json = $this->validateForm($data);
            if (true === $json) {
                $property = $this->propertyModel->getById($propertyId);
                $data = saveUploadedImage($data);
                $data = array_merge($property, $data);
                $this->propertyModel->updateProperty($propertyId, $data);
                $json = ['success' => 'Property updated successfully'];
            }
        } else {
            $json = ['error' => 'Unknown id, refresh form'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function create()
    {
        $data = $this->request->postAll();
        $json = $this->validateForm($data);
        if (true === $json) {
            $data = saveUploadedImage($data);
            $data['uuid'] = generateUUID();
            $this->propertyModel->addProperty($data);
            $json = ['success' => 'Property added successfully'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function getProperties()
    {
        $parameters = [
            'start' => $this->request->post('start', 0),
            'length' => $this->request->post('length', 10),
            'search' => [],
        ];

        $columns = $this->request->post('columns');
        foreach ($columns as $item) {
            if ($item['searchable'] == 'true' && $item['search']['value']) {
                $key = $item['data'];
                $parameters['search'][$key] = $item['search']['value'];
            }
        }

        $data = $this->propertyModel->getDatatableFormatted($parameters);
        $data["draw"] = (int) $this->request->post('draw', 0);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function validateForm($data)
    {
        $requiredFields = [
            'county',
            'country',
            'town',
            'address',
//            'longitude',
//            'latitude',
            'num_bedrooms',
            'num_bathrooms',
            // 'image_thumbnail',
            //  'image_full',
            'description',
            'price',
            'type',
            'property_type_id'
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['error' => 'Please, fill required fields', 'field' => $field];
            }
        }

        return true;
    }

}
