
$(document).ready(function () {
    $( '.checkAll' ).on( 'click', function() {
        var name = '.check'+$( this ).attr('name');
        console.log(name, $( this ).is( ':checked' ) );
        $( name ).attr( 'checked', $( this ).is( ':checked' ) ? 'checked' : '' );
    });
});