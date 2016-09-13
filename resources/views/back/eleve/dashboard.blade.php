@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="">
    <div class="col-md-12 data " >
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" href="#reussite"  title="Ouvrir/Fermer le panel">Réussite globale des QCM</a>
                    <a data-toggle="collapse" href="#reussite" title="Ouvrir/Fermer le panel">
                        <i class="fa fa-sort-desc fa-2x pull-right" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="panel-collapse collapse in" id='reussite'>
                    <div class="panel-body">
                        <div class='row'>
                            <div class='col-md-4'>
                                <div id='graph_totalScore' class="graph--totalScore">
                                    <div id="container-speed" class="graph--totalScore--div"></div>
                                    <div id="container-rpm" class="graph--totalScore--div"></div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#graph_totalScore').highcharts(
                                        	Highcharts.merge({!! json_encode($graphScore['chart']) !!}, {!! json_encode($graphScore['param']) !!})
                                        );
                                    });
                                </script>
                                <h4>{{$total['score']}} / {{$total['questions_done']}} point(s)</h4>
                                <p>
                                    <i>Score établi un total de <strong>{{$total['questions_done']}} question(s) </strong>effectuée(s)</i>.
                                </p>
                            </div>
                            <div class='col-md-8'>
                                <div id="graph_detailScore" class="graph--detailScore" ></div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#graph_detailScore').highcharts(
                                            {!! json_encode($graphDetailScores) !!}
                                        );
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-group top-row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" href="#etatQcm"  title="Ouvrir/Fermer le panel">Etat des QCM</a>
                    <a data-toggle="collapse" href="#etatQcm" title="Ouvrir/Fermer le panel">
                        <i class="fa fa-sort-desc fa-2x pull-right" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="panel-collapse collapse in" id='etatQcm'>
                    <div class="panel-body">
                        <div class='row'>
                            <div class='col-md-8'>
                                <h3>Les 5 dernières questions</h3>
                                <div class="list-group">
                                    @forelse($todo as $item)
                                    <div class="col-md-12"><!-- notif-->
                                        <div class="input--lab--admin--panel-notif-topQuestion disabled">
                                            <p class="inline-topquestion">{{$item->question->title}}</p>
                                            	<a href="{{url('eleve/question/do/'.$item->question->id)}}">
                                                    <button class="btn--topQuestion--todo navbar-right">A faire</button>
                                            	</a>
                                        </div>
                                    </div><!-- ./ End.notif-->
                                    @empty
                                    <div class="col-md-12"><!-- notif-->
                                        <div class="input--lab--admin--panel-notif-topQuestion disabled">
                                            <p class="inline-topquestion">Il n'y a aucune question à faire en attente.</p>
                                        </div>
                                    </div><!-- ./ End.notif-->
                                    @endforelse
                                </div>
                                	<a href="{{url('eleve/question')}}">
                                	<button type="button" class='btn btn-dark top-row pull-right '>
                                		Voir toutes les questions
                                	</button>
                                </a>
                            </div>
                            <div class='col-md-4'>
                                <div id="graph_etatqcm" class="graph--etatQcm"></div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#graph_etatqcm').highcharts(
                                            {!! json_encode($graphEtatQcm) !!}
                                        );
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection