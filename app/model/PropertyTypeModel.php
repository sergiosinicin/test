<?php

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

        $results = $this->db->resultset(PDO::FETCH_ASSOC);

        return $results;
    }

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
     * @param $id
     * @return array|null
     */
    public function getById(int $id)
    {
        $this->db->query('SELECT * FROM property_type WHERE id=:id');

        $this->db->bind(':id', $id);
        $result = $this->db->single();

        return $result;
    }

    /**
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

        // Bind Values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':updated_at', $data['updated_at']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    /**
     * @param $data
     * @return int
     */
    public function addPropertyType($data)
    {
        $this->db->query('INSERT INTO property_type (id,title,description,created_at,updated_at) 
                        VALUES (:id,:title,:description,:created_at,:updated_at)'
        );

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':updated_at', $data['updated_at']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    /**
     * @param  int  $id
     * @return int
     */
    public function deletePropertyType(int $id)
    {
        $this->db->query('DELETE FROM property_type WHERE id = :id');
        $this->db->bind(':id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }
}
