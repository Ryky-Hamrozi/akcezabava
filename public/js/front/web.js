/**
 * Mé jqry
 * Author & copyright (c) 2019: Jan Dorschner
 */
$(document).ready(function(event){
  /** kliknes vedle vypnes */
  $(".modal-handler").on("mousedown", function (event){
    $(".overlay").fadeOut(300);
    $("html").removeClass("overflow-hidden");
    $("body").removeClass("fixed");
    $(".modal-handler").fadeOut(300).animate({opacity: 0}, 300);
  });

  /** ESC BIND */
  $(document).keyup(function(event){
    if(event.keyCode === 27)  {
      $(".overlay").fadeOut(300);
      $("html").removeClass("overflow-hidden");
      $("body").removeClass("fixed");
      $(".modal-handler").fadeOut(300).animate({opacity: 0}, 300);
    }
  });

  /** trida close */
  $(".close, .back2").on("click", function (event) {
    event.preventDefault();
    $(".overlay").fadeOut(300);
    $("html").removeClass("overflow-hidden");
    $("body").removeClass("fixed");
    $(".modal-handler").fadeOut(300).animate({opacity: 0}, 300);
  });

  /** scroll top */
  $(window).scroll(function(){
    if ($(window).scrollTop() > 600) {
      $(".scrollToTop").fadeIn();
    } else {
      $(".scrollToTop").fadeOut();
    }
  });
  //Click event to scroll to top
  $(".scrollToTop").click(function(){
    $("html, body").animate({scrollTop : 0},800);
    return false;
  });

  $slickBlog = $('.slider');
  $slickBlog.slick({
    draggable: true,
    adaptiveHeight: false,
    dots: true,
    arrows: true,
    cssEase: 'ease-in-out',
    infinite: false,
    autoplay: false,
    slidesToShow: 1,
    slidesToScroll: 1
  });

  /*
  // tabs description
  $(".tabs li a").click(function(event) {
    event.preventDefault();
    $(this).parent().addClass("active");
    $(this).parent().siblings().removeClass("active");
    var tab = $(this).attr("href");
    $(".tab-content").not(tab).css("display", "none").removeClass("open");
    $(tab).fadeIn().addClass("open");
  });*/

  // zobrazit radek modal
  $(".ac-btn[name=nahled]").on("click", function (event) {
    $(this).parent().parent("tr").addClass("active");
    event.stopPropagation();
    event.preventDefault();
    event.stopImmediatePropagation();
    $("html").addClass("overflow-hidden");
    $(".modal-content").on("mousedown", function (event){
      event.stopPropagation();
    });
    $("#nahled").css("display", "flex").animate({opacity: 1}, 300);
    $(".overlay").fadeIn(300);
  });

});
