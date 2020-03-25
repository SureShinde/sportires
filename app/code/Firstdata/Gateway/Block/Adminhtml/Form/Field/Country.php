<?php

namespace Firstdata\Gateway\Block\Adminhtml\Form\Field;

class Country extends \Magento\Config\Block\System\Config\Form\Field {

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
        //url to load the reseller        
        $url = $this->getUrl('fgateway/ajax/localisation');
        $element->setData('after_element_html', "<script>
        require([
            'prototype'
        ], function () {   
        
        // Put all your code in your document ready area
        Event.observe(window, 'load', function(){
        // Do jQuery stuff using $

        var countryReseller = Class.create();
        countryReseller.prototype = {
            initialize : function()
            {                
                this.loader = new varienLoader(true);
                this.resellersUrl = '" . $url . "';
                this.resellerConfig = {};
                this.bindCountryResellerRelation();
            },
            bindCountryResellerRelation : function(parentId)
            { 
                if(parentId) {
                    // todo: fix bug in IE
                    var countryElements = $$('#'+parentId+' select[id$=\"firstdata_country\"]');
                } else {
                    var countryElements = $$('select[id$=\"firstdata_country\"]');
                }
                for(var i=0; i<countryElements.size(); i++) {
                    Event.observe(countryElements[i], 'change', this.reloadResellerField.bind(this));
                    this.initResellerField(countryElements[i]); 
                }
            },

            
            initResellerField : function(element)
            {
                var countryElement = element;
                if (countryElement && countryElement.id) {
                    var resellerElement  = $(countryElement.id.replace(/country/, 'reseller'));
                    if (resellerElement && countryElement.value != '') {                                 
                        this.resellerElement = resellerElement;                        
                        var url = this.resellersUrl+'country/'+countryElement.value;
                        this.loader.load(url, {}, this.refreshResellerField.bind(this));                        
                    }
                }
            },
            reloadResellerField : function(event)
            {                
                var countryElement = Event.element(event);
                if (countryElement && countryElement.id) {
                    var resellerElement  = $(countryElement.id.replace(/country/, 'reseller'));
                    if (resellerElement) {                                    
                        this.resellerElement = resellerElement;
                        var url = this.resellersUrl+'country/'+countryElement.value;
                        this.loader.load(url, {}, this.refreshResellerField.bind(this));
                    }
                }
            },
            refreshResellerField : function(serverResponse)
            {
                if (serverResponse) {
                    var data = eval('(' + serverResponse + ')');
                    var value = this.resellerElement.value;
                    var disabled = this.resellerElement.disabled;
                    if (data.length) {                                                 
                        var html = '<select name=\"'+this.resellerElement.name+'\" id=\"'+this.resellerElement.id+'\" class=\"required-entry select\" title=\"'+this.resellerElement.title+'\"'+(disabled?\" disabled\":\"\")+'>';
                        html+= '<option value=\"\">Please select<\/option>';
                        for (var i in data) {
                            if(data[i].label) {
                                html+= '<option value=\"'+data[i].value+'\"';
                                if(this.resellerElement.value && (this.resellerElement.value == data[i].value || this.resellerElement.value == data[i].label)) {
                                    html+= ' selected';
                                }
                                html+='>'+data[i].label+'<\/option>';
                            }
                            this.resellerConfig[data[i].value] = data[i];
                        }
                        html+= '<\/select>';

                        var parentNode = this.resellerElement.parentNode;
                        var resellerElementId = this.resellerElement.id;
                        parentNode.innerHTML = html;
                        this.resellerElement = $(resellerElementId); 
                        // Init configuration based on reseller
                        Event.observe(this.resellerElement, 'change', this.reloadConfigField.bind(this));
                        this.initConfigField(this.resellerElement);
                    }
                }
            },
            initConfigField : function(element)
            {                
                var resellerElement     = element;
                var pluginLogoElement   = $(logo_details);                
                var supportDetails      = $(support_details);                
                
                pluginLogoElement.innerHTML = '';                
                supportDetails.innerHTML = '';                
                    
                if (resellerElement && resellerElement.value != '') {                    
                    var resellerConfig = this.resellerConfig[resellerElement.value];
                    
                    pluginLogoElement.innerHTML  = '<img title\"'+resellerConfig.plugin_name +'\" src=\"'+resellerConfig.logo+'\">';                    
                    supportDetails.innerHTML = '<h3>'+resellerConfig.customer_detail_title+'</h3><p>'+resellerConfig.customer_detail+'</p><h3>'+resellerConfig.contact_support_title+'</h3><p>'+resellerConfig.contact_support+'</p>';   
                    
                    var titleElement  = $(resellerElement.id.replace(/reseller/, 'title'));
                    if (titleElement) {
                        titleElement.value = resellerConfig.plugin_name;
                        titleElement.readOnly = true;
                    }
                    
                    var descriptionElement  = $(resellerElement.id.replace(/reseller/, 'description'));
                    if (descriptionElement && resellerConfig.description != '' && descriptionElement.value == '') {
                        descriptionElement.value = resellerConfig.description;
                    }
                                        
                    var dynamicDescriptorElement  = $('row_'+resellerElement.id.replace(/reseller/, 'dynamic_descriptor'));
                    if (dynamicDescriptorElement && resellerConfig.dynamic_merchant_name == 'no') {
                        $(resellerElement.id.replace(/reseller/, 'dynamic_descriptor')).value = '';
                        dynamicDescriptorElement.hide();
                    }else{
                        dynamicDescriptorElement.show();
                    }
                    
                    var edccElement  = $('row_'+resellerElement.id.replace(/reseller/, 'edcc'));
                    if (edccElement && resellerConfig.dcc_skip_offer == 'no') {
                        $(resellerElement.id.replace(/reseller/, 'edcc')).value = '0';
                        edccElement.hide();
                    }else{
                        edccElement.show();
                    }
                    
                    var three_d_secureElement  = $('row_'+resellerElement.id.replace(/reseller/, 'three_d_secure'));
                    if (three_d_secureElement && resellerConfig.secure_pay == 'no') {
                        $(resellerElement.id.replace(/reseller/, 'three_d_secure')).value = 'false';
                        three_d_secureElement.hide();
                    }else{
                        three_d_secureElement.show();
                    }
                    
                    var emi_active  = $('row_'+resellerElement.id.replace(/reseller/, 'emi_active'));
                    if (emi_active && resellerConfig.instalments == 'no') {                        
                        $(resellerElement.id.replace(/reseller/, 'emi_active')).value = '0';
                        var emiElements = $(resellerElement.id.replace(/reseller/, 'emi_options')).select('button.action-delete');
                        for(var i=0; i<emiElements.size(); i++) {                            
                            emiElements[i].click();       
                        }

                        emi_active.hide();
                        $('row_'+resellerElement.id.replace(/reseller/, 'heading_installment')).hide();
                        $('row_'+resellerElement.id.replace(/reseller/, 'emi_options')).hide();                        
                    }else{
                        emi_active.show();
                        $('row_'+resellerElement.id.replace(/reseller/, 'heading_installment')).show();
                        if($(resellerElement.id.replace(/reseller/, 'emi_active')) == '0'){
                            $('row_'+resellerElement.id.replace(/reseller/, 'emi_options')).show();                        
                        }
                    }
                    
                    var local_active  = $('row_'+resellerElement.id.replace(/reseller/, 'localpayments'));
                    if (local_active && resellerConfig.local_payment.length == 0) {                        
                        $(resellerElement.id.replace(/reseller/, 'localpayments')).value = '0';
                        $(resellerElement.id.replace(/reseller/, 'localpaymentslist')).value = '0';
                        
                        local_active.hide();
                        $('row_'+resellerElement.id.replace(/reseller/, 'heading_localpayments')).hide();                         
                        $('row_'+resellerElement.id.replace(/reseller/, 'localpaymentslist')).hide();                                                
                    }else{
                        local_active.show();
                        $('row_'+resellerElement.id.replace(/reseller/, 'heading_localpayments')).show();
                        if($(resellerElement.id.replace(/reseller/, 'localpayments')).value == '1'){
                            $('row_'+resellerElement.id.replace(/reseller/, 'localpaymentslist')).show();      
                        }                        
                    }
                }
            },
            reloadConfigField : function(event)
            {                
                var resellerElement = Event.element(event);
                this.initConfigField(resellerElement);
            }
        }

        new countryReseller();
        });
        });
        </script>
        ");

        return parent::_getElementHtml($element);
    }

}