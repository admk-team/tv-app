(function (window){
	"use strict"	
	var MVPShareManager = function(settings){

		var isMobile = MVPUtils.isMobile()
			
		/*if(settings.facebookAppId && window.location.protocol != 'file:'){
			injectFbSdk(settings.facebookAppId);
		}*/

		this.share = function(type, data, query_string){
			
			var prefix = ('https:' == window.location.protocol ? 'https:' : 'http:'),
			w = 600, h = 300, cw = (window.screen.width - w) / 2, ch = (window.screen.height - h) / 2,

			title = data.title || '',
			description = data.description || '',
			thumb = data.thumb || data.thumbDefault, url, path;
			if(data.share)url = data.share;
			else url = query_string;
			
			if(!MVPUtils.relativePath(thumb))thumb = MVPUtils.qualifyURL(data.thumb);

			if(type == "facebook"){	

				path = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url)+'&t='+encodeURIComponent(title);

			}else if(type == "twitter"){	

				path = prefix+'//twitter.com/intent/tweet?url='+encodeURIComponent(url)+'&text='+encodeURIComponent(title);

			}else if(type == "tumblr"){	

				path = prefix+'//www.tumblr.com/share/link?url='+encodeURIComponent(url)+'&amp;name='+encodeURIComponent(title)+'&amp;description='+encodeURIComponent(description);

			}else if(type == "reddit"){	

				path = prefix+'//www.reddit.com/submit?url='+encodeURIComponent(url);

			}else if(type == "linkedin"){	

				path = prefix+'//www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title)+'&summary='+encodeURIComponent(description)+'&source='+document.title;

			}else if(type == "digg"){	

				path = prefix+'//digg.com/submit?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title);

			}else if(type == "pinterest"){	

				path = prefix+'//www.pinterest.com/pin/create/button/?url='+encodeURIComponent(url)+'&media='+encodeURIComponent(thumb)+'&description='+encodeURIComponent(description);	

			}else if(type == "whatsapp"){	

				var message = encodeURIComponent(title)+" - "+encodeURIComponent(url)

				if(isMobile) {
	                var link_whatsapp = 'https://api.whatsapp.com/send?text='+message;
	            } else {
	                var link_whatsapp = 'https://web.whatsapp.com/send?text='+message;
	            }

	            window.open(link_whatsapp,'_blank');

	            return

			}

			if(path)window.open(path, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width='+w+',height='+h+',left='+cw+',top='+ch+'');
		}	

		function injectFbSdk(fs_api_id) {
			
			// this loads the Facebook API
		    (function (d, s, id) {
		        var js, fjs = d.getElementsByTagName(s)[0];
		        if (d.getElementById(id)) { return; }
		        js = d.createElement(s); js.id = id;
		        js.src = "https://connect.facebook.net/en_US/sdk.js";
		        fjs.parentNode.insertBefore(js, fjs);
		    }(document, 'script', 'facebook-jssdk'));

		    window.fbAsyncInit = function () {
		        FB.init({
		            appId: fs_api_id,
		            xfbml: true,
		            version: 'v3.2',
		        });
		    };
		}

	};	

	window.MVPShareManager = MVPShareManager;

}(window));