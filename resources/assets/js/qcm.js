(function($){
    'use strict';

    $(document).ready(function(){
        
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, "La taille de l'image doit être inférieure à 150 Ko");

        $.extend($.validator.messages, {
            required  : "Ce champ est obligatoire.",
        });

        //Validation contact form
        $("#question-form").validate({
            rules: {
                'title': {
                    required: true
                },
                'nbchoix': {
                    required: true
                },
                'class_level_id': {
                    required: true
                },
                 'type': {
                    required: true
                },
                 'content': {
                    required: true
                },
                'picture': {
                      accept: "image/*",
                      filesize: 153600, //100ko * 1024 = 153600 octets
                },
            }
        });

        $("#choices-form").validate({
            errorPlacement: function(error, element) {
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {
                   $('#radio_error').html("Vous devez valider une des réponses.");
                } else {
                    error.insertAfter(element);
                }
            }
        });


    }); //Fin du "document.ready"

})(jQuery); // IIFE