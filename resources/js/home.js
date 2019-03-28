$( document ).ready(function() {
    var $weekPicker = $(".datepicker-week");

    var requestWeek = function(week){
        $.ajax({
            method: "get",
            url: "/api/reunion",
            data: { week: week },
            success: function ( data ){
                $('#table-reunion tbody').html(data.html);
            },
            fail: function ( data ){
                console.log('error');
            }
        });
    };

    var saveReunion = function(data, reference){
        $.ajax({
            method: "POST",
            url: "/api/reunion/save",
            data: { data: data, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function ( data ){
                toastr.success('Saved with success !!!', 'Reservation');
                $('#'+reference).text('Reserved for ' + data.name);
                $('#'+reference).attr('data-id', data.id);
                $('#'+reference).attr('data-week', JSON.stringify(data));
                $('#'+reference).parent().find('i').addClass('room-remove').attr('style', '');
                $('#roomModal').modal('hide');
            },
            fail: function ( data ){
                toastr.error('An error has occurred please try again later.', 'Reservation');
                console.log('error');
            }
        });
    };

    var removeReunion = function(datas, reference){
        $.ajax({
            method: "DELETE",
            url: "/api/reunion/delete",
            data: { data: datas, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function ( data ){
                toastr.success('Deleted with success !!!', 'Reservation');
                $('#'+reference).text('Available');
                $('#'+reference).attr('data-id', '');
                $('#'+reference).attr('data-week', datas.date);
                $('#'+reference).parent().find('i').removeClass('room-remove').css('display', 'none');
                $('#rooRemoveModal').modal('hide');
            },
            fail: function ( data ){
                toastr.error('An error has occurred please try again later.', 'Reservation');
                console.log('error');
            }
        });
    };

    var loadWeekByDate = function(date){
        var monday = moment(date).startOf('isoWeek');

        var listWeek = [
            monday.clone().toDate(),
            monday.clone().add(1, "days").toDate(),
            monday.clone().add(2, "days").toDate(),
            monday.clone().add(3, "days").toDate(),
            monday.clone().add(4, "days").toDate(),
            monday.clone().add(5, "days").toDate(),
            monday.clone().add(6, "days").toDate()
        ];

        requestWeek(listWeek);
        return listWeek;
    };

    $weekPicker.datepicker({
        format: "dd/mm/yy",
        // calendarWeeks: true,
        daysOfWeekDisabled: "6,7",
        maxViewMode: 0,
        weekStart: 1,
    }).on('changeDate', function (e) {
        if ($weekPicker.data('updating') === true) {
            return;
        }
        $weekPicker.data('updating', true);
        var weekDates = loadWeekByDate(e.date);

        $(this).datepicker('clearDate').datepicker('setDates', weekDates);
        $weekPicker.data('updating', false);

        var selected = moment(weekDates[0]).format("DD/MM/YY") + '-' + moment(weekDates[4]).format("DD/MM/YY");
        $('#week-selected').html(selected);
    });

    $weekPicker.datepicker('clearDate').datepicker('setDates', new Date());

    $('#roomModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var modal = $(this);
        var id = link.data('id');
        var date = typeof link.data('week') == 'object' ? link.data('week').date : link.data('week');
        var number_hour = link.data('hour');
        var date_selected = moment(date);

        try {
            var data_load =  JSON.parse(link.attr('data-week'));
        } catch (e) {}

        modal.find('.modal-title').text('Reservation ' + date_selected.format('DD/MM - HH:mm'));
        modal.find('#reunion-date').val( date_selected.format() );
        modal.find('#reunion-hour').val( number_hour );
        modal.find('#reunion-id').val( id );
        modal.find('#reunion-reference').val( link.attr('id') );

        if(typeof data_load != 'undefined'){
            modal.find('#reunion-name').val(data_load.name);
            modal.find('#reunion-desc').val(data_load.description);
            modal.find('#reunion-id').val(data_load.id);
        }else{
            modal.find('#reunion-name').val('');
            modal.find('#reunion-desc').val('');
            modal.find('#reunion-id').val('');
        }

        if(date_selected.week() < moment().week()){
            modal.find('#reunion-name, #reunion-desc, .room-save').attr('disabled', 'disabled');
        }else{
            modal.find('#reunion-name, #reunion-desc, .room-save').attr('disabled', false);
        }
    });

    $('#rooRemoveModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget).parent().find('a');
        var modal = $(this);
        var id = link.data('id');
        var date = typeof link.data('week') == 'object' ? link.data('week').date : link.data('week');
        var date_selected = moment(date);

        try {
            var data_load =  JSON.parse(link.attr('data-week'));
        } catch (e) {}

        modal.find('.modal-title').text('Remove ' + date_selected.format('DD/MM - HH:mm'));
        modal.find('#reunion-date').val( date_selected.format() );
        modal.find('#reunion-id').val( id );
        modal.find('#reunion-reference').val( link.attr('id') );

        if(typeof data_load != 'undefined'){
            modal.find('#reunion-name').val(data_load.name);
            modal.find('#reunion-desc').val(data_load.description);
            modal.find('#reunion-id').val(data_load.id);
        }
    });

    $('.room-save').on('click', function(e){
        var elem = $(e.currentTarget);
        var modal = elem.parents('.modal-content');

        if(modal.find('#reunion-name').val().trim() == ''){
            toastr.warning('Enter a Name', 'Reservation');
            modal.find('#reunion-name').focus();
            return false;
        }

        var data = {
            'id': modal.find('#reunion-id').val(),
            'date': modal.find('#reunion-date').val(),
            'hour': modal.find('#reunion-hour').val(),
            'name': modal.find('#reunion-name').val(),
            'desc': modal.find('#reunion-desc').val()
        };
        saveReunion(data, modal.find('#reunion-reference').val())
    });

    $('.room-delete').on('click', function(e){
        var elem = $(e.currentTarget);
        var modal = elem.parents('.modal-content');
        var data = {
            'id': modal.find('#reunion-id').val(),
            'date': modal.find('#reunion-date').val(),
        };

        removeReunion(data, modal.find('#reunion-reference').val())
    });

});
