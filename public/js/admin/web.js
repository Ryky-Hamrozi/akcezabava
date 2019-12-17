/**
 * Mé jqry
 * Author & copyright (c) 2019: Jan Dorschner
 */
$(document).ready(function(event){

  /** kliknes vedle vypnes */
  $(document).on('mousedown','.modal-handler',function(){
    $(".overlay").fadeOut(300);
    $("html").removeClass("overflow-hidden");
    $("body").removeClass("fixed");
    $(".modal-handler").fadeOut(300).animate({opacity: 0}, 300);
    $(".table tr.active").removeClass("active");
  });

  /** ESC BIND */
  $(document).keyup(function(event){
    if(event.keyCode === 27)  {
      $(".overlay").fadeOut(300);
      $("html").removeClass("overflow-hidden");
      $("body").removeClass("fixed");
      $(".modal-handler").fadeOut(300).animate({opacity: 0}, 300);
      $(".table tr.active").removeClass("active");
    }
  });

  // notifikace
  setTimeout(function() {
   $('.notifikace').fadeOut();
  }, 3000 );

  $(document).on('click', '.close, .back',function(event){
      event.preventDefault();
      $(".overlay").fadeOut(300);
      $("html").removeClass("overflow-hidden");
      $("body").removeClass("fixed");
      $(".modal-handler").fadeOut(300).animate({opacity: 0}, 300);
      $(".table tr.active").removeClass("active");
  });
  /** trida close
  $(".close, .back").on("click", function (event) {

  });
*/
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

  /** spinner button */
  var button = document.querySelector(".spinner-spin");
  var buttonParent = document.querySelector(".spinner-master");
  var menu = document.querySelector("aside");
  button.addEventListener("click",function(e){
    buttonParent.classList.toggle("open");
    e.stopPropagation();
    e.stopImmediatePropagation();
    menu.addEventListener("click",function(e){
      e.stopPropagation();
    });
    menu.classList.toggle("isIn");
  });

  /** Menu-button add class */
  $(".spinner-master input").change(function(){
    if($(this).is(":checked")) {
      $("body").addClass("fixed");
      $(".overlay-menu").fadeIn("300");
    } else {
      $("body").removeClass("fixed");
      $(".overlay-menu").fadeOut("300");
    }
  });

  if ($(window).width() < 1024) {
    // navigate devices
    $("nav ul > li.has-sub a").on("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).parent().toggleClass("active");
      $(this).parent().siblings().removeClass("active");
      $(".submenu-container").click(function(event){
        event.stopPropagation();
      });
      $(this).next().toggle();
      $(this).parent().siblings().find("a").next().hide();
    });

    // user logged hover
    $(".logged").on("click", function () {
      $(".login-menu").stop( true, true ).fadeToggle();
    });
  }

  // tabs description
  $(".tabs li a").click(function(event) {
    event.preventDefault();
    $(this).parent().addClass("active");
    $(this).parent().siblings().removeClass("active");
    var tab = $(this).attr("href");
    $(".tab-content").not(tab).css("display", "none").removeClass("open");
    $(tab).fadeIn().addClass("open");
  });

  // pridani akce modal
  $(".addAction").on("click", function (event) {

  });

  // zobrazit radek modal
  $(".ac-btn[name=nahled]").on("click", function (event) {
    /*
    $(this).parent().parent("tr").addClass("active");
    //event.stopPropagation();
    event.preventDefault();
   // event.stopImmediatePropagation();
    $("html").addClass("overflow-hidden");
    $(".modal-content").on("mousedown", function (event){
      event.stopPropagation();
    });
    $("#new-action-modal").css("display", "flex").animate({opacity: 1}, 300);
    $(".overlay").fadeIn(300);
    */
  });

  /*
  $(".ac-btn[name=smazat]").on("click", function (event) {
    $(this).parent().parent("tr").addClass("active");
    event.stopPropagation();
    event.preventDefault();
    event.stopImmediatePropagation();
    $("html").addClass("overflow-hidden");
    $(".modal-content").on("mousedown", function (event){
      event.stopPropagation();
    });
    $("#remove").css("display", "flex").animate({opacity: 1}, 300);
    $(".overlay").fadeIn(300);
  });
  */

  // hromadne oznaceni
  $(".table thead tr input").click(function() {
    var checkBoxes = $("td input[type=checkbox]");
    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
  });

  if ($(window).width() > 1024) {
  // oznaceni inputu
    $(".table tbody tr").click(function() {
      var checkBoxes = $(this).find("td > input[type=checkbox]");
      checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    });
  }

  // oznaceni schvaleni
  $(".table tbody label").click(function() {
    var checkBoxes = $(this).find("input[type=checkbox]");
    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
  });

  // cze language
  $.datepicker.regional['cs'] = {
    closeText: 'Cerrar',
    prevText: 'Předchozí',
    nextText: 'Další',
    currentText: 'Hoy',
    monthNames: ['Leden','Únor','Březen','Duben','Květen','Červen', 'Červenec','Srpen','Září','Říjen','Listopad','Prosinec'],
    monthNamesShort: ['Le','Ún','Bř','Du','Kv','Čn', 'Čc','Sr','Zá','Ří','Li','Pr'],
    dayNames: ['Neděle','Pondělí','Úterý','Středa','Čtvrtek','Pátek','Sobota'],
    dayNamesShort: ['Ne','Po','Út','St','Čt','Pá','So',],
    dayNamesMin: ['Ne','Po','Út','St','Čt','Pá','So'],
    weekHeader: 'Sm',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  // cze init
  $.datepicker.setDefaults($.datepicker.regional['cs']);
  // datepicker cfg


});
