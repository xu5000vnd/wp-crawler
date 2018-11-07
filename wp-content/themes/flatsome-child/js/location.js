jQuery(document).ready(function($){
    let main = '';
    $('.pu-container').on('click', '.quocgia' ,function(e){
        var thiss = $(this);
        e.preventDefault();
        //alert($(this).attr('data-id'));
        var dataString = 'id=' + $(this).attr('data-id') + "&action=getcat"
        jQuery.ajax({
			action: "getcat",
			type: "post",
			url: mhlocation.ajaxurl,
			dataType: "json",
			data: dataString,
			success : function(data){
				main = $('.pu-container').html();
                $('.pu-container table').html("<tr><th><a href='"+ thiss.attr('href')+ "'>" + thiss.text()+ "</a>");
                $('.pu-container table tr').append("<td></td>");
                $.each(data['data'], function(index, value){
                    $('.pu-container table tr td').append("<a class='location' href='" + value['link'] + "'>" + value['name'] + '</a>');
                });
                $('.pu-container').append("<button class='btn btn-primary backtomain'>Back</button>");
			},
		})
    });
    $('.pu-container').on('click', '.backtomain', function(){
        $('.pu-container').html(main);
    });

});