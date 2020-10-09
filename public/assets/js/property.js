document.addEventListener("DOMContentLoaded", function () {
	let url = '/property';
	let properties = $('#properties-list').DataTable({
		"processing": true,
		"serverSide": true,
		"pageLength": 10,

		"dom": "Brtip",
		"pagingType": "full_numbers",
		"responsive": true,

		"buttons": [
			{
				"extend" : 'excelHtml5',
				"exportOptions" : {
					"columns" : ':visible'
				}
			},
			{
				"extend" : 'pdfHtml5',
				"exportOptions" : {
					"columns" : ':visible'
				}
			},
			{
				"extend" : 'print',
				"exportOptions" : {
					"columns" : [ 0,1,2,3,4 ]
				}
			},
			"colvis",
		],
		"columns": [
			{
				"data":"image_thumbnail",
                "searchable":false,
				"render": function (data) {
					return '<img src="' + data + '" alt="">';
				}
			},
			{ "data": "county" },
			{ "data": "country","searchable":false },
			{ "data": "town","searchable":false },
			{ "data": "description","searchable":false },
			{ "data": "address","searchable":false },
			{ "data": "latitude","searchable":false },
			{ "data": "longitude","searchable":false },
			{ "data": "num_bedrooms" },
			{ "data": "num_bathrooms","searchable":false },
			{ "data": "price" },
			{ "data": "property_type" },
			{ "data": "type" },
			{
				"data":"id",
				"render": function (data) {
					return '<a data-propertyid="' + data + '" class="text-white btn btn-success btn-sm edit-property"> Edit </a>' +
						'<a data-propertyid="'+data+'" class="text-white btn btn-danger btn-sm delete-property"> Delete</a>';
				}
			},
		],

		"ajax": {
			url: url + '/getProperties',
			type: "POST",
			dataType: "json"
		},
	});

    $('#properties-list thead tr').clone(true).appendTo( '#properties-list thead' );
    $('#properties-list tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        let text = '';
        if($.inArray(i,[1,8,10,11,12]) !== -1) {
            text = '<input type="text" class="form-control" placeholder="Search '+title+'" />';
        }
        $(this).html( text );

        $( 'input', this ).on( 'keyup change', function () {
            if ( properties.column(i).search() !== this.value ) {
                properties
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

	$(document).on('click', '#add-property', function() {
		$('#property-modal').modal('show');
		$('#property-form')[0].reset();
		$('.modal-title').html("Add Properties");
		$('#propertyid').val('');
		$('#property-btn').val('Add');
		$('#action').val('create');
	});

	properties.on('click', '.edit-property', function () {
		let propertyId = $(this).data("propertyid");
		$.ajax({
			url: url+'/getProperty/'+ propertyId,
			method:"GET",
			dataType:"json",
			success:function(json){
				$.each(json.data, function (i, v) {
					if($.inArray(i,['num_bedrooms','num_bathrooms','property_type_id']) !== -1) {
						$('#'+i ).find('option[value="'+v+'"]').attr('selected','selected')
					} else if (i === 'image_thumbnail') {
						$('#' + i).attr('src', v);
					} else if (i === 'type') {
						$.each($('input[name="type"]'),function(i,type){
							if ($(type).val() === v) {
								$(type).trigger('click');
							}
						})

					} else{
						$('#'+i).val(v);
					}

				});
				$('#propertyid').val(json.data.id);
				$('#action').val('update');
				$('.modal-title').html("Edit property");
				$('#property-btn').val('Update');
				$('#property-modal').modal('show');
			}
		})
	}).on('click', '.delete-property', function(){
		if(confirm("Are you sure you want to delete this properties?")) {
			let propertyId = $(this).data("propertyid");
			$.ajax({
				url:url+'/delete',
				method:"POST",
				data: {property_id: propertyId},
				success:function(data) {
					properties.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

	$(document).on('submit','#property-form', function(e){
		e.preventDefault();

		let form = $(this);
		let formData = false;
		if (window.FormData) {
			formData = new FormData(form[0]);
        }
		$('.js-alert').remove();

		$.ajax({
			url:url+'/'+$('#action').val(),
			data: formData ? formData : form.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
			 beforeSend: function () {
	            $('button#property-btn').button('loading');
	        },
	        complete: function () {
	            $('button#property-btn').button('reset');
	            $('#property-form')[0].reset();
	            $('#property-modal').modal('hide');
	        },
			success:function(data){
				console.log(data);
				if(data.error && data.field) {
					let html = '<div class="alert alert-warning js-alert">Field is required!</div>';
					$('#'+data.field).after(html);
				} else {
					properties.ajax.reload();
					$('#property-form')[0].reset();
				}

			}
		})
	});
});
