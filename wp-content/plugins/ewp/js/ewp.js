jQuery.noConflict();
var sending = 0;
	jQuery(document).ready(function(){
		
		jQuery('.ticket-submit button').live('click', function(){
			if(!sending && checkValidate()){
				var url = jQuery('input#ajax-url').val();
				sending = 1;
	            jQuery('.ticket-submit button span').html('Đang gửi');
	            jQuery('.ticket-submit button img').show();
	
				jQuery.ajax({
					type: 'POST',
					url: url,
					data: {
						action: 'save_custom_info',
						message : jQuery('textarea[name*="message"]').val(),
						name:  jQuery('input[name*="name"]').val(),
						phone:  jQuery('input[name*="phone"]').val(),
						email:  jQuery('input[name*="custom-email"]').val(),
						product_name: jQuery('input[name*="product-title"]').val()		
					},
					complete: function(data, textStatus, XMLHttpRequest){
						sending = 0;
	                    alert(data.responseText.replace('\r\n', ''));
	                    jQuery('.ticket-submit button span').html('Gửi');
	                    jQuery('.ticket-submit button img').hide();
	                    jQuery.fancybox.close();
					}	
				});
			}
		});
		
		jQuery('#info-reg button').click(function(){
			var email = jQuery('.receive-email').val();
			if(isEmail(email)){
				if(!sending){
					var url = jQuery('input#ajax-url').val();
					sending = 1;
		            jQuery('#info-reg button').html('Đang gửi');
		
					jQuery.ajax({
						type: 'POST',
						url: url,
						data: {
							action: 'reg_email',
							email:  jQuery('input[name*="receive-email"]').val(),			
						},
						complete: function(data, textStatus, XMLHttpRequest){
							sending = 0;
		                    alert(data.responseText.replace('\r\n', ''));
		                    jQuery('#info-reg button').html('Đặt vé');
						}	
					});					
				}
			
			} else {
				alert('Email không đúng, vui lòng nhập lại!');
			}
		});
		
//		jQuery('#buy-product-btn').click(function(e){
//			e.preventDefault();
//			jQuery('#info-form').parent('div').slideDown();
//		});
		var fancyData = '';
		jQuery('#buy-product-btn').fancybox({
			'onStart' : function (){
				fancyData = jQuery('#info-form-wrapper').html();
			},
			'onClosed' : function(){
		 		jQuery('#info-form-wrapper').html(fancyData);
			}
		});
	});	



function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+jQuery/;
  return regex.test(email);
}

function checkValidate(){
    var goDate = jQuery('select[name*="start-date"]').val();
    var goMonth = jQuery('select[name*="start-month"]').val();
    var comebackDate = jQuery('select[name*="comeback-date"]').val();
    var comebackMoth = jQuery('select[name*="comeback-month"]').val();
    var comeback = new Date(comebackDate + '/' + comebackMoth);
    var go = new Date(goDate + '/' + goMonth);
    var name = jQuery('input[name*="name"]').val();
	var phone = jQuery('input[name*="phone"]').val();
	var email =  jQuery('input[name*="email"]').val();
    
    if(comebackDate && comebackMoth && (comeback.getTime() < go.getTime())){
        alert('Ngày trở về phải lớn hơn ngày đi');
        return 0;
    }
    if(!name){
        alert('Bạn cần điền tên');
        return 0;
    }
    if(!phone){
        alert('Bạn cần điền số điện thoại');
        return 0;
    }
    /*
    if(!email) {
        alert('Bạn cần điền địa chỉ email');
        return 0;
    }
    */
    return 1;
}
