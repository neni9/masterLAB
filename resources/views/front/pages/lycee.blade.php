@extends('layouts.site')
@section('title', $title)
@section('content') 

    <div class='container-fluid'>

        <div class='row'>
             <h1 class="text-center">Le lycée</h1>
        </div>


        <section class="container-fluid">
        
            <div class="row m-bottom">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p class="justify"> Quam ob rem vita quidem talis fuit vel fortuna vel gloria, ut nihil posset accedere, moriendi autem sensum celeritas abstulit; quo de genere mortis difficile dictu est; quid homines suspicentur, videtis; hoc vere tamen licet dicere, P. Scipioni ex multis diebus, quos in vita celeberrimos laetissimosque viderit, illum diem clarissimum fuisse, cum senatu dimisso domum reductus ad vesperum est a patribus conscriptis, populo Romano, sociis et Latinis, pridie quam excessit e vita, ut ex tam alto dignitatis gradu ad superos videatur deos potius quam ad inferos pervenisse.
                    </p>
                </div>
            </div>
            <div class="row m-bottom">
                <div class="col-xs-12 col-md-12 m-bottom col-lg-7"><img src="images/student1.jpg" alt="" class="img-responsive">
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5"><img src="images/teacher1.jpg" alt="" class="img-responsive m-bottom">
                <p class="justify">Quam ob rem vita quidem talis fuit vel fortuna vel gloria, ut nihil posset accedere, moriendi autem sensum celeritas abstulit; quo de genere mortis difficile dictu est; quid homines suspicentur, videtis; hoc vere tamen licet dicere, P. Scipioni ex multis diebus, quos in vita celeberrimos laetissimosque viderit, illum diem clarissimum fuisse, cum senatu dimisso domum reductus ad vesperum est a patribus conscriptis, populo Romano, sociis et Latinis, pridie quam excessit e vita, ut ex tam alto dignitatis gradu ad superos videatur deos potius quam ad inferos pervenisse.</p>
                </div>
            </div>
            <div class="row m-bottom">
                <div class="col-xs-12 col-lg-6">
                <h4>Actualités</h4>
                <p class="justify">Quam ob rem vita quidem talis fuit vel fortuna vel gloria, ut nihil posset accedere, moriendi autem sensum celeritas abstulit; 
                quo de genere mortis difficile dictu est; quid homines suspicentur, videtis; 
                hoc vere tamen licet dicere, P. Scipioni ex multis diebus, quos in vita celeberrimos 
                laetissimosque viderit, illum diem clarissimum fuisse, cum senatu dimisso domum reductus ad
                 vesperum est a patribus conscriptis, populo Romano, sociis et Latinis, pridie quam excessit e vita, 
                 ut ex tam alto dignitatis gradu ad superos videatur deos potius quam ad inferos pervenisse.</p>
                <p>
                <p class="justify">Quam ob rem vita quidem talis fuit vel fortuna vel gloria, ut nihil posset accedere, moriendi autem sensum celeritas abstulit; 
                quo de genere mortis difficile dictu est; quid homines suspicentur, videtis; 
                hoc vere tamen licet dicere, P. Scipioni ex multis diebus, quos in vita celeberrimos 
                laetissimosque viderit, illum diem clarissimum fuisse, cum senatu dimisso domum reductus ad
                 vesperum est a patribus conscriptis, populo Romano, sociis et Latinis, pridie quam excessit e vita, 
                 ut ex tam alto dignitatis gradu ad superos videatur deos potius quam ad inferos pervenisse.</p>
                <p>
                <a href="/actualites" class="btn btn-dark " role="button">Voir les actualités</a></p>
                </div>
                <div class="col-xs-12 col-lg-6"><img src="images/teacher2.jpg" alt="" class="img-responsive m-bottom">
                </div>
            </div>
        </section>
        <!-- ./END CONTAINER-FLUID-->

        <section class="container-fluid section">
            <h3 class="text-center title">Vos professeurs</h3>

            <div class="team text-center">
                <div class="row">
                    <div class="col-md-4">
                        <div class="team-player">
                            <img src="images/p1.jpg" alt="Thumbnail Image" class="img-raised img-circle">
                            <h4 class="title">Daniel Beaudouin<br>
                    <small class="text-muted">professeur de science</small>
                    </h4>
                            <p class="description">Isdem diebus Apollinaris Domitiani gener, paulo ante agens palatii Caesaris curam, ad Mesopotamiam missus a socero per militares numeros immodice scrutabatur, an quaedam altiora meditantis iam Galli secreta susceperint scripta</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="team-player">
                            <img src="images/p2.jpg" alt="Thumbnail Image" class="img-raised img-circle">
                            <h4 class="title">Alexandre Varden<br>
                  <small class="text-muted">professeur de maths etude</small>
                  </h4>
                            <p class="description">Isdem diebus Apollinaris Domitiani gener, paulo ante agens palatii Caesaris curam, ad Mesopotamiam missus a socero per militares numeros immodice scrutabatur, an quaedam altiora meditantis iam Galli secreta susceperint scripta</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="team-player">
                            <img src="images/p3.jpg" alt="Thumbnail Image" class="img-raised img-circle">
                            <h4 class="title">Odette Parenteau<br>
                  <small class="text-muted">professeur de maths</small>
                  </h4>
                            <p class="description">Isdem diebus Apollinaris Domitiani gener, paulo ante agens palatii Caesaris curam, ad Mesopotamiam missus a socero per militares numeros immodice scrutabatur, an quaedam altiora meditantis iam Galli secreta susceperint scripta</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('front.pages.contact.form')
    </div>
@endsection