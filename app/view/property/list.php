<?php include(DIR_TEMPLATE.'common/header.php'); ?>
<div class="row align-items-center">
    <div class="col-md-12 col-md-right">
        <button type="button" class="btn btn-warning btn-sm float-left" id="populate-db" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing ...">Populate Db</button>
        <a id="add-property" class="text-white btn btn-primary btn-sm float-right" style="margin-bottom: 5px;">Add Property</a>
        <table class="table table-bordered table-striped" id="properties-list">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">County</th>
                <th scope="col">Country</th>
                <th scope="col">Town</th>
                <th scope="col">Description</th>
                <th scope="col">Address</th>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Number of bedrooms</th>
                <th scope="col">Number of bathrooms</th>
                <th scope="col">Price</th>
                <th scope="col">Property Type</th>
                <th scope="col">Sale / Rent</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($data['data'])) { ?>
            <?php foreach ($data['data'] as $item) { ?>
                <td><img src="<?php echo $item['image_thumbnail']; ?>"/></td>
                <td><?php echo $item['county']; ?></td>
                <td><?php echo $item['country']; ?></td>
                <td><?php echo $item['town']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['address']; ?></td>
                <td><?php echo $item['latitude']; ?></td>
                <td><?php echo $item['longitude']; ?></td>
                <td><?php echo $item['num_bedrooms']; ?></td>
                <td><?php echo $item['num_bathrooms']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $item['property_type']; ?></td>
                <td><?php echo $item['type']; ?></td>
                <td>
                    <a data-propertyid="<?php echo $item['id']; ?>" class="text-white btn btn-info btn-sm view-property"> View </a>
                    <a data-propertyid="<?php echo $item['id']; ?>" class="text-white btn btn-success btn-sm update-property"> Edit </a>
                    <a data-propertyid="<?php echo $item['id']; ?>" class="text-white btn btn-danger btn-sm delete-property"> Delete</a>
                </td>

                </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include(DIR_TEMPLATE.'common/footer.php'); ?>
<?php include(DIR_TEMPLATE.'property/modal.php');?>

