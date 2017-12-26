@extends('general')

@section('title', 'اختيار الجواب')


@section('content')
    <h1>الرجاء اختيار الجواب الاقرب</h1>
    @php
        $answers['-2'] = 'لا شيء مما ذكر';
    @endphp
    <form method="post" action="{{url("/submissions") . '/' . $submissionId}}">
        {!! method_field('put') !!}
        {{$questionText}}

        @foreach($answers as $key => $answer)

            <br>
            <div class="pull-right">
                <span style="background-color: white">
                    {{$answer}}
                </span>
                <input type="checkbox" name="rank" value="{{$key+1}}">
            </div>
        @endforeach
        <br>
        <button type="submit" class="button button-block"/>
        Submit</button>
    </form>
@endsection
