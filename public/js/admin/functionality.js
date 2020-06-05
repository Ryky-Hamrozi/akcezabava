$(document).ready(function(){
    console.log("aaaaa");
    $('body').on('shown.bs.modal','#new-action-modal', function () {
        console.log("shown!");
        //tinyMCE.editors=[];
    });

    $('body').on('click', '.addAction', function(event){
        getModalContent($(this));
    });

    $('body').on('click', '.get-modal-content' ,function(){
        getModalContent($(this));
    });

    $("body").on("click", '.ac-btn[name=smazat]', function (event) {
        setRemoveModal($(this));
    });

    $('body').on('click', '#remove-item', function(){
        removeFromServer($(this));
    });

    $(document).on('change','.dependent-select-parent',function(){
        fillSelectBox($(this));
    });

    $(document).on('click','#add-image',function(){
        addImage($(this));
    });

    $(document).on('click','.remove-image',function(){
        removeImage($(this));
    });

    $('body').on('change', '.approve',function(){
       approveEvent($(this));
    });

    $('.pie-chart-select').on('change',function () {
        changePieChart($(this));
    });

    /* vrátí a nastaví modalové okno pro přidání/editaci modelu */
    function getModalContent(button){
        var token = button.attr('data-token');
        var model = button.attr('data-model');
        var id = button.attr('data-id') != undefined ? button.attr('data-id') : 0;
        $.ajax({
            method: "POST",
            url: "/admin/getModalContent",
            data: { model:model, id:id, _token: token  },
            success : function(data){
                //console.log(data.modal);
                $('#new-action-modal').replaceWith(data.modal);

                button.parent().parent("tr").addClass("active");
                //event.stopPropagation();
                //event.preventDefault();
                // event.stopImmediatePropagation();
                $("html").addClass("overflow-hidden");
                $(".modal-content").on("mousedown", function (event){
                    $( ".datepick" ).datepicker( "hide" );
                    event.stopPropagation();
                });
                $("#new-action-modal").css("display", "flex").animate({opacity: 1}, 300);
                $(".overlay").fadeIn(300);


            }
        })
    }

    /* nastaví modalové okno pro smazání modelu */
    function setRemoveModal(button){
        var remove = $("#remove");
        var itemName = button.attr('data-item-name');
        remove.find('.remove-item-name').text(itemName);
        var removeButton = remove.find('#remove-item');
        removeButton.attr('data-model',button.attr('data-model'));
        removeButton.attr('data-id',button.attr('data-id'));
        removeButton.attr('data-token',button.attr('data-token'));
        button.parent().parent("tr").addClass("active");
        //event.stopPropagation();
        //event.preventDefault();
        //event.stopImmediatePropagation();
        $("html").addClass("overflow-hidden");
        $(".modal-content").on("mousedown", function (event){
            event.stopPropagation();
        });
        remove.css("display", "flex").animate({opacity: 1}, 300);
        $(".overlay").fadeIn(300);
    }

    function removeFromServer(button){
        var token = button.attr('data-token');
        var model = button.attr('data-model');
        var id = button.attr('data-id');
        $.ajax({
            method: "POST",
            url: "/admin/removeModel",
            data: { model:model, id:id, _token: token  },
            success : function(data){
                $('.row-'+id).remove();
            },
            complete : function(){
                $('#remove').find('.close').click();
            }
        })
    }

    function fillSelectBox(selectbox){
        var child = $(selectbox.attr('data-child'));
        var url = selectbox.attr('data-url');
        var modelId = selectbox.val();
        var token = selectbox.attr('data-token');
        $.ajax({
            method: "POST",
            url: url,
            data: { modelId: modelId, _token: token  },
            success : function(items){
                child.html('');
                for(var key in items){
                    var name = items[key];
                    var option = $('<option value="'+key+'">'+name+'</option>');
                    option.appendTo(child);
                }
            },
        })
    }

    function addImage(button){
        var imgInput = $('.image-input').first();
        var row = imgInput.closest('.row').clone();
        row.find('.image-input').val('');
        row.find('label').remove();
        row.insertBefore(button.closest('.row'));
    }

    function removeImage(button){
        var imageId = button.attr('data-id');
        var idsInput = $('#deleted-images');
        var value = idsInput.val();
        if(value == ''){
            var newValue = imageId;
        }
        else{
            var newValue = ',' + imageId;
        }
        value += newValue;

        idsInput.val(value);
        button.closest('.image-wrapper').remove();
    }

    function approveEvent(button){
        var id = button.attr('data-id');
        var url = button.attr('data-url');
        var token = button.attr('data-token');
        var page = $('input[name="page"]').val();
        $.ajax({
            method: "POST",
            url: url,
            data: { id: id, _token: token, page: page },
            success : function(response){
                $('.js-flashes').html(response.flashes);
                $('.js-events-table').html(response.events);
                $('.js-approval-count').html(response.eventsCount);
            },
            error : function(response){
                if(response.status == 422){
                    $('input:checked').removeAttr('checked');
                    alert(response.responseJSON.message);
                }
            },
        });
    }

    function changePieChart(select){

        var url = select.attr('data-url');
        var model = select.attr('data-model');
        var id = select.val();
        var token = select.attr('data-token');

        $.ajax({
            method: "POST",
            url: url,
            data: { model: model, id: id, _token: token  },
            success : function(data){
                var donut = $('#donutchart');
                donut.attr('data-upcoming',data.upcomingCount);
                donut.attr('data-for-approval',data.forApprovalCount);
                donut.attr('data-finished',data.finishedCount);
                peiChart();
            },
        });
    }

    $('body').on('click', '.ajax-import', function() {
        $link = $(this);
        $link.find('.loader').show();
        $link.find('img').hide();
        $.ajax({
            url: $link.attr('href')
        }).done(function(data) {
            $link = $('#'+data.id);
            $link.find('img').attr('src', '/img/admin/checked_green.svg').show();
            $link.find('.loader').hide();

            if(data.errors) {

                $errorsArray = JSON.parse(data.errors);
                $errors = "";

                for($i = 0; $i < $errorsArray.length; $i++) {
                    $fbUrl = $errorsArray[$i].fb_url;
                    $error = $errorsArray[$i].error;

                    $errors += '<div class="alert alert-danger"><a href="'+($fbUrl)+'" target="_blank">' + ($fbUrl) +'</a> <br> ' + ($error) +' </div>';
                }

                $link.attr('href', '');

                $link.parent().find('.js-import-errors-'+data.id).html($errors);
            }
        });

        return false;
    });
});
