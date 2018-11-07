jQuery(document).ready(function($){
    $(document).scroll(function(){
        if($(".product-menu").hasClass("hide")){
            if($(".header-wrapper").hasClass("stuck")){
                $(".product-menu").show(300);
                $(".product-menu").removeClass("hide");
            }
        }
        else{
            if($(window).scrollTop() === 0){
                $(".product-menu").hide(300);
                $(".product-menu").addClass("hide");
            }
        }
    });
});