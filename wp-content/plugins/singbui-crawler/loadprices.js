'use strict';
const API_LINK = 'http://localhost:3000';

function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }

  return;
};


(async function () {
  var postId = getUrlParameter('post');
  if (postId) {
    var post = await jQuery.get(API_LINK + '/api/klook/posts/' + postId);
    if (post.success) {
      var activity = post.result[0];
      var name = activity.name;
      var link = `<a href="https://www.klook.com/activity/${activity.id}" target="_blank">https://www.klook.com/activity/${activity.id}</a>`;
      var dateTime = new Date(activity.dateTime);
      dateTime = dateTime.toLocaleDateString() + ' ' + dateTime.toLocaleTimeString();
      var exchangeRate = parseFloat(jQuery('#exchange_rate').data('rate'));
      var packages = '';
      if (activity.packages) {
        for (var i = 0; i < activity.packages.length; i++) {
          var pack = activity.packages[i];
          packages += `
            <div>
              <h4>Package Name: <b>${pack.packageName}</b></h4>
              <h4>Date: ${pack.date}</h4>
          `;
          for (var j = 0; j < pack.prices.length; j++) {
            var packPrice = pack.prices[j];
            packages += `
              <div class="package-detail-prices" data-price="${packPrice.price}">
                <p>Market Price: <strong style="font-size:16px">${parseInt(parseFloat(packPrice.market_price) * exchangeRate)}</strong> VND ( ${packPrice.market_price} USD)</p>
                <p>Price: <strong style="font-size:16px">${parseInt(parseFloat(packPrice.price) * exchangeRate)}</strong> VND ( ${packPrice.price} USD)</p>
                <p>Name Package: ${packPrice.name}</p>
                <input type="number" name="commssion_rate" placeholder="Commission Rate" class="commission-rate" />
                <p>Total: <strong style="font-size:16px"><span class="total-price"><span></strong>VND</p>
              </div>
              <hr/>
            `;
          }

          packages += `
            </div>
          `;
        }
      }
      jQuery('#klook_name').html(name);
      jQuery('#klook_link').html(link);
      jQuery('#klook_datetime').html(dateTime);
      jQuery('#klook_packages').html(packages);

      jQuery('#klook_packages .package-detail-prices').bind('input', function () {
        var price = jQuery(this).data('price');
        var val = jQuery(this).find('input.commission-rate').val();
        jQuery(this).find('.total-price').html(parseInt(parseFloat(val) + (parseFloat(price) * exchangeRate)));
      });
    }
  }
})();