<?php

namespace App\Validator;

use Exception;

class PropertyValidator
{
    public function validate($data)
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
                throw new Exception('$field is required');
            }
        }

        return $data;
    }
}
