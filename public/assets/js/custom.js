function setDropDownValue(curDropdownVal, dropDownIdTo, caseName, requestURl) {
  var uid = curDropdownVal;
  var dropDownIdTo = dropDownIdTo;
  $.ajax(
    {
      url: requestURl + "?uid=" + uid + "&caseName=" + caseName,
    })
    .done(function (data) {
      $("#" + dropDownIdTo).html(data);
    });
}

function openNav() {
  document.getElementById("mySidenav").style.width = "230px";
}
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
$(function () {
  $(document).scroll(function () {
    var $nav = $(".fixed-top");
    $nav.toggleClass('header_scroll', $(this).scrollTop() > $nav.height());
  });
});

$('.owl-carousel').owlCarousel({
  center: true,
  items: 1,
  loop: true,
  smartSpeed: 800,
  autoplay: true,
  margin: 10,
  stagePadding: 100,
  nav: true,
  dots: false,
  responsive: {
    0: {
      stagePadding: 0,
      nav: false,
    },
    600: {
      stagePadding: 0,
      nav: false,
    },
    1000: {
      stagePadding: 100,
      nav: true,
      margin: 20,
    }
  }
});

/** script for password show */

$(".toggle-password").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
// Password toggle    
$(".toggle-password2").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
$(".toggle-password3").click(function () {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

function manageFavItem() {
  var postAction = '';
  var myWishListSign = $('#myWishListSign').val();
  if (myWishListSign == '+') {
    postAction = 'addFavItem';
    $('#myWishListSign').val('-');
    $('#btnicon-fav').removeClass('fa fa-plus');
    $('#btnicon-fav').addClass('fa fa-minus');
  }
  else {
    postAction = 'removeFavitem';
    $('#myWishListSign').val('+');
    $('#btnicon-fav').removeClass('fa fa-minus');
    $('#btnicon-fav').addClass('fa fa-plus');

  }

  sendAjaxResForFavItem(postAction);
}

function sendAjaxResForFavItem(requestAction) {
  var reqUrl = $('#reqUrl').val();
  var strQueryParm = $('#strQueryParm').val();

  strQueryParm = strQueryParm + '&requestAction=' + requestAction + '&_token=' + $('[name="_token"]').val();

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      var response = JSON.parse(this.responseText);
      // if (response.data['user_code']) {
        //$('#btnicon-fav').removeClass('fa fa-minus');
        //  $('#btnicon-fav').addClass('fa fa-plus');
      // } else {
        ///$('#btnicon-fav').removeClass('fa fa-plus');
        //$('#btnicon-fav').addClass('fa fa-minus');
      // }
    }
  };
  xhttp.open("POST", reqUrl, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(strQueryParm);
}

/** script for copy the url */

$(".share_btnbox").click(function () {
  var copyText = document.getElementById("sharingURL");
  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, copyText.value.length); // For mobile devices
  navigator.clipboard.writeText(copyText.value);
});
