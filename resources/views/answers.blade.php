<form method="post" action="{{url("/submit")}}">
    {{$questionText}}
        <input type="hidden" name="submissionId" value="{{$submissionId}}">
    @foreach($answers as $key => $answer)
        <br> <input type="checkbox" name="rank" value="{{$key+1}}"> {{$answer}}
    @endforeach
        <br> <input type="checkbox" name="rank" value="{{-1}}"> {{"لا شيء مما ذكر"}}
        <br>
        <input type="submit">
</form>