@extends('layouts.admin')
@section('title', $title)
@section('content')

<div class="container-fluid">
    <div class="col-xs-12 main">
        <div class="row">
             <h2>{{$title}} <small>{{$total['done']}} question(s) effectuée(s), reste : {{$total['notdone']}} question(s) </small> </h2>
           
            <div class="container-fluid panel panel-back">
                <div class="container-fluid">
                    
                    <form id='sort-form' method="get" action="/eleve/question">
                        <input type="hidden" name="sortBy" value="{{$sortBy}}">
                        <input type="hidden" name="sortDir" value="{{$sortDir}}">
                        <button type="submit" class="nodisplay">Valider</button>
                    </form>

                    <div class="row">
                        @include('general.messages')
                    </div>

                    {!! $questions->appends([])->render() !!}
                    <div class='row top-row'>
                        <div class="table-responsive">
                            <table class="table table-hover custome--lab--table table-responsive">
                                <thead>
                                    <tr>
                                        <th class='text-center'>Fait <i class="fa fa-sort" id='status_question' aria-hidden="true"></i></th>
                                        <th>Question <i class="fa fa-sort" id='title' aria-hidden="true"></i></th>
                                        <th class='text-center'>Note <i class="fa fa-sort" id='note' aria-hidden="true"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($questions as $question)
                                    <tr>
                                        @if($question->status_question == 'done')
                                        <td class='done'><i class="fa fa-check" aria-hidden="true"></i></td>
                                        <td class='qcmDone'>{{$question->title}}</td>
                                        @else 
                                        <td class='notdone'><i class="fa fa-times" aria-hidden="true"></i></td>
                                        <td><a href="{{url('eleve/question/do/'.$question->id)}}"><strong>{{$question->title}}</strong></a></td>
                                        @endif
                                        <td class='text-center'>{{$question->note}} / 1</td>
                                    </tr>
                                    @empty
                                    <p>Il n'y a aucune question disponible.</p>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6 pull-left">
                            {!! $questions->appends([])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection