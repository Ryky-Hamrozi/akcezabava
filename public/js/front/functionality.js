$(function () {

    $('body').on('click', '.js-homepage-events-link', function () {

        $categoryId = $(this).attr('data-category-id');

        /// Smazat aktivni
        $('.js-category').removeClass('active');

        /// Nastavit novy aktivni
        $(this).parent().addClass('active');

        $('.js-spinner').show();

        $.ajax({
            url: '/get-homepage-event-list',
            data: {
                'category_id': $categoryId
            },
            success: function (data) {
                $('#js-homepage-events').html(data.events);
                $('.js-spinner').fadeOut();
            }
        })

        return false;
    });

    $('body').on('submit', '#js-events-filter-form', function () {
        $('.recomended-for-u').remove();
        $('.js-spinner').show();

        $form = $('#js-events-filter-form');
        $data = $form.serialize();
        $url = $form.attr('action');

        $.ajax({
            url: '/get-filter-event-list',
            data: $data,
            success: function (data) {
                $('.js-content-block-events').html(data.events);
                $('.js-spinner').fadeOut();
                history.pushState('', 'Seznam akci', '/seznam-akci/?' + $data);
            }
        })

        return false;
    });

    $('body').on('submit', '#js-reklama-na-webu-form', function () {
        $('.js-spinner').show();

        $form = $('#js-reklama-na-webu-form');
        $data = $form.serialize();
        $url = $form.attr('action');

        $.ajax({
            url: $url,
            method: 'post',
            data: $data,
            success: function (data) {
                $('#js-reklama-na-webu-content').html(data);
                $('.js-spinner').fadeOut();
            }
        });

        return false;
    });

    $('body').on('submit', '#js-add-event-form', function () {
        $('.js-spinner').show();

        $form = $('#js-add-event-form');
        $data = $form.serialize();
        $url = $form.attr('action');

        $.ajax({
            url: $url,
            data: $data,
            method: 'post',
            success: function (data) {
                $('#js-add-event-form-content').html(data);
                $('.js-spinner').fadeOut();
            }
        });

        return false;
    });


});