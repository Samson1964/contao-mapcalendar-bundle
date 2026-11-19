$(function() {
    $('body').on('click', '#svgmap .varea,#svgmap .blarea', function (e) {
        setMapBLactive(e.target.id);
        var v=$("#lvselect option[data-mapid='"+e.target.id+"']").val();
        if(v){
            $(".mod_mapcalendar .buttons a").removeClass("active");
            $(".mod_mapcalendar a[data-area='lvs']").addClass("active");

            $('#lvselect').val(v);
            loadEvents($('#lvselect').val());
        }
   });
    $('#lvselect').change(function(e){
        setMapBLactive($(this).children("option:selected").attr("data-mapid"));
        loadEvents($('#lvselect').val());
        $(".mod_mapcalendar .buttons a").removeClass("active");
        $(".mod_mapcalendar a[data-area='lvs']").addClass("active");
    });

    $('.mod_mapcalendar .button').click(function(e){
        $(".mod_mapcalendar .buttons a").removeClass("active");
        $(e.target).addClass("active");
        if($(".mod_mapcalendar .buttons a.active").attr("data-area")=="lvs"){
            loadEvents($('#lvselect').val());
        }else{
            setMapBLactive();
            $('#lvselect').val(0)
            loadEvents("dsb");
        }
    });
    $('select[name=filter]').change(function(e){
        if($(".mod_mapcalendar .buttons a.active").attr("data-area")=="lvs"){
            loadEvents($('#lvselect').val());
        }else{
            loadEvents("dsb");
        }
    });    
    

    function setMapBLactive(id){
        $('#svgmap .varea,#svgmap .blarea').removeClass("active");
        if(id) $('#svgmap #'+id).addClass("active");
    }

    function loadEvents(cid){
        $('#mapcal_content').addClass('loading');
        $('#mapcal_content').load("",{
            "cid":cid,
            "filter":$('select[name=filter]').val(),
            "module_id":$('.mod_mapcalendar input[name="module_id"]').val()
        },function(e){
            $('#mapcal_content').removeClass('loading');
        });
    }

});

