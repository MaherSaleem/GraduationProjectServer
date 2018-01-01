@extends('general')




@section('content')
    <h1>الرجاء اختيار الجواب الاقرب</h1>
    <h2>{{$questionText}}</h2>
    @php
        $answers['-2'] = 'لا شيء مما ذكر';
    @endphp
    <form method="post" action="{{url("/submissions") . '/' . $submissionId}}">
        {!! method_field('put') !!}

        <div class="row" style="direction:RTL">

            <div class="col-md-12 pull-right">

                @foreach($answers as $key => $answer)
                    <div class="form-group">
                        <input type="checkbox" class="" name="rank[]" value="{{$key+1}}">
                        <span style="color: white; font-size: 20px;">
                        {!! $answer!!}
                        </span>
                    </div>
                @endforeach
                    <div class="form-group">
                        <span style="color: white; font-size: 20px;">
                        </span>
                    </div>
            </div>
        </div>
        </div>
        <br>
        <button type="submit" class="button button-block"/>
        Submit</button>
    </form>
@endsection
