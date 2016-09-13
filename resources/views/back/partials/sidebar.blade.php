		
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar hidden-xs">
	<li role="presentation" class="divider"></li>
	@if ( auth()->check())
		@if( auth()->user()->isAdmin())
		    @include('back.admin.menu')
		@elseif( auth()->user()->isStudent())
			@include('back.eleve.menu')
		@endif
	@endif
</div><!--/.sidebar-->
	