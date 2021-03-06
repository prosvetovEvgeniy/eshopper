/*price range*/

 $('#sl2').slider();
 $('.catalog').dcAccordion({
	 speed: 300,
 });
	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};

	//срабатывает при клике на кнопку "add to cart"
  $('.add-to-cart').on('click', function (e) {
	  e.preventDefault();

	  //получаем id товара и количество
	  var id = $(this).data() ;
	  var qty = $('#qty').val();

      //$.removeCookie('uuid');
      if(typeof $.cookie('uuid') == "undefined"){
          $.cookie('uuid', uuid(), { expires: 30 });
      }

	  //отправляем данные на сервер
	  $.ajax({
		  url: '/cart/add',
          type: 'POST',
		  data: {id: id, qty: qty},
		  success: function (res) {
		      //console.log(res);
		      showCart(res);
          },
		  error: function (e) {
		      console.log(e);
			  alert('Error');
          }
	  });
  });
  
  //отображает корзину
  function showCart(cart) {
	  $('#cart .modal-body').html(cart);
	  $('#cart').modal();
  }
    function clearCart() {
        $.ajax({
            url: '/cart/clear',
            type: 'GET',
            success: function (res) {
				if(!res) alert('Ошибка!');
				//console.log(res);
				showCart(res);
            },
            error: function (e) {
                console.log(e);
                //alert('Error');
            }
        });
	}
	//срабатывает при нажатии на кнопку удалить товар(крестик) в модальном окне корзины
	$('#cart .modal-body').on('click', '.del-item',function () {
		var product_id = $(this).data('id');

        $.ajax({
            url: '/cart/delete-item',
			data: {product_id: product_id},
            type: 'POST',
            success: function (res) {
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function () {
                alert('Error cannot delete item');
            }
        });
    })
	function getCart() {
        $.ajax({
            url: '/cart/show',
            type: 'GET',
            success: function (res) {
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function () {
                alert('Error cannot delete item');
            }
        });
		return false;
    }
    function uuid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
    }
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
