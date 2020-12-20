$(".Dynamic_row").each(function( index ) {
	var	object = $( this );

	$("#addRow").click(function () {

        var html = $("#model").html();

        $('.Dynamic_row').append(html);
    });

    // remove row
    $(document).on('click', '.removeRow', function () {
		console.log(this);
        $(this).closest('.input-group').remove();
	});

});