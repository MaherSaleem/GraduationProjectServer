@extends('general')

@section('title', 'MRR')


@section('content')
    <div class="row">
        <div class="col-md-12 pull-left">
            <h2>Total number of submissions: {{$total['numberOfSubmissions']}}</h2>
            <h2>MRR Result is {{printf("%0.1f",$total['mrr'])}}%</h2>
            <h2>Answers Found percent: {{printf("%0.1f",$total['answer_exist_percent'])}}%</h2>
            <h2>Avg correct answers per question {{printf("%0.1f",$total['avg_answers_per_question'])}}</h2>
        </div>
    </div>
    <hr>
    @foreach($measuresByType as $key=>$measureByType)
        <div class="row">
            <div class="col-md-12 pull-left">
                <h1><u>{{$key}} Type</u></h1>
                <h2>Total number of submissions: {{$measureByType['numberOfSubmissions']}}</h2>
                <h2>MRR Result is {{printf("%0.1f",$measureByType['mrr'])}}%</h2>
                <h2>Answers Found percent: {{printf("%0.1f",$measureByType['answer_exist_percent'])}}%</h2>
                <h2>Avg correct answers per question {{printf("%0.1f",$measureByType['avg_answers_per_question'])}}</h2>
            </div>
        </div>
        <hr>
    @endforeach
@endsection

