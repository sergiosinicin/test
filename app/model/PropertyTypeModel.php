<?php

namespace App\Model;

use App\System\Library\Database;
use PDO;


class PropertyTypeModel
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
     * @return array
     */
    public function getAll()
    {
        $this->db->query("SELECT * FROM property_type");

        $results = $this->db->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    /**
     * @return array
     */
    public function getAllIndexed()
    {
        $result = [];
        $types = $this->getAll();
        foreach ($types as $type) {
            $id = $type['id'];
            $result[$id] = $type;
        }

        return $result;
    }

    /**
     * //TODO: rename to update
     * @param $data
     * @return int
     */
    public function updatePropertyType($data)
    {
        $this->db->query('UPDATE property_type 
                        SET title = :title, 
                            description = :description,
                            created_at = :created_at,
                            updated_at = :updated_at
                        WHERE id = :id');

        $this->bindValues($data);

        $this->db->execute();

        return $this->db->rowCount();
    }

    /**
     * //TODO: rename to insert
     * @param $data
     * @return int
     */
    public function addPropertyType($data)
    {
        $this->db->query('INSERT INTO property_type (id,title,description,created_at,updated_at) 
                        VALUES (:id,:title,:description,:created_at,:updated_at)'
        );

        $this->bindValues($data);

        $this->db->execute();

        return $this->db->getLastId();
    }

    private function bindValues($data)
    {
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':updated_at', $data['updated_at']);
    }
}
