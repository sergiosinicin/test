<?php include(DIR_TEMPLATE.'common/header.php'); ?>
<div class="row align-items-center">
    <div class="col-md-12 col-md-right">
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
            <tbody></tbody>
        </table>
    </div>
</div>
<?php include(DIR_TEMPLATE.'common/footer.php'); ?>
<?php include(DIR_TEMPLATE.'property/modal.php');?>

