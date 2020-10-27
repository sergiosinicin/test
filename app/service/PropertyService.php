<?php

namespace App\Service;

use App\Formatter\ArrayFormatter;
use App\Model\PropertyModel;
use App\Model\PropertyTypeModel;
use App\System\Library\Curl;

class PropertyService
{
    /** @var PropertyModel */
    private $propertyModel;
    /** @var PropertyTypeModel */
    private $propertyTypeModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        $this->propertyTypeModel = new PropertyTypeModel();
    }

    /**
     * @param  int  $page
     * @param  int  $size
     * @return array|mixed
     * @throws \Exception
     */
    public function populateDb($page = 1, $size = 50)
    {
        $propertyTypeItems = ArrayFormatter::setUniqueKey($this->propertyTypeModel->getAll(), 'id');

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
                            $this->propertyTypeModel->update($item['property_type']);
                        }
                    } else {
                        $this->propertyTypeModel->insert($item['property_type']);
                        $propertyTypeItems = ArrayFormatter::setUniqueKey($this->propertyTypeModel->getAll(), 'id');
                    }

                    $item['property_type_id'] = $item['property_type']['id'];

                    $item = saveImageByUrl($item);

                    $property = $this->propertyModel->getByUuid($item['uuid']);
                    if ($propertyId = $property->id) {

                        if ($property->updated_at != $item['updated_at']) {
                            $this->propertyModel->update($propertyId, $item);
                        }
                    } else {
                        $this->propertyModel->insert($item);
                    }
                }

            }
        }

        unset($result['data']);

        return $result;
    }

    public function addProperty(array $data)
    {
        if (true === $json) {
            $data = saveUploadedImage($data);
            $data['uuid'] = generateUUID();
            $this->propertyModel->insert($data);

        }
    }

    public function getPropertyById(int $propertyId)
    {
        $this->propertyModel->getById($propertyId);
    }


    /**
     * TODO: move to  datatable service
     * @param  array  $parameters
     * @return array
     */
    public function getDatatableFormatted(array $parameters = [])
    {
        $data = $this->fetchAll($parameters);
        $total = (int) $this->getTotalRows()->total;
        $filtered = $total;
        if ($condition = $this->parseConditions($parameters)) {
            $filtered = $this->getTotalFiltered($condition)['filtered'];
        }

        return [
            "recordsTotal" => $total,
            "recordsFiltered" => $filtered,
            "data" => $data
        ];
    }

}
