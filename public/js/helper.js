/**********************************************
*	GENERAL HELPER FUNCTIONS
**********************************************/
var Utils = Utils || {};

Utils.CSRF_TOKEN = '';
	
(function ($, bootbox, window) {
	
	Utils.confirmDeletion = function(resource, recordID, recordNameLabel, customMessage, btnLabel, method)
	{
		if(customMessage == null)
			customMessage = "A jeni i sigurt per fshirjen e ";
			
		if(btnLabel == null)
			btnLabel = "Po, Fshi";
			
		bootbox.dialog({
		  title: "Konfirmo",
		  message: customMessage+recordNameLabel+"?",
		  buttons: {
			cancel: {label: "Anullo", className: "btn-default"},
			confirm: { label: btnLabel,  className: "btn-danger", callback: function() {
				$.ajax({
					type: 'post',
					url: '/'+resource+'/'+recordID,
					data: {_method: method ? method:'delete', _token: Utils.CSRF_TOKEN},
					success: function(result) {
						if(result['message'])
						{
							bootbox.dialog({
								title: "Response",
								message: "<br>"+result['message']+"<br><br>",
								buttons: { ok: {label: "OK", className: "btn-primary"} },
								backdrop: true
							});
						}
						else if(result['redirect'])
							redirectRequest(result['redirect']);
						else 
							location.reload();
					}
				});
			}}
		  }
		});
	}

	Utils.confirmStatusChange = function (productID, productLabel, status, callback)
	{
		var labels = {
			"3": `kthimin e produktit "${productLabel}" ne Gjendje`, 
			"1": `kalimin e produktit "${productLabel}" si te Shitur`, 
			"4": `dergimin e produktit "${productLabel}" ne Servis`
		};

		bootbox.dialog({
		  title: "Konfirmo Levizjen",
		  message: `A jeni i sigurt per ${labels[status]}?`,
		  buttons: {
			cancel: { label: "Anullo", className: "btn-default", callback: function () {
				window.location.reload();
			}},
			confirm: { label: "Po vazhdo",  className: "btn-primary", callback: function() {
				$.ajax({
					type: 'post',
					url: '/home/set-status',
					data: {
						_token: Utils.CSRF_TOKEN,
						product_id: productID,
						status: status
					},
					success: callback
				});
			}}
		  }
		});
	}

})(jQuery, bootbox, window);

Utils.priceFormat = function(value)
{
	return parseFloat(value).toFixed(2);
}

/**********************************************
*	DATE CUSTOM HELPER FUNCTIONS 
**********************************************/
var Date = Date || {};

Date.convertFromMysql = function (mysql_date, separator='/')
{
	if (mysql_date) {
		const dateParts = mysql_date.split('-');
		if (dateParts.length > 1) {
			return dateParts[2] + separator + dateParts[1] + separator + dateParts[0];
		}
	}
	
	return '';
}

Date.convertToMysqlNoTimeZone = function(date, includeTime)
{
	var mysql_date = "";
    if(date)
    {
		mysql_date = date.getUTCFullYear() + '-' +
					('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
					('00' + date.getDate()).slice(-2);//not used getUTCDate because of the timezone

	    if(includeTime!==false)
	    {
			mysql_date += ' '+('00' + date.getHours()).slice(-2) + ':' +
							('00' + date.getMinutes()).slice(-2) + ':00';
	    }
	    else
	        mysql_date += ' 00:00:00';
    }

    return mysql_date;
};


function redirectRequest(url, data, target)
{
	var postInput = ' method="get"> ';
	if(data != undefined)
	{
		postInput = ' method="post"> ';
		for (var key in data){
			postInput += '<input type="hidden" name="'+key+'" value="'+data[key]+'" />';
		}
	}

	var formTarget = '';//'target="_self"'
	if(target != undefined)
	{
		formTarget = 'target="'+target+'"';
	}

	var form = $('<form action="'+url+'" '+formTarget+' '+postInput+'</form>');
	$('body').append(form);
	$(form).submit();
}

// Remove the formatting to get integer data for summation
var intVal = function (i) {
	return typeof i === 'string' ?
		i.replace(/[\$,]/g, '') * 1 :
		typeof i === 'number' ?
			i : 0;
};

Utils.sumFooter = (api, colIndex, options) => {
	// Sum
	const column = api.column(colIndex);
	let sum;
	if(options && options.sum) {
		sum = options.sum;
	} else {
		sum = column.data().reduce(function (a, b) {
			return intVal(a) + intVal(b);
		}, 0);
	}
	// Update footer
	$(column.footer()).html(() => {
		if (options) {
			if (options.callback)
				return options.callback(sum);
			else
				return $.fn.dataTable.render.number(',', '.', options.decimal || 0, options.prefix || '', options.postfix || '').display(sum);
		} else {
			return sum;
		}
	});
};