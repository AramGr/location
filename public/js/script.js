$(document).ready(function(){
    $(document).on('change', '#country', function(){

        $('.stateOptions').remove();
        $('.cityOptions').remove();
        let country = $(this).val();
        let code = $(this).find(':selected').attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/addClient',
            method: 'post',
            data: {
                country_post: country,
                code: code
            },
            success: function(result){
                result.forEach(function(state){
                    $('#state').append("<option class='stateOptions' value='"+state.region+"' data-id='"+code+"'>"+state.region+"</option>")
                });
            }
        });
    });

    $(document).on('change', '#state', function(){
        $('.cityOptions').remove();
        let state = $(this).val();
        let code = $(this).find(':selected').attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/addClient',
            method: 'post',
            data: {
                state_post: state,
                code: code
            },
            success: function(result){
                result.forEach(function(city){
                    $('#city').append("<option class='cityOptions' value='"+city.city+"'>"+city.city+"</option>")
                });
            }
        });
    });

    $(document).on('click', '.client', function(){
        let clientId = $(this).attr('data-id');
        let name = $(this).text();
        $('#myModalLabel').text(name);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/client/'+clientId,
            method: 'post',
            data: {
                client_id: clientId
            },
        success: function(result){

            let index = result.indexOf('//<![CDATA');
            let final = '<script>'+result.substring(index);
            final = final.replace('google.maps.event.addDomListener(window, "load", initialize_map)','initialize_map()');

                // console.log(final);
                $('#mapPlace').html(final);
            }
        });
    });
});
