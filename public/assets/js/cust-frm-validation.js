function validation(activate, fieldsToBeValidate)
{	
	if (activate) {	
		var cnt = 0;
		var password = '';

		$.each(fieldsToBeValidate, function(keys, values)
		{
			var fieldValue = $('input#'+ keys).val();
			var fieldType = values.type;
	
			if (fieldType == 'text')
			{
				var msg = 'Please enter ';
				fieldType = 'default';
			}
			else if (fieldType == 'textarea')
			{
				var msg = 'Please enter ';
				fieldType = 'default';
				fieldValue = $('textarea#' + keys).val();
			}
			else if (fieldType == 'optionTxt')
			{
				var msg = 'Please enter ';
				fieldType = 'optionTxt';

			} 
			else if (fieldType == 'checkBox') 
			{
				var msg = 'Please check ';
				fieldType = 'default';
				fieldValue = $('input#' + keys).prop('checked');

			} 
			else if (fieldType == 'dropDown')
			{
				var msg = 'Please select ';
				fieldType = 'default';
				fieldValue = $('select#' + keys).val();				
			}
			else if (fieldType == 'multiselectDropDown')
			{
				var msg = 'Please select ';
				fieldType = 'default';
				//fieldValue = $('select#' + keys).val();	
				var fieldValue = $('select#'+ keys +'> option:selected').length;
				if (fieldValue == 0) fieldValue = '';
				else fieldValue = 'multiselectDropDown';
			}
			
			// Check regex pattern set or not
			if (typeof values.regex != 'undefined')
			{
				var pattern = new RegExp(values.regex.pattern);
			}	
			
			fieldValue = fieldValue.replace(/^\s+|\s+$/g,"");	
			switch (fieldType)
			{
				// default case handle text, checkbox and dropdown
				case 'default':
					if (fieldValue == '') 
					{
						$('#span_' + keys).text(msg + values.msg);
						cnt = setFocus(keys, cnt);						

					}
					else if (typeof values.min != 'undefined' && fieldValue.length < values.min.length) 
					{						
						$('#span_' + keys).text('Please enter minimum ' + values.min.msg);						
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.max != 'undefined' && fieldValue.length > values.max.length)
					{
						$('#span_' + keys).text('Please enter maximum ' + values.max.msg);
						cnt = setFocus(keys, cnt);	

					}
					else if (typeof values.regex != 'undefined' && !pattern.test(fieldValue))
					{
						$('#span_' + keys).text(values.regex.msg);
						cnt = setFocus(keys, cnt);						

					}
					else 
					{
						$('#span_' + keys).text('');
						
					}
					break;

				case 'optionTxt':
					if (fieldValue != '') 
					{
						if (typeof values.min != 'undefined' && fieldValue.length < values.min.length) 
						{						
							$('#span_' + keys).text('Please enter minimum ' + values.min.msg);						
							cnt = setFocus(keys, cnt);	

						} 
						else if (typeof values.max != 'undefined' && fieldValue.length > values.max.length)
						{
							$('#span_' + keys).text('Please enter maximum ' + values.max.msg);
							cnt = setFocus(keys, cnt);	

						}
						else if (typeof values.regex != 'undefined' && !pattern.test(fieldValue))
						{
							$('#span_' + keys).text(values.regex.msg);
							cnt = setFocus(keys, cnt);						

						}
						else 
						{
							$('#span_' + keys).text('');
						}
					}
					else 
					{
						$('#span_' + keys).text('');
					}
					break;

				case 'optionEmail':
					if (fieldValue != '' && !(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(fieldValue)))
					{
						$('#span_' + keys).text('Please enter valid ' + values.msg);
						cnt = setFocus(keys, cnt);	
					}
					else 
					{
						$('#span_' + keys).text('');
					}
					break;

				case 'imageUpload':
					if (fieldValue == '')
					{
						$('#span_' + keys).text('Please upload ' + values.msg);
						cnt = setFocus(keys, cnt);	
						
					}
					else if (!(/^.*\.(jpg|jpeg|gif|JPG|png|PNG)$/.test(fieldValue)))
					{
						$('#span_' + keys).text('Please uplaod valid image format');
						cnt = setFocus(keys, cnt);
					}
					else 
					{
						$('#span_' + keys).text('');
					}
					break;

				case 'optionImageUpload':
                    if (fieldValue != '' && !(/^.*\.(jpg|jpeg|gif|JPG|png|PNG)$/.test(fieldValue)))
					{
						$('#span_' + keys).text('Please uplaod valid image format');
						cnt = setFocus(keys, cnt);
					}
					else 
					{
						$('#span_' + keys).text('');
					}
					break;

				case 'email':
					if (fieldValue == '')
					{
						$('#span_' + keys).text('Please enter ' + values.msg);
						cnt = setFocus(keys, cnt);	
						
					}
					else if (!(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(fieldValue)))
					{
						$('#span_' + keys).text('Please enter valid ' + values.msg);
						cnt = setFocus(keys, cnt);	
					}
					else 
					{
						$('#span_' + keys).text('');
					}
					break;
				
				case 'password': 
					if (fieldValue == '')
					{
						$('#span_' + keys).text('Please enter ' + values.msg);
						cnt = setFocus(keys, cnt);	

					}
					else if (typeof values.min != 'undefined' && fieldValue.length < values.min.length) 
					{						
						$('#span_' + keys).text('Please enter minimum ' + values.min.msg);
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.max != 'undefined' && fieldValue.length > values.max.length)
					{
						$('#span_' + keys).text('Please enter maximum ' + values.max.msg);
						cnt = setFocus(keys, cnt);	

					}
					else if (typeof values.regex != 'undefined' && !pattern.test(fieldValue))
					{
						$('#span_' + keys).text(values.regex.msg);
						cnt = setFocus(keys, cnt);

					} 
					else 
					{						
						$('#span_' + keys).text('');
					}

					// To use in confirm password
					password = fieldValue;
					break;

				case 'opassword': 
					if (typeof values.min != 'undefined' && fieldValue.length < values.min.length) 
					{						
						$('#span_' + keys).text('Please enter minimum ' + values.min.msg);
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.max != 'undefined' && fieldValue.length > values.max.length)
					{
						$('#span_' + keys).text('Please enter maximum ' + values.max.msg);
						cnt = setFocus(keys, cnt);	

					}
					else if (typeof values.regex != 'undefined' && !pattern.test(fieldValue))
					{
						$('#span_' + keys).text(values.regex.msg);
						cnt = setFocus(keys, cnt);
					} 
					else 
					{						
						$('#span_' + keys).text('');
					}

					// To use in confirm password
					password = fieldValue;
					break;

				case 'cpassword':
					if (fieldValue == '')
					{
						$('#span_' + keys).text('Please enter ' + values.msg);
						cnt = setFocus(keys, cnt);	

					}
					else if (typeof values.min != 'undefined' && fieldValue.length < values.min.length)
					{
						$('#span_' + keys).text('Please enter minimum ' + values.min.msg);
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.max != 'undefined' && fieldValue.length > values.max.length)
					{
						$('#span_' + keys).text('Please enter maximum ' + values.max.msg);
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.regex != 'undefined' && !pattern.test(fieldValue))
					{
						$('#span_' + keys).text(values.regex.msg);
						cnt = setFocus(keys, cnt);

					}
					else if (fieldValue != password) 
					{
						$('#span_' + keys).text('Confirm password does not match');
						cnt = setFocus(keys, cnt);	

					}
					else
					{
						$('#span_' + keys).text('');
					}
					break;

				case 'ocpassword':
					if (typeof values.min != 'undefined' && fieldValue.length < values.min.length)
					{
						$('#span_' + keys).text('Please enter minimum ' + values.min.msg);
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.max != 'undefined' && fieldValue.length > values.max.length)
					{
						$('#span_' + keys).text('Please enter maximum ' + values.max.msg);
						cnt = setFocus(keys, cnt);	

					} 
					else if (typeof values.regex != 'undefined' && !pattern.test(fieldValue))
					{
						$('#span_' + keys).text(values.regex.msg);
						cnt = setFocus(keys, cnt);

					}
					else if (fieldValue != password) 
					{
						$('#span_' + keys).text('Confirm password does not match');
						cnt = setFocus(keys, cnt);	

					}
					else
					{
						$('#span_' + keys).text('');
					}
					break;
			}		
		});

		if(cnt > 0 ) return false;
		return true;
	}
	else
	{
		return true
	}
}

function setFocus(keys, cnt)
{
	if (!$('input, select').is(':focus')) {
		$('input#' + keys).focus();	
	}
	return cnt + 1;
}

