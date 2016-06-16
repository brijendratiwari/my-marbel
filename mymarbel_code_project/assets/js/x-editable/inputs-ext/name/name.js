/**
Name editable input.
Internally value stored as {city: "Moscow", street: "Lenina", building: "15"}

@class name
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
    
    var Name = function (options) {
        this.init('name', options, Name.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(Name, $.fn.editabletypes.abstractinput);

    $.extend(Name.prototype, {
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
            var html = '<span class="first_name">'+value.first_name+'</span>';
            if (value.middle_name) {
              html = html + ' <span class="middle_name">'+value.middle_name+'</span>';
            }
            html = html + ' <span class="last_name">'+value.last_name+'</span>';
            $(element).html(html); 
        },
        
        /**
        Gets value from element's html
        
        @method html2value(html) 
        **/        
        html2value: function(html) {
          var domHTML = $.parseHTML(html); 
          if (domHTML.length == 5) {
            return {
              first_name: domHTML[0].innerText,
              middle_name: domHTML[2].innerText,
              last_name: domHTML[4].innerText
            };
          } else {
            return {
              first_name: domHTML[0].innerText,
              middle_name: '',
              last_name: domHTML[2].innerText
            };
          }
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
           this.$input.filter('[name="first_name"]').val(value.first_name);
           this.$input.filter('[name="middle_name"]').val(value.middle_name);
           this.$input.filter('[name="last_name"]').val(value.last_name);
       },       
       
       /**
        Returns value of input.
        
        @method input2value() 
       **/          
       input2value: function() { 
           return {
              first_name: this.$input.filter('[name="first_name"]').val(),
              middle_name: this.$input.filter('[name="middle_name"]').val(),
              last_name: this.$input.filter('[name="last_name"]').val()
           };
       },        
       
        /**
        Activates input: sets focus on the first field.
        
        @method activate() 
       **/        
       activate: function() {
            this.$input.filter('[name="first_name"]').focus();
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
    Name.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-name"><label><span>First Name: </span><input type="text" name="first_name" class="input-small"></label></div>'+             
             '<div class="editable-name"><label><span>Middle Name: </span><input type="text" name="middle_name" class="input-mini"></label></div>'+
             '<div class="editable-name"><label><span>Last Name: </span><input type="text" name="last_name" class="input-small"></label></div>',
        inputclass: ''
    });

    $.fn.editabletypes.name = Name;

}(window.jQuery));