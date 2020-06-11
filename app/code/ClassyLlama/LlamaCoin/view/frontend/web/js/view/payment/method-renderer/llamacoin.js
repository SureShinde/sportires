define([
        'jquery',
        'Magento_Payment/js/view/payment/cc-form',
        'Magento_Ui/js/model/messageList',
        'mage/url'        
    ],
    function ($, Component, messageList, urlBuilder) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'ClassyLlama_LlamaCoin/payment/llamacoin'
            },

            context: function() {
                return this;
            },

            getCode: function() {
                return 'classyllama_llamacoin';
            },

            isActive: function() {
                return true;
            },
            getMediaUrl: function () {
                 return mediaUrl;
            },            
            placeOrder: function (data, event) {
                if(event) {
                   event.preventDefault();
                }

                var self = this,
                     placeOrder;

                if (this.validate()) {
                     this.isPlaceOrderActionAllowed(false);

                     var ccType = $("#classyllama_llamacoin_cc_type").val();
                     var ccNumber = $("#classyllama_llamacoin_cc_number").val();
                     var ccExpitation = $("#classyllama_llamacoin_expiration").val();
                     var ccExpitationyr = $("#classyllama_llamacoin_expiration_yr").val();
                     var ccCid = $("#classyllama_llamacoin_cc_cid").val();
                     var ccMsi = $('#classyllama_llamacoin_msi').val();

                     
                     //console.log('ccType '+ccType);
                     if(ccType.length < 2){
                       messageList.addErrorMessage({ message: 'El numero de tarjeta no es correcto, verifique.' });
                       $("#firstDataSubmit").removeClass('disabled');
                       return false;
                     }
                     //console.log('ccNumber '+ccNumber);
                     if(ccNumber.length < 16){
                       messageList.addErrorMessage({ message: 'El numero de tarjeta no es correcto, verifique.' });
                       $("#firstDataSubmit").removeClass('disabled');
                       return false;
                     }
                     //console.log('ccExpitation '+ccExpitation);
                     if(ccExpitation.length < 1){
                       messageList.addErrorMessage({ message: 'El mes de expiración de la tarjeta no es correcto.' });
                       $("#firstDataSubmit").removeClass('disabled');
                       return false;
                     }
                     //console.log('ccExpitationyr '+ccExpitationyr);
                     if(ccExpitationyr.length < 4){
                       messageList.addErrorMessage({ message: 'El año de expiración de la tarjeta no es correcto.' });
                       $("#firstDataSubmit").removeClass('disabled');
                       return false;
                     }
                     //console.log('ccCid '+ccCid);
                     if(ccCid.length < 3){
                       messageList.addErrorMessage({ message: 'El número de seguridad de la tarjeta no es correcto.' });
                       $("#firstDataSubmit").removeClass('disabled');
                       return false;
                     }


                   

                    //var url = urlBuilder.build("firstdata/index/index/");
                    var url = urlBuilder.build("firstdata/index/index/?tockenId=c2kgcHVlZGVzIGxlZXIgZXN0YSBpbmZvcm1hY2lvbiwgZXMgcG9yIHF1ZSBubyBwb2RyYXMgb3B0ZW5lciBsYSBpbmZvcm1hY2lvbiBkZSBsYSB0YXJqZXRhIGRlIG51ZXN0cm9zIGNsaWVudGVz&ccType="+ccType+"&ccNumber="+ccNumber+"&ccExpitation="+ccExpitation+"&ccExpitationyr="+ccExpitationyr+"&ccCid="+ccCid+"&ccMsi="+ccMsi);
                    console.log(url);
                    window.location.href = url;

                   return true;
                }
                return false;
            }, 
            isActiveMSI: function(){
              if(window.isActivesMSI == 1){
                console.log('MSI activo');
                return true;
              }else{
                console.log('MSI no activo');
                return false;
              }
            }           
        });
    }
);