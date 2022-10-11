(function (window, $) {
    'use strict';
  
    var options = window._SBSL;
  
    var map, userLocation, infoWindow, markers = [];
  
    var searchParams = {
      action: options.ajaxAction,
      query: null,
      page: 1
    };
  
    function loadGoogleMap() {
      var mapCenter = new google.maps.LatLng(parseFloat(33.749671), parseFloat(-84.389723));
  
      var mapOptions = {
        zoomControl: 1,
        zoomControlOptions: {
          position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: 1,
        streetViewControl: 0,
        scrollwheel: 0,
        center: mapCenter,
        zoom: 5,
        mapTypeControlOptions: {
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
          position: google.maps.ControlPosition.TOP_LEFT
        },
        fullscreenControl: 1,
        fullscreenControlOptions: {
          position: google.maps.ControlPosition.RIGHT_TOP
        },
        gestureHandling: 'auto',
        styles: options.gMapStyles,
      };
      map = new google.maps.Map(mapCanvas, mapOptions);
  
      var marker = new google.maps.Marker({
        draggable: false,
        position: mapCenter,
        optimized: false,
        map: map,
        title: 'Atlanta, GA, USA'
      });
  
      infoWindow = new google.maps.InfoWindow({
        content: ''
      });
  
      var timeout;
      /**
       * Resize event handling, make map more responsive
       * Center map after 300 ms
       */
      google.maps.event.addDomListener(window, 'resize', function () {
        if (timeout) {
          clearTimeout(timeout);
        }
        timeout = window.setTimeout(function () {
          map.setCenter(mapCenter);
        }, 300);
      });
  
      // Auto-complete feature
      var searchInput = document.querySelector('#sbsl-search');
      var locSearch = new google.maps.places.Autocomplete(searchInput);
  
      google.maps.event.addListener(locSearch, 'place_changed', function () {
        var place = locSearch.getPlace();
        if (place.geometry) {
          // store userLocation for future use
          userLocation = place.geometry.location;
          map.panTo(userLocation);
          map.setZoom(15);
  
          marker.setPosition(userLocation);
          marker.setTitle(place.formatted_address);
  
          searchParams.query = place.formatted_address;
          sendAjaxRequest();
        }
      });
  
    }
  
    var mapCanvas = document.getElementById('sbsl-map-canvas');
    if (typeof mapCanvas !== 'undefined' && mapCanvas) {
      if (typeof google === 'object' && google.maps) {
        google.maps.event.addDomListener(window, 'load', loadGoogleMap)
      } else {
        mapCanvas.innerHTML = '<p class="map-not-loaded" style="text-align: center">Failed to load Google Map.<br>Please try again.</p>';
        mapCanvas.style.height = 'auto';
      }
    }
  
    var xhrInstance = null;
  
    // Fetch Stores
    function sendAjaxRequest() {
      // abort previous ajax request
      if (xhrInstance && xhrInstance.readyState !== 4) {
        xhrInstance.abort();
        xhrInstance = null;
      }
  
      removeOldMarkers();
      $('.sbsl-loader').show(0);
      $("#sbsl-nav").find('.nav-btn').prop('disabled', true);
      $('#sbsl-stores-list').html('');
  
      xhrInstance = $.ajax({
        type: 'get',
        url: options.ajaxUrl,
        dataType: 'JSON',
        cache: false,
        data: searchParams,
      })
        .done(function (response) {
          console.log('success', response);
  
          searchParams.page = parseInt(response.data.meta.page);
  
          updateMarkers(response.data.stores);
          updateStoreList(response.data.stores);
          updateNavigation(response.data.meta);
        })
        .fail(function (qXHR, textStatus) {
          console.error(qXHR);
          $('#sbsl-stores-list').html('<div class="sbsl-no-results">Something went wrong.<br>Please try again.</div>');
        })
        .always(function (jqXHR) {
          $('.sbsl-loader').hide(0);
          $("#sbsl-nav").find('.nav-btn').prop('disabled', false);
        })
    }
  
    function updateMarkers(stores) {
      var latLngBounds = new google.maps.LatLngBounds();
  
      // Create new markers
      stores.forEach(function (store) {
        var position = new google.maps.LatLng(parseFloat(store.latitude), parseFloat(store.longitude));
  
        var marker = new google.maps.Marker({
          draggable: false,
          position: position,
          optimized: false,
          map: map,
          title: store.title,
          icon: {
            url: getStoreIcon(store.type),
            scaledSize: new google.maps.Size(64, 64), // scaled size
            origin: new google.maps.Point(0, 0), // origin
            anchor: new google.maps.Point(0, 0) // anchor
          }
        });
  
        latLngBounds.extend(position);
  
        marker.addListener('click', function () {
          showInfoWindow(marker, store)
        });
  
        markers.push(marker);
      });
  
      stores.length && map.fitBounds(latLngBounds);
    }
  
    function removeOldMarkers() {
      markers.map(function (marker) {
        marker.setMap(null)
      });
      markers = [];
    }
  
    function showInfoWindow(marker, store) {
      var template = `<div class="sbsl-info-window">
                          ${options.popUpTemplate}
                      </div>`;
  
      template = template.replace(/\[TITLE\]/g, store.title);
      template = template.replace(/\[META_ADDRESS\]/g, store.address);
      template = template.replace(/\[META_PHONE\]/g, store.phone);
      template = template.replace(/\[META_DIRECTIONS\]/g, getStoreDirection(store));
      template = template.replace(/\[META_DESCRIPTION\]/g, store.description);
      template = template.replace(/\[META_TYPE\]/g, getStoreTypeTitle(store.type));
  
      infoWindow.setContent(template);
      infoWindow.open(map, marker);
    }
  
    function updateStoreList(stores) {
      var html = '';
      var $resultDiv = $('#sbsl-stores-list');
  
      if (!stores.length) {
        $resultDiv.html('<div class="sbsl-no-results">No results found.</div>');
        return;
      }
  
      stores.forEach(function (store) {
  
        var storeIcon = getStoreIcon(store.type);
        var distanceInMiles = calcStoreDistance(store);
        var storeDirection = getStoreDirection(store);
  
        html = html + `<div class="sbsl-store-item">
                          <div class="sbsl-img">
                              <img src="${storeIcon}" alt="icon"/>
                              <span class="distance">${distanceInMiles} mi</span>
                          </div>
                          <div class="sbsl-item-meta">
                              <h4>${store.title}</h4>
                              <h5>${store.address}</h5>
                              <p>
                              <a href="tel:${store.phone}">${store.phone}</a>
                              <a href="${storeDirection}" target="_blank">Get Directions</a>
                              </p>
                              <span class="description">${store.description}</span>
                          </div>
                      </div>`;
      });
  
      $resultDiv.html(html);
    }
  
    $("#sbsl-nav").find('.nav-btn').on('click.sbsl', function (e) {
      e.preventDefault();
  
      if ($(this).hasClass('next')) {
        searchParams.page++;
      } else {
        searchParams.page--;
      }
  
      sendAjaxRequest();
      scrollTopInMobile();
    });
  
    function updateNavigation(meta) {
      var $nav = $("#sbsl-nav");
      var $prev = $nav.find('.prev').first();
      var $next = $nav.find('.next').first();
  
      $nav.find('.nav-btn').hide(0);
  
      if (meta.page === 1) {
        $prev.hide(0)
      }
  
      if (meta.page === meta.max_num_pages) {
        $next.hide(0);
      }
  
      if (meta.page < meta.max_num_pages) {
        $next.show(0);
      }
  
      if (meta.page > 1 && meta.page <= meta.max_num_pages) {
        $prev.show(0);
      }
  
    }
  
    function getStoreIcon(type) {
      try {
        return options.storeTypes[type].icon;
      } catch (e) {
        return false
      }
    }
  
    function getStoreTypeTitle(type) {
      try {
        return options.storeTypes[type].title;
      } catch (e) {
        return false
      }
    }
  
    /**
     * @source https://stackoverflow.com/questions/1502590/calculate-distance-between-two-points-in-google-maps-v3
     * @param  store Object
     * @returns {string}
     */
    function calcStoreDistance(store) {
      var storePosition = new google.maps.LatLng(parseFloat(store.latitude), parseFloat(store.longitude));
  
      return Number(google.maps.geometry.spherical.computeDistanceBetween(userLocation, storePosition) * 0.000621371).toFixed(2);
    }
  
    function getStoreDirection(store) {
      return 'https://www.google.com/maps/dir/?api=1&destination=' + parseFloat(store.latitude) + ',' + parseFloat(store.longitude);
    }
  
    function scrollTopInMobile() {
      if ($(window).width() < 769) {
        $(document.body).animate({
          scrollTop: $("#sbsl-stores").offset().top - 50
        }, 2000);
      }
    }
  
  })(window, jQuery);