<div class="container-fluid">

	<!-- A LIRE AUSSI -->
	<div class="row">
		<h2>A lire aussi</h2> 
		<hr>
			<div class="col-xs-10 col-sm-6 col-md-12 col-lg-12">
				@forelse($topPosts as $key => $post)
				<div class="item-top">
					<span class="top-color{{$key+1}} top-count">{{$key+1}}</span>
					<div class="top-content">
						<h4> <a href="{{url('article',[$post->id])}}">{{$post->title}}</a></h4>
					</div>
				</div>
				@empty
					Pas d'articles récents
				@endforelse
			</div>
		
	</div><!-- END A LIRE AUSSI -->

	<!-- FLUX TWITTER -->
	<div class='row'>
		<h2>Derniers Tweets</h2>
		<hr>
		<div class="live-bull large-bull bull-twitter">
			<div class="live-bull-content">
				@forelse($tweets as $key => $tweet)
				<div class="live-bull-data">
					<span class="live-bull-info">
						<strong>
							<a href="https://twitter.com/statuses/{{$tweet->id_str}}" target="_blank" title="Aller sur Twitter">
								{!! (!is_null($tweet->text)) ? $tweet->text : 'Vide' !!}
							</a>
						</strong>.
					@Elycee.lab
					- {{(!is_null($tweet->created_at)) ? date( 'd/m/Y à H:i', strtotime($tweet->created_at)) : 'Date inconnue'}}
					</span>

					@if($key+1 == count($tweets))
					<a href="https://twitter.com/elyceelab" class="live-bull-button" target="_blank">
						<svg class="icon fill-black" role="img" width="20" height="20" viewBox="0 0 20 20">
							<title>Twitter</title>
							<path d="M19.5 4.1c-.7.3-1.5.5-2.2.6.8-.5 1.4-1.2 1.7-2.2-.8.4-1.6.8-2.5.9-.7-.8-1.7-1.2-2.8-1.2-2.2 0-3.9 1.7-3.9 3.9 0 .3 0 .6.1.9-3.3-.1-6.2-1.7-8.1-4-.3.6-.5 1.2-.5 2 0 1.3.7 2.5 1.7 3.2-.6 0-1.2-.2-1.7-.5 0 1.9 1.3 3.5 3.1 3.8-.3.1-.7.1-1 .1-.3 0-.5 0-.7-.1.5 1.5 1.9 2.7 3.6 2.7-1.3 1-3 1.7-4.8 1.7-.3 0-.6 0-.9-.1 1.7 1.1 3.8 1.8 6 1.8 7.2 0 11.1-5.9 11.1-11.1v-.5c.6-.4 1.3-1.1 1.8-1.9"></path>
						</svg>
						Suivre
					</a>
					@endif
				</div>
				@empty 
					Aucun tweet
				@endforelse
			</div>
		</div>
	</div><!-- END FLUX TWITTER -->

</div>

