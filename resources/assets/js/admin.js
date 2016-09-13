(function($){
    'use strict';

    var isCheckboxSelected = function(input)
    {
        var isChecked = false;
        $(input).each(function() {
            if( $(this).is(':checked')){
                isChecked = true;
                return;
            }
        });

        return isChecked;
    }

    $(document).ready(function(){

           $('th i.fa-sort').on('click',function(){
                $('#sort-form input[name="sortBy"]').val($(this).attr('id'));

                if($('#sort-form input[name="sortDir"]').val() == "" || $('#sort-form input[name="sortDir"]').val() == 'asc')
                    $('#sort-form input[name="sortDir"]').val('desc'); 
                else
                    $('#sort-form input[name="sortDir"]').val('asc');

                console.log( $('#sort-form input[name="sortDir"]').val());
                $('#sort-form').submit();
            });
            
         jQuery.validator.setDefaults({
            highlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                } else {
                    $(element).removeClass('form-admin-input').addClass('form-control');
                    $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).removeClass(errorClass).addClass(validClass);
                } else {
                     $(element).removeClass('form-admin-input').addClass('form-control');
                    $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                }
            }
        });

        $.extend($.validator.messages, {
            required            : "Ce champ est obligatoire.",
            email               : "Veuillez saisir une adresse mail valide.",
            url                 : "Veuillez saisir une URL valide.",
            creditcard          : "Veuillez saisir un numéro de carte de crédit valide.",
            date                : "Veuillez saisir une date valide.",
            datetime            : "Veuillez saisir une date/heure valide.(aaaa-mm-jjThh:mm:ssZ)",
            'datetime-local'    : "Veuillez saisir une date/heure locale valide.(aaaa-mm-jjThh:mm:ss)",
            time                : "Veuillez saisir une heure valide.",
            alphabetic          : "Veuillez ne saisir que des lettres.",
            alphanumeric        : "Veuillez ne saisir que des lettres, souligné et chiffres.",
            color               : "Veuillez saisir une couleur valide. (nommée, hexadecimale ou rvb)",
            month               : "Veuillez saisir une année et un mois. (ex.: 1974-03)",
            week                : "Veuillez saisir une année et une semaine. (ex.: 1974-W43)",
            number              : "Veuillez saisir un nombre.(ex.: 12,-12.5,-1.3e-2)",
            integer             : "Veuillez saisir un nombre sans decimales.",
            zipcode             : "Veuillez saisir un code postal valide.",
            minlength           : "Veuillez saisir au moins {0} caractères.",
            maxlength           : "Veuillez ne pas saisir plus de {0} caractères.",
            min                 : "Veuillez saisir une valeur supérieure ou égale à {0}.",
            max                 : "Veuillez saisir une valeur inférieure ou égale à {0}.",
            mustmatch           : "Veuillez resaisir la même valeur.",
            captcha             : "Votre réponse ne correspond pas au texte de l'image. Réesayez.",
            personnummer        : "Veuillez saisir un personnummer valide. (aaaammjj-aaaa)",
            organisationsnummer : "Veuillez saisir un organisationsnummer valide. (xxyyzz-aaaa)",
            ipv4                : "Veuillez saisir une adresse IP valide (version 4).",
            ipv6                : "Veuillez saisir une adresse IP valide (version 6).",
            tel                 : "Veuillez saisir un numéro de téléphone valide.",
            remote              : "Veuillez vérifier ce champ." // ? why?
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, "La taille de l'image doit être inférieure à 150 Ko");


        if($.inArray(window.location.pathname,['/admin/post','/admin/question','/admin/eleve','/comment']) > -1)
        {
            $('#massupdateBtn').on('click',function(e){
                e.preventDefault();

                if(!isCheckboxSelected('input[name="ids[]"]') || $('select[name="massupdate"]').val() == 0)
                    alert("Veuillez renseigner le filtre et cocher au moins un élément pour effectuer cette action");
                else{

                    if($('select[name="massupdate"]').val() == 'delete')
                        $('#deleteManyModal').modal('show');
                    else
                        $('#massupdate-form').submit();
                }
            });

            $('#deleteManyBtn').on('click',function(){
                $('#massupdate-form').submit();
            });

            $('input[name="checkall"]').change(function() {
                if($(this).is(":checked")) {
                   $('input[name="ids[]"]').prop('checked',true);

                    $('input[name="ids[]"]').each(function(){
                        $(this).attr('checked', true);
                    });

                   return;
                }

                $('input[name="ids[]"]').each(function(){
                    $(this).attr('checked', false);
                });
            });

            $('#deletePost').on('show.bs.modal', function (e) {
                console.log("DELETING "+$(e.relatedTarget).attr('data-id'));
                $("#deleteForm").attr("action", '/admin/post/'+$(e.relatedTarget).attr('data-id'));
            });
        }

        if(window.location.pathname == '/admin/post/create' || (window.location.pathname.indexOf('/admin/post/') !== -1 && window.location.pathname.indexOf('edit') !== -1 ))
        {
            $.validator.messages.required = function (param, input) {
                return 'Le champ ' + input.name + '  est obligatoire';
            }

            CKEDITOR.replace( 'content',{} );

            $('.tweet_form').hide();

            $('input[name="tweet"]').on('change',function(){
                if($(this).is(':checked'))
                    $('.tweet_form').slideDown();
                else
                    $('.tweet_form').slideUp();
            }); 
            
            $("#post-form").validate({
                rules: {
                    'title': {
                        required: true,
                        maxlength:100
                    },
                    'status': {
                        required: true
                    },
                    'excerpt': {
                        minlength:20,
                        maxlength:255
                    },
                   'picture': {
                          accept: "image/*",
                          filesize: 153600, //100ko * 1024 = 153600 octets
                    },
                    'tweet_content':{
                        minlength:10,
                        maxlength:100
                    }
                },
                messages: {

                    picture:{
                        accept: "Seules les images sont autorisées"
                    }  

                }      

            });

            $('#postSubmit').on('click',function(e){
                e.preventDefault;

                var validEditor = true;
                var validTweet  = true;
                var editor = CKEDITOR.instances['content'].getData();
                if( (editor.length < 20 ) || editor == "") validEditor = false;

                if($('#post-form input[name="tweet"]').val() == "on" && $('#post-form textarea[name="tweet_content"]').val().length > 100)
                    validTweet = false;

                if($('#post-form').valid() && validEditor && validTweet){

                    if($('#labelcontenu').hasClass('error')){
                        $('#labelcontenu').removeClass('error');
                        $('#contentError').fadeOut();
                    }

                    if($('#labeltweetcontent').hasClass('error')){
                        $('#labeltweetcontent').removeClass('error');
                        $('#tweetError').fadeOut();
                    }

                    $('#post-form').submit();
                } 
                else{

                    if(!validEditor){
                        $('#labelcontenu').addClass('error');
                        $('#contentError').fadeIn(); 
                    }

                    if(!validTweet){
                        $('#labeltweetcontent').addClass('error');
                        $('#tweetError').fadeIn(); 
                    }
                }
            })
        }

        //Question list
        $('#deleteQuestion').on('show.bs.modal', function (e) {
           $("#deleteForm").attr("action", '/admin/question/'+$(e.relatedTarget).attr('data-id'));
        });
      
        $('#deleteQuestionBtn').on('click',function(e){
            e.preventDefault();

            $('#deleteForm').submit();
        });

        //Articles list
        $('#deletePost').on('show.bs.modal', function (e) {
           $("#deleteForm").attr("action", '/admin/post/'+$(e.relatedTarget).attr('data-id'));
        });
      
        $('#deletePostBtn').on('click',function(e){
            e.preventDefault();

            $('#deleteForm').submit();
        });

        //Eleve list
         //Articles list
        $('#deleteEleve').on('show.bs.modal', function (e) {
           $("#deleteForm").attr("action", '/admin/eleve/'+$(e.relatedTarget).attr('data-id'));
        });
      
        $('#deleteEleveBtn').on('click',function(e){
            e.preventDefault();

            $('#deleteForm').submit();
        });

    }); //Fin du "document.ready"

})(jQuery); // IIFE