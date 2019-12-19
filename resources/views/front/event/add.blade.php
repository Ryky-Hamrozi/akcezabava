@extends('front.front-layout')

@section('title', 'Nová událost')

@section('content')
    @include('front.spinner', ['class' => 'center'])
    <div class="new-action-page" id="js-add-event-form-content">
        @include('front.event.addForm')
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            var dateEnd, timeEnd ;
            var dateStart = dateEnd = new Date();
            var timeStart =  timeEnd = '08:00';


            $('#district').select2(
                {   width: '100%',
                    containerCss : {'margin-top' : '20px', 'z-index' : '10'}
                });

            $(".datepick-start").datepicker('setDate', dateStart);
            $(".datepick-end").datepicker('setDate', dateEnd);

            var timePickerOptions = {
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '00',
                maxTime: '11 PM',
                defaultTime: timeStart,
                startTime: '06:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                zindex: 9999,
            };

            $('#time-start').timepicker(timePickerOptions);

            timePickerOptions.defaultTime = timeEnd;
            $('#time-end').timepicker(timePickerOptions);
        });
    </script>
@endsection

