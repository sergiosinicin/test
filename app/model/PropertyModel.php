<?php

namespace App\Model;

use App\System\Library\Database;
use PDO;


class PropertyModel
{
    /**
     * @var Database
     */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param  array  $parameters
     * @return array
     */
    public function fetchAll(array $parameters = [])
    {
        $condition = $this->parseConditions($parameters);

        $sql = "SELECT p.*,pt.title as property_type,pt.description as property_type_description
                FROM property AS p
                LEFT JOIN property_type AS pt ON p.property_type_id = pt.id 
                WHERE 1 ".$condition."
                LIMIT :start, :length";

        $this->db->query($sql);
        //WHERE  :condition
        //$this->db->bind(':condition', $condition);
        $this->db->bind(':start', (int) $parameters['start'] ?? 0, PDO::PARAM_INT);
        $this->db->bind(':length', (int) $parameters['length'] ?? 10, PDO::PARAM_INT);

        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * TODO: ???
     * @param  string  $condition
     * @return mixed
     */
    private function getTotalFiltered(string $condition)
    {
        $sql = "SELECT COUNT(*) AS filtered
                FROM property AS p
                LEFT JOIN property_type AS pt ON p.property_type_id = pt.id 
                WHERE 1 ".$condition;

        $this->db->query($sql);

        return $this->db->single(PDO::FETCH_ASSOC);
    }

    /**
     * TODO: move to  datatable service
     * @param  array  $parameters
     * @return string
     */
    private function parseConditions(array $parameters = [])
    {
        $condition = '';
        if (!empty($parameters['search'])) {
            $search = [];
            foreach ($parameters['search'] as $column => $value) {
                $table = 'p.';
                if ($column == 'property_type') {
                    $table = 'pt.';
                    $column = 'title';
                }
                $search[] = $table.$column." LIKE '%{$value}%'";
            }

            $condition = ' AND '.implode(' AND ', $search);
        }

        return $condition;
    }

    public function getTotalRows()
    {
        $sql = 'SELECT COUNT(*) AS total FROM property';
        $this->db->query($sql);

        return $this->db->single();
    }


    /**
     * @param  string  $uuid
     * @return array|null
     */
    public function getByUuid(string $uuid)
    {
        $this->db->query('SELECT * FROM property WHERE uuid=:uuid');

        $this->db->bind(':uuid', $uuid);
        $result = $this->db->single();

        return $result;
    }

    /**
     * @param  int  $id
     * @return array|null
     */
    public function getById(int $id)
    {
        $this->db->query('SELECT * FROM property WHERE id=:id');

        $this->db->bind(':id', $id);
        $result = $this->db->single(PDO::FETCH_ASSOC);

        return $result;
    }


    /**
     * @param  int  $propertyId
     * @param  array  $data
     * @return int
     */
    public function update(int $propertyId, array $data)
    {
        $this->db->query('UPDATE property 
                        SET uuid = :uuid, 
                            county = :county, 
                            country = :country, 
                            town = :town, 
                            address = :address, 
                            longitude = :longitude, 
                            latitude = :latitude, 
                            num_bedrooms = :num_bedrooms, 
                            num_bathrooms = :num_bathrooms, 
                            image_thumbnail = :image_thumbnail, 
                            image_full = :image_full, 
                            description = :description, 
                            price = :price, 
                            type = :type, 
                            property_type_id = :property_type_id, 
                            created_at = :created_at, 
                            updated_at = :updated_at 
                        WHERE id = :id');

        $this->bindValues($data);
        $this->db->bind(':id', $propertyId);

        $this->db->execute();

        return $this->db->rowCount();
    }

    /**
     * @param  array  $data
     * @return int
     */
    public function insert(array $data)
    {
        $this->db->query('INSERT INTO property
                        SET uuid = :uuid, 
                            county = :county, 
                            country = :country, 
                            town = :town, 
                            address = :address, 
                            longitude = :longitude, 
                            latitude = :latitude, 
                            num_bedrooms = :num_bedrooms, 
                            num_bathrooms = :num_bathrooms, 
                            image_thumbnail = :image_thumbnail, 
                            image_full = :image_full, 
                            description = :description, 
                            price = :price, 
                            type = :type, 
                            property_type_id = :property_type_id, 
                            created_at = :created_at, 
                            updated_at = :updated_at '
        );


        $this->bindValues($data);
        $this->db->execute();

        return $this->db->getLastId();
    }

    /**
     * @param  int  $id
     * @return int
     */
    public function delete(int $id)
    {
        $this->db->query('DELETE FROM property WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        return $this->db->rowCount();
    }

    /**
     * @param  array  $data
     */
    private function bindValues(array $data)
    {
        // Bind Values
        $this->db->bind(':uuid', $data['uuid']);
        $this->db->bind(':county', $data['county']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':town', $data['town']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':longitude', $data['longitude'] ?? null);
        $this->db->bind(':latitude', $data['latitude'] ?? null);
        $this->db->bind(':num_bedrooms', $data['num_bedrooms']);
        $this->db->bind(':num_bathrooms', $data['num_bathrooms']);
        $this->db->bind(':image_thumbnail', $data['image_thumbnail'] ?? null);
        $this->db->bind(':image_full', $data['image_full'] ?? null);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':property_type_id', $data['property_type_id']);
        $this->db->bind(':created_at', $data['created_at'] ?? null);
        $this->db->bind(':updated_at', $data['updated_at'] ?? null);
    }
}
