<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<table>
    <tr>
        <td>{{ $experiment->title }}</td>

    </tr>
    <?php $element = $experiment->element()->first(); ?>
    <tr>
        @while($element != null)
            @if($element->type == 2) Survay
                <td>{{ $element->title }}</td>
            @elseif($element->type == 3) MODEL

            @elseif($element->type == 4) FEEDBACK

            @elseif($element->type == 5)

            @endif

            <?php $element = $element->next(); ?>
        @endwhile
    </tr>
</table>