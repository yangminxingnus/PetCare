var url = window.location.href;
var time = 10;
var timeIframe = [];
function makeSaveTimeRequest(optinize_client_id,optinize_pixel_id,url,time){
    if(typeof timeIframe[optinize_pixel_id] == 'undefined'){
        timeIframe[optinize_pixel_id] = document.createElement('iframe');
        timeIframe[optinize_pixel_id].frameBorder = 0;
        timeIframe[optinize_pixel_id].width = "0px";
        timeIframe[optinize_pixel_id].height = "0px";
        timeIframe[optinize_pixel_id].scrolling="no";
        timeIframe[optinize_pixel_id].src = "//opz352.com/page_action/spvt.php?client_id=" + optinize_client_id +
            "&pixel_id=" + optinize_pixel_id +
            "&url=" + encodeURIComponent(url) +
            "&time=" + time;
        document.getElementsByTagName('body')[0].appendChild(timeIframe[optinize_pixel_id]);
    } else {
        timeIframe[optinize_pixel_id].src = "//opz352.com/page_action/spvt.php?client_id=" + optinize_client_id +
            "&pixel_id=" + optinize_pixel_id +
            "&url=" + encodeURIComponent(url) +
            "&time=" + time;
    }
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var searchString = location.search.substr(1);
    if(searchString==''){
        searchString = location.hash.substr(1);
    }
    var items = searchString.split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        var keyName = tmp[0].replace(/[^-a-zA-Z0-9_]/g, '');
        console.log(keyName);
        if (keyName === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

function optinize_load_iframe(optinize_client_id)
{


	if(typeof optinize_client_id === 'undefined')
	{
		optinize_client_id = 0;
	}

	if(typeof optinize_pixel_id === 'undefined')
	{
		optinize_pixel_id = 0;
	}
	
	
	if (typeof optinize_shoping_cart === 'undefined') 
	{
   		optinize_shoping_cart = null;
	}
	
	
	if (typeof optinize_product_id === 'undefined') 
	{
   		optinize_product_id = null;
	}
	
	if (typeof optinize_product_name === 'undefined') 
	{
   		optinize_product_name = null;
	}
	
	if (typeof optinize_product_image_url === 'undefined') 
	{
   		optinize_product_image_url = null;
	}
	
	if (typeof optinize_product_price === 'undefined') 
	{
   		optinize_product_price = null;
	}
	
	
	if (typeof optinize_price_currency === 'undefined') 
	{
   		optinize_price_currency = null;

	}
	if (typeof event_value === 'undefined')
	{
        event_value = null;

	}
	



	var iframe = document.createElement('iframe');
	iframe.frameBorder = 0;
	iframe.width = "0px";
	iframe.height = "0px";
	iframe.scrolling="no";
	iframe.src = "//opz352.com/page_action/conv_iframe.php?client_id=" + optinize_client_id +
	"&pixel_id=" + optinize_pixel_id + 
	"&url=" + encodeURIComponent(url) + 
	"&ref=" + encodeURIComponent(findGetParameter('ref')) +
	"&product_id=" + encodeURIComponent(optinize_product_id) +
	"&product_name=" + encodeURIComponent(optinize_product_name) + 
	"&product_image_url=" + encodeURIComponent(optinize_product_image_url) + 
	"&product_price=" + encodeURIComponent(optinize_product_price) + 
	"&price_currency=" + encodeURIComponent(optinize_price_currency) +
	"&shopping_cart_total=" + encodeURIComponent(event_value) +
	"&shoping_cart=" + encodeURIComponent(JSON.stringify(optinize_shoping_cart));
	document.getElementsByTagName('body')[0].appendChild(iframe);

    makeSaveTimeRequest(optinize_client_id,optinize_pixel_id,url,time);

}

optinize_load_iframe(optinize_client_id);
setInterval(function(){
    time += 10;
    makeSaveTimeRequest(optinize_client_id,optinize_pixel_id,url,time);
},10000);

