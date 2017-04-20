$(function() {

    var randomColor = (Math.random().toString(16) + '000000').slice(2, 8)

    $("body").css({
    
        backgroundColor: '#' + randomColor
    
    });
    
    $("#colorcode").text("#" + randomColor);

});// JavaScript Document