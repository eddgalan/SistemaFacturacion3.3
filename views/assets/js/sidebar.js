$(document).ready(function(){
    //  Muestra/Oculta el sidebar
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    //Despliega las subsecciones de cada sección
    $(".seccion").click(function(){
        var panel = this.nextElementSibling;
        // this.classList.toggle("section_active");
        var class_name = $(this).attr('class');
        if(class_name.search("section_active") != -1){
          $(this).removeClass('section_active');
          $(this).addClass('section_inactive');
          $(panel).slideUp("fast");
        }else{
          $(this).addClass('section_active');
          $(this).removeClass('section_inactive');
          $(panel).slideDown("fast");
        }
        // var panel = this.nextElementSibling;
        // $(panel).slideToggle("fast");

    });
});
