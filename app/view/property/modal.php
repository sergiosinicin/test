<div class="modal fade" id="property-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="form-horizontal" id="property-form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="action">
                    <input type="hidden" name="property_id" id="propertyid">
                    <div class="form-group">
                        <label class="form-check-label" for="county">County*</label>
                        <input type="text" name="county" class="form-control input-roll-no" placeholder="County"
                               required="required" id="county">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="country">Country*</label>
                        <input type="text" name="country" class="form-control input-roll-no" placeholder="Country"
                               required="required" id="country">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="town">Town*</label>
                        <input type="text" name="town" class="form-control input-roll-no" placeholder="Town"
                               required="required" id="town">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="description">Description*</label>
                        <textarea name="description" class="form-control input-roll-no" placeholder="Description"
                                  required="required" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="address">Address*</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required="required"
                               id="address">
                    </div>
                    <div class="form-group">
                        <label for="file">Image*</label>
                        <input type="file" class="form-control form-control-file"  name="image_full" id="file">
                        <img src="" id="image_thumbnail">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="num_bedrooms">Number of Bedrooms*</label>
                        <select class="form-control" name="num_bedrooms" required="required" id="num_bedrooms">
                            <?php foreach (range(1, 50) as $item) { ?>
                                <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="num_bathrooms">Number of Bathrooms*</label>
                        <select class="form-control" name="num_bathrooms" required="required" id="num_bathrooms">
                            <?php foreach (range(1, 50) as $item) { ?>
                                <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="price">Price*</label>
                        <input type="number" name="price" class="form-control input-roll-no" placeholder="Price"
                               required="required" id="price">
                    </div>
                    <?php if (!empty($data['property_type'])) { ?>
                        <div class="form-group">
                            <label class="form-check-label" for="property_type_id">Property Type</label>
                            <select class="form-control" name="property_type_id" required="required"
                                    id="property_type_id">
                                <?php foreach ($data['property_type'] as $property) { ?>
                                    <option value="<?php echo $property['id']; ?>"><?php echo $property['title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-success active js-type">
                            <input type="radio" name="type" id="type1" value="sale" autocomplete="off" checked> Sale
                        </label>
                        <label class="btn btn-success js-type">
                            <input type="radio" name="type" id="type2" value="rent" autocomplete="off"> Rent
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="property-btn" for="#property-form" value="Add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
