$(document).ready(function(){

    $('.addAction').on('click',function(event){
        getModalContent($(this));
    });

    $('.get-modal-content').on('click',function(){
        getModalContent($(this));
    });

    $(".ac-btn[name=smazat]").on("click", function (event) {
        setRemoveModal($(this));
    });

    $('#remove-item').on('click',function(){
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

    $('.approve').on('change',function(){
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
                console.log(data.modal);
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
        $.ajax({
            method: "POST",
            url: url,
            data: { id: id, _token: token  },
            success : function(items){
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
});