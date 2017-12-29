@extends('general')

@section('title', 'MRR')


@section('content')
    <div class="row">
        <div class="col-md-12 pull-left">
            <h2>Total number of submissions: {{$numberOfSubmissions}}</h2>
            <h2>MRR Result is {{printf("%0.1f",$MRR)}}%</h2>
            <h2>Answers Found percent: {{printf("%0.1f",$answerExistPercent)}}%</h2>
            <h2>Avg correct answers per question {{printf("%0.1f",$avgAnswersPerQuestion)}}</h2>
        </div>
    </div>
@endsection

