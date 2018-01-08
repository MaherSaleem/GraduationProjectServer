@extends('general')




@section('content')
    <h1>الرجاء اختيار الجواب الاقرب</h1>
    <h2>@{{results.query}}</h2>
    @php
        $answers['-2'] = 'لا شيء مما ذكر';
    @endphp
{{--    <form method="post" action="{{url("/submissions") . '/' . results.submissionId}}">--}}
        {!! method_field('put') !!}

        <div class="row" style="direction:RTL">

            <div class="col-md-12 pull-right">
                <li v-for="result in results.answers">

                    <div class="form-group">
                        {{--<input type="checkbox" class="" name="rank[]" value="{{$key+1}}">--}}
                        <span style="color: white; font-size: 20px;">
                        @{!!  result !!}
                        </span>
                    </div>

                    <div class="form-group">
                        <span style="color: white; font-size: 20px;">
                        </span>
                    </div>
                </li>
            </div>
        </div>
        <br>
        <button type="submit" class="button button-block"/>
        Submit</button>
    {{--</form>--}}
@endsection
