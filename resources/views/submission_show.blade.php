@extends('general')

@section('title', 'إدخال السؤال')


@section('content')
    <h1>الرجاء ادخل السؤال</h1>

    <form action="{{url("/submissions/store")}}" method="post">

        <div class="field-wrap">
            <label >
                السؤال<span class="req">*</span>
            </label>
            <input type="text" name="query" required autocomplete="off" />
        </div>


        <button type="submit" class="button button-block"/>Submit</button>

    </form>
@endsection
