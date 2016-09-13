 (function($){

	$(document).ready(function(){
		$('#do-qcm-form').on('submit',function(e){
	   			e.preventDefault();

	   			$.ajax({
				    method: "POST",
				    url: '/eleve/question/resultat', 
				    data: $(this).serialize()
				}).success(function(response) {

					if(response.status == "success"){
						console.log("réponses : ",response.correction);
						$('#submitDoForm').remove();
						$('#'+response.message).fadeIn();
						
						if(typeof(response.correction) == "string"){
							$('.'+response.correction).addClass('correctAnswer');
						}
						else{
							$.each(response.correction, function( index, idChoice ) {
								$('.'+idChoice).addClass('correctAnswer');
							});
						}

						if(response.explication !== '' && (response.message == 'wrong' || response.message == 'half-correct') ){
							$('.explication-block').fadeIn();
							$('.explication').html(response.explication);
						}

					}else{
						alert("Il y a eu un problème dans l'enregistrement du score.");
					}
				    
			});
		});

         $('#submitDoForm').on('click',function(e){
            e.preventDefault();

            var valid = true;

            if($('#question_type').val() == "Multiple")
                valid = $('input[type=checkbox]:checked', '#do-qcm-form').length > 0 ? true : false;
            else
                valid =  $('input[type=radio]:checked', '#do-qcm-form').length > 0 ? true : false;
            
            if(valid){
                $('.errorForm').fadeOut();
                $('#do-qcm-form').submit();  
            } 
            else{
                console.log("unvalid");
                 $('.errorForm').fadeIn();
            }
        });


   });

})(jQuery);