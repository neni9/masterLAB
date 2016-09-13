(function($){
    'use strict';

    $(document).ready(function(){


      /* activate jquery masonry */
        setTimeout(function(){
            $('#posts').masonry({
              itemSelector : '.item'
            });
        }, 1000);
     

        //commentaire user identity
        $('#comment-form input[name="identity"]').change(function() {
           if($(this).is(":checked")) {
              $('#comment-form input[name="pseudo"]').val($('#identityUser').text());
              $('#comment-form input[name="pseudo"]').attr('readonly',true);
              return;
           }else{
            $('#comment-form input[name="pseudo"]').val('');
            $('#comment-form input[name="pseudo"]').attr('readonly',false);
           }
           //'unchecked' event code
        });
      

        // var navbar = $('.main-nav');
        var navbarSub = $('#sub-nav');
        $(window).scroll(function(){
            if($(window).scrollTop() <= 320){
                 navbarSub.removeClass('navbar-fixed-top');
            } else {
                navbarSub.addClass('navbar-fixed-top');
            }
        }); 

        jQuery.validator.setDefaults({
            highlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                } else {
                    $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).removeClass(errorClass).addClass(validClass);
                } else {
                    $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                }
            }
        });

        $.extend($.validator.messages, {
            required            : "Ce champ est obligatoire.",
            email               : "Veuillez saisir une adresse mail valide.",
            minlength           : "Veuillez saisir au moins {0} caractères.",
            maxlength           : "Veuillez ne pas saisir plus de {0} caractères.",
            captcha             : "Veuillez réssayez de valider le capcha.",
        });

        $.validator.messages.required = function (param, input) {
            return 'Le champ ' + input.name + '  est obligatoire';
        }


        //Validation contact form
        $("#contact-form").validate({
            rules: {
                 'nom': {
                    required: true,
                    maxlength: 50
                },
                 'prenom': {
                    required: true,
                    maxlength: 50
                },
                'email': {
                    required: true,
                    email: true
                },
                'sujet': {
                    required: true,
                    maxlength: 255
                },
                'message': {
                    required: true,
                    minlength: 5,
                    maxlength: 1000
                },
            },
            errorPlacement: function(error, element) {
                $('.js-errors').append('<br>',error);
            }

        });

        //Validation comment form
        $("#comment-form").validate({
            rules: {
                 'pseudo': {
                    required: true,
                    maxlength: 50
                },
                 'title': {
                    required: true,
                    maxlength: 50
                },
                'content': {
                    required: true,
                    minlength: 5,
                    maxlength: 500
                },
            },
            errorPlacement: function(error, element) {

                if($(element).attr('name') == 'pseudo')
                    $('.js-error-pseudo').append('<br>',error);
                else
                    $('.js-error-'+$(element).attr('name')).append(error);

            }

        });


        $('#next').on('click',function(e){
            e.preventDefault();
            $('#paginate-form input[name="month"]').val($('#next_month').text());
            $('#paginate-form input[name="year"]').val($('#next_year').text());
            $('#paginate-form').submit();
        });

        $('#previous').on('click',function(e){
            e.preventDefault();
            $('#paginate-form input[name="month"]').val($('#prev_month').text());
            $('#paginate-form input[name="year"]').val($('#prev_year').text());
            $('#paginate-form').submit();
        });

        $('#selectBtn').on('click',function(e){
            e.preventDefault();
            var date = $('#paginate-form select[name="selectMonth"]').val().split('-');
           
            $('#paginate-form input[name="month"]').val( date[0]);
            $('#paginate-form input[name="year"]').val( date[1]);
            console.log( $('#paginate-form input[name="month"]').val());
            console.log( $('#paginate-form input[name="year"]').val());
            $('#paginate-form').submit();
        });

    }); //Fin du "document.ready"

})(jQuery); // IIFE