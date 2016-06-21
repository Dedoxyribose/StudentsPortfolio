$(document).ready(function() { // либо $(function() {
    $('#surnameS').click(function(){
        $.ajax({
            url:"changefield.php?id=",
            cache: false,
            success: function(responce){ 
                alert('Yay!');
            }
        }
    });
})