$(document).ready(function() {

    $(".fancybox").fancybox();

    $('input[name=datanascimento]').mask('99/99/9999');

    $("#btn-language").toggle(
            function() {
                $("#idiomas").slideDown("fast");
            },
            function() {
                $("#idiomas").slideUp("fast");
            }
    );

    $("#idiomas a").click(function() {
        $("#idiomas").slideUp("fast");
    });

    // Zebra na Tabela
    $("tbody tr:even").addClass("even");
    $("td:even").addClass("even");

    $('.filter').alphanumeric({ichars: "*’“'@%#/\[](){}¨$&:;,.?!+|=1234567890ªº"});
    $('.filter2').alphanumeric({ichars: "*’“'@%#/\[](){}¨$&:;.?!+|=ªº"});
    $('.email').alphanumeric({ichars: "*’“'´`^~%#/\[](){}¨$&:;,?!+|=ªº "});
    $('.numbers').numeric({ichars: "çÇ*’“'´`^~@%#/\[](){}¨$&:;,?!+-_|=. ªºáÁàÀéÉííóÓúÚãÃâÂ"});
    $('.filter,.filter2,.email').alphanumeric({ichars: '"'});
    $('.numbers').numeric({ichars: '"'});

    $('.form_resposta').css('cursor', 'pointer').click(function() {
        $(this).fadeOut('slow');
    });

})