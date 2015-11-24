/**
 * Created by jaskokoyn on 5/31/2015.
 */
jQuery(function($){
    $.material.init();

    $(document).on( 'click', '.jkof_dailyStatsBtn', function(e){
        e.preventDefault();

        var fid             =   parseInt($(this).data('fid'));
        $('#jkof-file-stat-modal').modal('show');
        $('#jkof-file-stat-modal .fa').show();
        $("#jkof_fileStatCtr").html('').hide();

        $.post( ajaxurl, { fid: fid, action: "jkof_get_file_stats" }, function(response){
            $('#jkof-file-stat-modal .fa').hide();
            $("#jkof_fileStatCtr").show();
            var ctx = $("#jkof_fileStatCtr").get(0).getContext("2d");

            var data = {
                labels: response.labels,
                datasets: [
                    {
                        label: "Downloads",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: response.downloads
                    }
                ]
            };

            var myLineChart = new Chart(ctx).Line(data, {
                responsive: false
            });
        }, 'json');
    });

    $('#jkof-file-stat-modal').on('hidden.bs.modal', function (e) {
        // do something...
        $("#jkof_fileStatCtr").html('').hide();
    })
});