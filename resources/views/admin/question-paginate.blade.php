@forelse($questions as $question)
    <tr>
        <td><input type="checkbox" value="{{ $question['id'] }}" name="questions_ids[]"></td>
        <td>{{ $question['questions'] }}</td>
    </tr>
@empty
    <tr>
        <td colspan="2" class="text-center">No questions available</td>
    </tr>
@endforelse

<tr>
    <td colspan="2" class="text-center">
        {!! $pagination !!}
    </td>
</tr>
