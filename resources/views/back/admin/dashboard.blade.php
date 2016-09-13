@extends('layouts.admin')
@section('title', $title)
@section('content')


<div class="row">
	@include('general.messages') 
</div>		

<!-- PANEL STATISTIQUE GLOBALES -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Statistiques globales
				<div class="row">
					<div class="col-lg-4 col-xs-12">
						<div class='text-center center-icon'>
							<i class="fa fa-5x fa-list-alt" aria-hidden="true"></i>
							<br>
							<span class="bolder-info">{{$articles->total['posts']}} articles</span>
						</div>
					</div>
					<div class="col-lg-4 col-xs-12">
						<div class='text-center center-icon'>
							<i class="fa fa-5x fa-question-circle" aria-hidden="true"></i>
							<br>
							<span class="bolder-info">{{$qcm->total['questions']}} QCM <br>publiés</span>
						</div>
					</div>
					<div class="col-lg-4 col-xs-12">
						<div class='text-center center-icon'>
							<i class="fa fa-5x  fa-users" aria-hidden="true"></i>
							<br>
							<span class="bolder-info">17 élèves <br>inscrits</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--/.PANEL STATISTIQUE GLOBALES-->

<!-- PANEL GESTION DES ARTICLES -->
<div class="row">
	<div class="col-lg-12">

		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" href="#postsPanel"  title="Ouvrir/Fermer le panel">Gestion des articles</a>
                    <a data-toggle="collapse" href="#postsPanel" title="Ouvrir/Fermer le panel">
                        <i class="fa fa-sort-desc fa-2x pull-right" aria-hidden="true"></i>
                    </a>
				</div>
				<div id="postsPanel" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class='row'>
							<h2>Derniers articles</h2>
							@forelse($articles->last as $post)
								<div class="col-md-4  col-sm-12 col-xs-12">
									<div class="view-post post-effect">
										@if(!is_null($post->picture))
										<img src="/uploads/{{$post->picture->uri}}" alt="{{(!is_null($post->picture->name)) ? $post->picture->name : $post->picture->uri}}" class="img-dash img-responsive img-center" >
										@else 	
										<img src="/images/default.jpg" alt="Image par défaut" class="img-dash img-responsive img-center" >
										@endif
										<div class="mask"></div>
										<div class="edit-post-dashboard">  
											<a href="admin/post/{{$post->id}}/edit" class="info" title="Aller à la page de l'édition de l'article">Full Image</a>  
										</div>  
									</div> 
								<h3><a href="admin/post/{{$post->id}}/edit" class="info" title="Aller à la page de l'édition de l'article">{{$post->title}}</a></h3>
								<p>
									{{$post->status}} {{!is_null($post->published_at) ? 'le '.$post->published_at->format('d/m/Y à H:i') : '' }}
									<br>
									Auteur : {{$post->user->first_name}}  {{$post->user->last_name}}
									<br>
									Commentaire(s) : {{($post->commentCounts > 0) ? $post->commentCounts : '0'}}
								</p>
							</div>
							@empty 
							Aucun article
							@endforelse
						</div>

						<hr>

						<div class='row'>
							<div class="col-md-7  col-xs-12">
								<!-- GRAPHIQUE POST PAR MOIS-->
								<div id="graph_etatposts" class="graph--etatPosts"></div>
								<script type="text/javascript">
									$(function () {
										$('#graph_etatposts').highcharts(
											{!! json_encode($graph_postsByMonth) !!}
										);
									});
								</script>
							</div>
							<div class="col-md-2 col-xs-12">
								<h4 class="margin-panel ">Total Articles</h4>
								<p>
									<span class="bolder-info">{{$articles->total['posts']}} 
										<i class="fa fa-list-alt" aria-hidden="true"></i>
									</span>
								</p>
								@if($articles->total['published']['count'] > 0)
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$articles->total['published']['percent']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$articles->total['published']['percent']}}%">
										ON : {{$articles->total['published']['count']}}
									</div>
								</div>
								@endif
								@if($articles->total['unpublished']['count'] > 0)
								<div class="progress">
									<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$articles->total['unpublished']['percent']}}" aria-valuemin="0" aria-valuemax="100"	 style="width: {{$articles->total['unpublished']['percent']}}%">
										OFF : {{$articles->total['unpublished']['count']}}
									</div>
								</div>
								@endif
								<hr>
								<h4 class="margin-panel">Total Commentaires</h4>
								<p>
									<span class="bolder-info">{{$articles->total['commentaires']}} 
									<i class="fa fa-comments-o" aria-hidden="true"></i>
									</span>
								</p>
							</div>
							<div class="col-md-3 col-xs-12">
								<h4>Articles les plus commentés</h4>
								<div class="list-group">
								@forelse($articles->topPublished as $post)
									<div class="col-md-12"><!-- notif-->
                                        <div class="input--lab--admin--panel-notif-topQuestion disabled">
                                            <p class="inline-topquestion">
                                            	<a href="{{url('article/'.$post->id)}}" title="Aller sur la page de l'article">
                                            		{{substr($post->title,0,25)}}... 
                                            	</a>
                                            </p>
                                            	<a href="{{url('article/'.$post->id)}}"  title="Aller sur la page de l'article">
                                                    <button class="btn--topQuestion--todo navbar-right">
                                                    	{{$post->aggregate}} <i class="fa fa-comment" aria-hidden="true"></i>
                                                    </button>
                                            	</a>
                                        </div>
                                    </div><!-- ./ End.notif-->
								@empty
									Il n'y a aucun article.
								@endforelse
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- ./PANEL GESTION DES ARTICLES -->

<hr>

<!-- PANEL GESTION DES QCM -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" href="#questionsPanel"  title="Ouvrir/Fermer le panel">Gestion des QCM</a>
                    <a data-toggle="collapse" href="#questionsPanel" title="Ouvrir/Fermer le panel">
                        <i class="fa fa-sort-desc fa-2x pull-right" aria-hidden="true"></i>
                    </a>
				</div>
				<div id="questionsPanel" class="panel-collapse collapse in">
					<div class="panel-body">
						<h2>Dernieres questions</h2>
						<div class='row'>
							@forelse($qcm->last as $question)
							<div class="col-md-4">
								<div class="panel panel-default well well-lg">
									<div class="panel-body">
										<h3>
											<i class="fa fa-question-circle" aria-hidden="true"></i> 
											<a href="admin/question/{{$question->id}}/edit" class="info" title="Aller à la page de l'édition de le la question">
												{{$question->title}}
											</a>
										</h3>
										<p>{{$question->status}}
										{{!is_null($question->created_at) ? 'le '.$question->created_at->format('d/m/Y') : '' }}
										<br>
										Niveau : {{$question->class_level->title}}</p>
									</div>
								</div>
							</div><!-- End col 4-->
							@empty 
							Aucune questions
							@endforelse
						</div>
						<hr>
						<div class='row'>
							<div class="col-md-4">
								<h4>TOP des questions les mieux réussies</h4>
								<div class="list-group">
								@forelse($bestQuestions as $question)
									<div class="col-md-12"><!-- notif-->
	                                    <div class="input--lab--admin--panel-notif-topQuestion disabled">
	                                        <p class="inline-topquestion">
	                                        	{{substr($question->title,0,35)}}...
	                                        </p>
                                            <button class="btn--topQuestion--todo navbar-right">
                                            	{{round($question->moyenne,2)}} / 1
                                            </button>

	                                    </div>
	                                </div><!-- ./ End.notif-->
								@empty
									Aucune question n'a encore été faite par des élèves.
								@endforelse
								</div>
							</div>

							<div class="col-md-3">
								<h4 class="margin-panel ">Total QCM</h4>
								<p>
									<span class="bolder-info">{{$qcm->total['questions']}} 
										<i class="fa fa-question-circle" aria-hidden="true"></i>
									</span>
								</p>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$qcm->total['published']['percent']}}" aria-valuemin="0" aria-valuemax="100"	 style="width:{{$qcm->total['published']['percent']}}%">
										ON : {{$qcm->total['published']['count']}}
									</div>
								</div>
								<div class="progress">
									<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$qcm->total['unpublished']['percent']}}" aria-valuemin="0" aria-valuemax="100"	 style="width: {{$qcm->total['unpublished']['percent']}}%">
										OFF : {{$qcm->total['unpublished']['count']}}
									</div>
								</div>
								<hr>
								<h4 class="margin-panel ">Question à choix simple</h4>
								<span class="bolder-info">
									{{ round($qcm->total['simple']['percent'],2) }} %
								</span>
								<h4 class="margin-panel ">Question à Choix multiples</h4>
								<span class="bolder-info">
									{{ round($qcm->total['multiple']['percent'],2) }} %
								</span>
							</div>
							<div class="col-md-5">
							<h4 class="margin-panel">Taux de réussite globale (%)</h4>
								<div id="graph_reussiteglob" class="graph--reussiteGlobale"></div>
								<script type="text/javascript">
									$(function () {
										$('#graph_reussiteglob').highcharts(
											{!! json_encode($graphReussiteGlob) !!}
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
</div><!-- ./PANEL GESTION DES QCM -->



<hr>

<!-- PANEL GESTION DES ELEVES -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" href="#elevesPanel"  title="Ouvrir/Fermer le panel">Gestion des élèves</a>
                    <a data-toggle="collapse" href="#elevesPanel" title="Ouvrir/Fermer le panel">
                        <i class="fa fa-sort-desc fa-2x pull-right" aria-hidden="true"></i>
                    </a>
				</div>
				<div id="elevesPanel" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class='row'>
							<div class="col-md-4">
								<h4>TOP 5 ELEVES - Meilleures scores (%)</h4>
								<div class="list-group">
								@forelse($bestEleves as $eleve)
									<div class="col-md-12"><!-- notif-->
	                                    <div class="input--lab--admin--panel-notif-topQuestion disabled">
	                                        <p class="inline-topquestion">
	                                        	{{$eleve->first_name}} {{$eleve->last_name}}
	                                        </p>
                                            <button class="btn--topQuestion--todo navbar-right">
                                            	{{round($eleve->moyenne * 100,2)}} %
                                            </button>

	                                    </div>
	                                </div><!-- ./ End.notif-->
								@empty
									Aucun élève n'a encore répondu à des QCM.
								@endforelse
								</div>
							</div>
							<div class="col-md-4 text-center">
								<h4 class="margin-panel ">Total Eleves</h4>
								<p>
									<span class="bolder-info">{{$total['eleve']}} 
										<i class="fa fa-users" aria-hidden="true"></i>
									</span>
								</p>
								<hr>
								<h4 class="margin-panel ">Eleves Actifs</h4>
								<span class="bolder-info">
									{{$total['eleve_actif'] }} élève(s)
								</span>
								<h4 class="margin-panel ">Eleves Inactifs</h4>
								<span class="bolder-info">
									{{ $total['eleve_inactif'] }} élève(s)
								</span>
							</div>
							<div class="col-md-4">
								<h4>TOP 5 Eleves - Les plus mauvais scores (%)</h4>
								<div class="list-group">
								@forelse($badEleves as $eleve)
									<div class="col-md-12"><!-- notif-->
	                                    <div class="input--lab--admin--panel-notif-topQuestion disabled">
	                                        <p class="inline-topquestion">
	                                        	{{$eleve->first_name}} {{$eleve->last_name}}
	                                        </p>
                                            <button class="btn--topQuestion--todo navbar-right">
                                            	{{round($eleve->moyenne * 100,2)}} %
                                            </button>

	                                    </div>
	                                </div><!-- ./ End.notif-->
								@empty
									Aucun élève n'a encore répondu à des QCM.
								@endforelse
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- ./PANEL GESTION DES ELEVES -->

@endsection