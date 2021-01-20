function initialize(){var e=$.trim($("#latitude").val()),a=$.trim($("#longitude").val());if(e.length>0||a.length>0)setMapPosition(e,a);else{var t=$("#village").find(":selected").data("village"),o=$("#village").find(":selected").data("district");setGeo(t,o)}}function setGeo(e,a){geocoder=new google.maps.Geocoder,geocoder.geocode({address:e+", kecamatan "+a+"Kabupaten Garut"},function(e,a){if(a==google.maps.GeocoderStatus.OK){var t=e[0].geometry.location.lat(),o=e[0].geometry.location.lng();setMapPosition(t,o)}else console.log("Error")})}function setMapPosition(e,a){map=new google.maps.Map(document.getElementById("map_canvas"),{center:new google.maps.LatLng(e,a),zoom:16,panControl:!1,mapTypeId:google.maps.MapTypeId.HYBRID});var t=new google.maps.LatLng(e,a);marker=new google.maps.Marker({position:t,map:map,draggable:!0,icon:"/marker.png"}),setMarker(t),google.maps.event.addListener(marker,"drag",function(){setMarker(marker.getPosition())})}function setMarker(e){$("#latitude").val(e.lat()),$("#longitude").val(e.lng())}var sikobeMapIsInitialized=!1;$('a[data-toggle="tab"]').on("shown.bs.tab",function(e){sikobeMapIsInitialized||(sikobeMapIsInitialized=!0,initialize())}),google.maps.event.addDomListener(window,"load",initialize),$("#village").change(function(){var e=$(this).find(":selected").data("village"),a=$(this).find(":selected").data("district");setGeo(e,a)});