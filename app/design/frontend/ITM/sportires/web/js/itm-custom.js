require([
  "jquery"
], 
function($) {
  "use strict";

    const store = '/pub/media/sportires/map/stores.json';

    jQuery(document).ready(function($){

      var states = {
      	"Aguascalientes": "577",
      	"Baja California": "578",
      	"Baja California Sur": "579",
      	"Campeche": "580",
      	"Coahuila de Zaragoza": "",
      	"Colima": "",
      	"Chiapas": "581",
      	"Chihuahua": "582",
      	"Ciudad de México": "583",
      	"Durango": "586",
      	"Guanajuato": "588",
      	"Guerrero": "589",
      	"Hidalgo": "590",
      	"Jalisco": "591",
      	"México": "587",
      	"Michoacán de Ocampo": "592",
      	"Morelos": "593",
      	"Nayarit": "594",
      	"Nuevo León": "595",
      	"Oaxaca": "596",
      	"Puebla": "597",
      	"Querétaro": "598",
      	"Quintana Roo": "599",
      	"San Luis Potosí": "600",
      	"Sinaloa": "601",
      	"Sonora": "602",
      	"Tabasco": "603",
      	"Tamaulipas": "604",
      	"Tlaxcala": "605",
      	"Veracruz de Ignacio de la Llave": "606",
      	"Yucatán": "607",
      	"Zacatecas": "608"
      };

      var existCondition = setInterval(function() {
           if ($("input[name='postcode']").length) { 
            clearInterval(existCondition);
            startValidate();
            getCodeData();
           }
        }, 100);

      function startValidate(){
        $(".title").trigger("click");
        //$("input[name='city']").attr("readonly","readonly");
        //$("input[name='region']").attr("readonly","readonly");
        $("input[name='postcode']").attr("maxlength","5");

        $("input[name='telephone']").keyup(function(e){
          
          if (/\D/g.test(this.value))
          {
            this.value = this.value.replace(/\D/g, '');
          }
        });
      }

      function getCodeData(){
        $("input[name='postcode']").keyup(function(e){
          
          if (/\D/g.test(this.value))
          {
            this.value = this.value.replace(/\D/g, '');
          } else {

            var codigo = $(this).val();

            if(codigo.toString().length >= 5){
               $.get("https://api-codigos-postales.herokuapp.com/v2/codigo_postal/" + codigo.toString(), function(data, status){
                   $("input[name='city']").val(data.municipio);
                   $("input[name='region']").val(data.estado);
                   $("div[name='shippingAddress.region_id'] select.select").val(states[data.estado]).change();
                   $("input[name='city']").keyup();
                   $("input[name='region']").keyup();
                 });  
            }

          }



        });        
      }


      /***********************************/
      /******** Mapa de sucursales *******/
      /***********************************/

     if( $('#sucursales').length ) 
      {
      $.sanitize = function(input) {
      return input.replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '');
      };
  
          $.getJSON(store, function(data) {
           $.each(data.features, function(key, val){
             const id = 'sucursal' + key;
             const category = val.properties.category;
             const name = val.properties.name;
             const description = val.properties.description;
             const hours = val.properties.hours;
             const phone = val.properties.phone;
            $("#sucursales").append('<div id="' + id  +'" class="card bg-info mb-3">\
              <div class="card-header">' + name + '</div><div class="card-body">\
              <h5 class="card-title">' + hours  + '</h5><p class="card-text">\
              ' + description + '</p></div></div>');
               $("#" + id ).click(function(){
                 map.setZoom(15);
                 map.setCenter({
                   lat : val.geometry.coordinates[1],
                   lng : val.geometry.coordinates[0]
                 });
               });
           });
          });   
      }


        
    });
    return;
});