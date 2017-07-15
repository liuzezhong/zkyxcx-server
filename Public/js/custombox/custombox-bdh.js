/*
 ----------------------------
 Demo
 ----------------------------
 */
$(function() {
    $('#list-group-item').on('click', function( e ) {
        Custombox.open({
            target: '#modal',
            effect: 'fadein'
        });
        e.preventDefault();
    });

    
});