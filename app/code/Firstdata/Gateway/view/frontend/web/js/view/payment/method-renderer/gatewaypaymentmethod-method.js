/**
* Copyright © 2015 Magento. All rights reserved.
* See COPYING.txt for license details.
*/
/*browser:true*/
/*global define*/
define(
    [
    'Magento_Checkout/js/view/payment/default',    
    'mage/url',
    'jquery'
    ],
    function (Component,url,$) {
        'use strict';	

        $(document).ready(function () {			
                        
            // Show instalment panel
            $(document.body).on('change','#payinstallment',function(){
                if(this.checked){	
                    $('#installment_wrapper').fadeIn('slow');
                }
            });
            
            // Hide instalment  panel
            $(document.body).on('change','#payfull',function(){
                if(this.checked){
                    $('#installment_wrapper').fadeOut('slow');
                }
            });
            
            // Open payment type panel on selection of new card.
            $(document.body).on('change','#paytype',function(){	
                if(this.checked){
                    $('#newpayment_wrapper').fadeIn('slow');
                    $('#local_wrapper').fadeOut('slow');
                    $('#newpayment_wrapper input[type=text]').val('');
                    $('#newpayment_wrapper select').val('');
                    $('#newpayment_wrapper input[type=checkbox]').attr('checked',false);
                }
            });

            // Hide CC panel on selection of saved cards
            $(document.body).on('change','#saved_card',function(){	
                if(this.checked){				
                    $('#newpayment_wrapper').fadeOut('slow');
                }
            });
            
            // Show/Hide local payment list
            $(document.body).on('change','#alternate_enable',function(){			   
                if(this.checked)
                {
                    $('#local_wrapper').fadeIn('slow');
                }
                else
                {
                    $('#local_wrapper').fadeOut('slow');
                }
            });            
            
            // Enable CC form based on local payment method
            $(document.body).on('change','#alternate_payment',function(){
                var localConfig = window.checkoutConfig.payment.firstdata.getcartsupport;
                var selVal = $('#alternate_payment option:selected').val();
                var conf = localConfig[selVal];	
                
                if(selVal!= '' && conf.card_support == false)
                {
                    $("#carddiv").hide(1000);			
                }
                else
                {
                    $("#carddiv").show(1000);
                }						
            });
        });
            
        return Component.extend({
            defaults: {
                template: 'Firstdata_Gateway/payment/gatewaypaymentmethod'  				
            },	
            getData: function() {
                return {
                    'method': this.item.method,
                    'additional_data': {                        
                        'pay_mode' : ( this.getEmi() == 1 && this.getAvailableOptions().length > 1 ) ? $("input[name='pay_mode']:checked").val(): $("input[name='pay_mode']").val(),
                        'pay_type' : ( this.getTokenization() == 1 || this.getLocalpayments() == 1 ) ? $("input[name='pay_type']:checked").val(): null,                        
                        'emi_option' : ( this.getEmi() == 1 && this.getAvailableOptions().length > 1 ) ? $("input[name='pay_installment']:checked").val(): null,
                        'alternate_enable' : ( this.getLocalpayments() == 1 ) ? $('#alternate_enable').val() : null,
                        'alternate_payment' : ( this.getLocalpayments() == 1 ) ? $('#alternate_payment').val() : null                        
                    }
                };
            },
            afterPlaceOrder: function () {
                window.location.replace(url.build('firstdata/redirect/'));
            },
			
            validate: function () {
                
                var pay_mode = ( this.getEmi() == 1 && this.getAvailableOptions().length > 1 ) ? $("input[name='pay_mode']:checked").val(): $("input[name='pay_mode']").val();
                var pay_type = ( this.getTokenization() == 1 || this.getLocalpayments() == 1 ) ? $("input[name='pay_type']:checked").val(): null;
                var installment = ( this.getEmi() == 1 && this.getAvailableOptions().length > 1 ) ? $("input[name='pay_installment']:checked").val(): null;                
                var alternate_enable = $('#alternate_enable').val();
                var alternate_payment = $('#alternate_payment').val();
                              
                var errormessage = window.checkoutConfig.payment.firstdata.geterrormessage;				
                var message = "";
                var errorReturn = true; 
                
                if (!pay_mode)
                {
                    message  += errormessage['invalid_payment_mode'] + "\n"; 
                    errorReturn = false; 
                }
                
                if (!pay_type)
                {
                    message  += errormessage['invalid_payment_option']+ "\n";
                    errorReturn = false; 
                }
                
                if (pay_mode == "installment" && !installment) {
                    message  += errormessage['invalid_installment_detail']+ "\n";			
                    errorReturn = false; 
                }
                
                if (alternate_enable == 1 && alternate_payment == '--Please Select--')
                {              
                    message  += errormessage['invalid_local_payment_option']+ "\n";
                    errorReturn = false; 
                }                
                
                if(message != ""){
                    alert(message);
                }
                
                return errorReturn;
            },

            /** Returns send check to info */
            getMailingAddress: function() {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            getLogoUrl: function () {
                return window.checkoutConfig.payment.firstdata.getLogoUrl;
            },
            getDescription: function () {
                return window.checkoutConfig.payment.firstdata.getDescription;
            },
            getEmi: function () {
                return window.checkoutConfig.payment.firstdata.getEmi;
            },
            getTokenization: function () {
                return window.checkoutConfig.payment.firstdata.getTokenization;
            },
            getAvailableOptions: function () {
                return window.checkoutConfig.payment.firstdata.getAvailableOptions;
            },                                 
            getDisplayLogo: function () {
                return window.checkoutConfig.payment.firstdata.getDisplayLogo;
            },
            getStoreCard: function() {
                return  window.checkoutConfig.payment.firstdata.storedCards;
            },
            getAuthorization: function () {
                return window.checkoutConfig.payment.firstdata.getAuthorization;
            },
            getLocalpayments: function () {
                return window.checkoutConfig.payment.firstdata.getLocalpayments;
            }, 
            getLocalpaymentslist: function () {
                return window.checkoutConfig.payment.firstdata.getLocalpaymentslist;
            }			
        });
    }
);

