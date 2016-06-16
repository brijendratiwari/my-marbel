/**
Name editable input.
Internally value stored as {city: "Moscow", street: "Lenina", building: "15"}

@class phone
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
    
    var Phone = function (options) {
        this.init('phone', options, Phone.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(Phone, $.fn.editabletypes.abstractinput);

    $.extend(Phone.prototype, {
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
            var html = '<span class="phone">'+value.phone+'</span>';
            if (value.phone_2) {
              html = html + ' <span class="phone_2">'+value.phone_2+'</span>';
            }
            $(element).html(html); 
        },
        
        /**
        Gets value from element's html
        
        @method html2value(html) 
        **/        
        html2value: function(html) {
          var domHTML = $.parseHTML(html); 
          return {
            phone: domHTML[0].innerText,
            phone_2: domHTML[2].innerText
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
           this.$input.filter('[name="phone"]').val(value.phone);
           this.$input.filter('[name="phone_2"]').val(value.phone_2);
       },       
       
       /**
        Returns value of input.
        
        @method input2value() 
       **/          
       input2value: function() { 
           return {
              phone: this.$input.filter('[name="phone"]').val(),
              phone_2: this.$input.filter('[name="phone_2"]').val()
           };
       },        
       
        /**
        Activates input: sets focus on the first field.
        
        @method activate() 
       **/        
       activate: function() {
            this.$input.filter('[name="phone"]').focus();
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
    Phone.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-phone"><label><span>Phone Number: </span><input type="text" name="phone" class="input-small"></label></div>'+             
             '<div class="editable-phone"><label><span>Secondary Number: </span><input type="text" name="phone_2" class="input-mini"></label></div>',
        inputclass: ''
    });

    $.fn.editabletypes.phone = Phone;

}(window.jQuery));