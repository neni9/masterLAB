<ul class="nav menu">
	<li class="{{menuActive(['admin'])}}">
		<a href="/admin">
			<i class="fa fa-bar-chart" aria-hidden="true"></i>
			Dashboard
		</a>
	</li>
	<li class="{{menuActive(['admin/post'])}}">
		<a href="/admin/post">
			<i class="fa fa-tasks" aria-hidden="true"></i>
			Articles
		</a>
	</li>
	<li class="{{menuActive(['comment'])}}">
		<a href="/comment">
			<i class="fa fa-comments" aria-hidden="true"></i>
			Commentaires
		</a>
	</li>
	<li class="{{menuActive(['admin/question'])}}">
		<a href="/admin/question">
			<i class="fa fa-question-circle" aria-hidden="true"></i>
			Questions
		</a>
	</li>
	<li class="parent {{menuActive(['admin/eleve'])}}">
		<a href="/admin/eleve">
			<i class="fa fa-graduation-cap" aria-hidden="true"></i>
			Eleves 
		</a>
	</li>
	<li role="presentation" class="divider"></li>

	<li>
		<a href="/logout">
			<i class="fa fa-sign-out" aria-hidden="true"></i>
			Déconnection
		</a>
	</li>
</ul>