/**
Address editable input.
Internally value stored as {city: "Moscow", street: "Lenina", building: "15"}

@class address
@extends abstractinput
@final
@example
<a href="#" id="address" data-type="address" data-pk="1">awesome</a>
<script>
$(function(){
    $('#address').editable({
        url: '/post',
        title: 'Enter city, street and building #',
        value: {
            city: "Moscow", 
            street: "Lenina", 
            building: "15"
        }
    });
});
</script>
**/
(function ($) {
    "use strict";
    
    var Address = function (options) {
        this.init('address', options, Address.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(Address, $.fn.editabletypes.abstractinput);

    $.extend(Address.prototype, {
        /**
        Renders input from tpl

        @method render() 
        **/        
        render: function() {
           this.$input = this.$tpl.find('input');
        },
        
        /**
        Default method to show value in element. Can be overwritten by display option.
        
        @method value2html(value, element) 
        **/
        value2html: function(value, element) {
            if(!value) {
                $(element).empty();
                return; 
            }
            var html = '<span class="address">'+value.address+'</span>';
            if (value.address_2) {
              html = html + ', <span class="address_2">'+value.address_2+'</span>';            
            }
            html = html + ', <span class="city">'+value.city+'</span>'+
              ', <span class="state">'+value.state+'</span>'+
              ', <span class="zip_code">'+value.zip_code+'</span>'+
              ', <span class="country">'+value.country+'</span>';
            
            $(element).html(html); 
        },
        
        /**
        Gets value from element's html
        
        @method html2value(html) 
        **/        
        html2value: function(html) {  
          var domHTML = $.parseHTML(html); 
          return {
              address: domHTML[0].innerText,
              address_2: domHTML[10].innerText,
              city: domHTML[2].innerText, 
              state: domHTML[4].innerText, 
              zip_code: domHTML[6].innerText, 
              country: domHTML[8].innerText
           };
        },
      
       /**
        Converts value to string. 
        It is used in internal comparing (not for sending to server).
        
        @method value2str(value)  
       **/
       value2str: function(value) {
           var str = '';
           if(value) {
               for(var k in value) {
                   str = str + k + ':' + value[k] + ';';  
               }
           }
           return str;
       }, 
       
       /*
        Converts string to value. Used for reading value from 'data-value' attribute.
        
        @method str2value(str)  
       */
       str2value: function(str) {
           /*
           this is mainly for parsing value defined in data-value attribute. 
           If you will always set value by javascript, no need to overwrite it
           */
           return str;
       },                
       
       /**
        Sets value of input.
        
        @method value2input(value) 
        @param {mixed} value
       **/         
       value2input: function(value) {
           if(!value) {
             return;
           }
           this.$input.filter('[name="address"]').val(value.address);
           this.$input.filter('[name="address_2"]').val(value.address_2);
           this.$input.filter('[name="city"]').val(value.city);
           this.$input.filter('[name="state"]').val(value.state);
           this.$input.filter('[name="zip_code"]').val(value.zip_code);
           this.$input.filter('[name="country"]').val(value.country);
       },       
       
       /**
        Returns value of input.
        
        @method input2value() 
       **/          
       input2value: function() { 
           return {
              address: this.$input.filter('[name="address"]').val(),
              address_2: this.$input.filter('[name="address_2"]').val(),
              city: this.$input.filter('[name="city"]').val(), 
              state: this.$input.filter('[name="state"]').val(), 
              zip_code: this.$input.filter('[name="zip_code"]').val(), 
              country: this.$input.filter('[name="country"]').val()
           };
       },        
       
        /**
        Activates input: sets focus on the first field.
        
        @method activate() 
       **/        
       activate: function() {
            this.$input.filter('[name="address"]').focus();
       },  
       
       /**
        Attaches handler to submit form in case of 'showbuttons=false' mode
        
        @method autosubmit() 
       **/       
       autosubmit: function() {
           this.$input.keydown(function (e) {
                if (e.which === 13) {
                    $(this).closest('form').submit();
                }
           });
       }       
    });
    Address.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-address"><label><span>Street: </span><input type="text" name="address" class="input-small"></label></div>'+             
             '<div class="editable-address"><label><span>Address 2: </span><input type="text" name="address_2" class="input-mini"></label></div>'+
             '<div class="editable-address"><label><span>City: </span><input type="text" name="city" class="input-small"></label></div>'+
             '<div class="editable-address"><label><span>State: </span><input type="text" name="state" class="input-small"></label></div>'+
             '<div class="editable-address"><label><span>ZIP/Postal Code: </span><input type="text" name="zip_code" class="input-small"></label></div>'+
             '<div class="editable-address"><label><span>Country: </span><input type="text" name="country" class="input-small"></label></div>',
        inputclass: ''
    });

    $.fn.editabletypes.address = Address;

}(window.jQuery));