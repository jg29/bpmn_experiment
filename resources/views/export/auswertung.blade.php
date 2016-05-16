<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<table border="1">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        @foreach($rows as $id => $row)
            <?php $element = \App\Element::getElement($id) ?>
            @if($element->type == 2)
                <!--survay-->
                <th colspan="{{count($row)}}">&nbsp;</th>
            @elseif($element->type == 3)
                <!--model-->
                <th>&nbsp;</th>
            @elseif($element->type == 4)
                <!--feedback-->
                <th>&nbsp;</th>
            @elseif($element->type == 5)
                <!--xor-->
                <th style="background-color: #d9edf7" colspan="{{\App\Element::countArray($row)}}">{{ $element->title }}</th>
            @endif
        @endforeach
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        @foreach($rows as $id => $row)
            <?php $element = \App\Element::getElement($id) ?>
            @if($element->type == 2)
                <!--survay-->
                <th style="background-color: #dff0d8;" colspan="{{count($row)}}">{{ $element->title }}</th>

            @elseif($element->type == 3)
                <!--model-->
                <th>&nbsp;</th>
            @elseif($element->type == 4)
                <!--feedback-->
                <th>&nbsp;</th>
            @elseif($element->type == 5)
                <!--xor-->
                @foreach($row as $subid => $subrow)
                    <?php $ele = \App\Element::getElement($subid) ?>
                    @if($ele->type == 2)
                        <th style="background-color: #C1D4DE;" colspan="{{count($subrow)}}">{{ $ele->title }}</th>
                    @else
                        <th style="background-color: #d9edf7" colspan="{{count($subrow)}}">&nbsp;</th>
                    @endif
                @endforeach
            @endif



        @endforeach

    </tr>
    <tr>
        <th>UserId</th>
        <th>Pfad</th>
        @foreach($rows as $id => $row)
            <?php $element = \App\Element::getElement($id) ?>
            @if($element->type == 2)
                <!--survay-->
                @foreach($row as $subid => $subrow)
                    <?php $field = \App\Field::getField($subrow['field']) ?>
                    <th style="background-color: #dff0d8">{{ $field->name }}</th>
                @endforeach
            @elseif($element->type == 3)
                <!--model-->
                <th>{{ $element->title }}</th>
            @elseif($element->type == 4)
                <!--feedback-->
                <th>{{ $element->title }}</th>
            @elseif($element->type == 5)
                <!--xor-->
                @foreach($row as $subid => $subrow)
                    <?php $ele = \App\Element::getElement($subid) ?>
                    @if($ele->type == 2)
                        @foreach($subrow as $subsubrow)
                            <?php $fie = \App\Field::getField($subsubrow['field']) ?>
                            <th style="background-color: #C1D4DE;">{{$fie->name}}</th>
                        @endforeach
                    @else
                        <th style="background-color: #d9edf7">{{ $ele->title }}</th>
                    @endif
                @endforeach
            @endif
        @endforeach
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ \App\User::generateUserId($user->student) }}</td>
        <td>{{ \App\Answer::getPfad($user->student)+1 }}</td>
        @foreach($rows as $id => $row)
            <?php $element = \App\Element::getElement($id) ?>
            @if($element->type == 2)
                    <!--survay-->
                @foreach($row as $subid => $subrow)
                    <?php $field = \App\Field::getField($subrow['field']) ?>
                    @if($field->type == 3 OR $field->type == 4 OR $field->type == 5)
                        <td style="background-color: #dff0d8">{{\App\Field::getFieldAnswers($subrow['field'], \App\Answer::getValue($id, $subrow['field'],$user->student)) }} </td>
                    @else
                        <td style="background-color: #dff0d8">{{ \App\Answer::getValue($id, $subrow['field'],$user->student) }}  </td>
                    @endif
                @endforeach
            @elseif($element->type == 3)
                <!--model-->
                @if(file_exists("svg/".$experiment->id."/".$element->id."_".$user->student.".png"))
                    <td><a href="http://localhost/svg/{{ $experiment->id }}/{{  $element->id }}_{{$user->student}}.png">http://localhost/svg/{{ $experiment->id }}/{{  $element->id }}_{{$user->student}}.png</a></td>
                @else
                    <td>&nbsp;</td>
                @endif
            @elseif($element->type == 4)
                <!--feedback-->
                <td>{{ \App\Answer::getValue($id, 'feedback',$user->student) }}</td>
            @elseif($element->type == 5)
                <!--xor-->
            @foreach($row as $subid => $subrow)
                <?php $ele = \App\Element::getElement($subid) ?>
                @if($ele->type == 3)
                    @if(file_exists("svg/".$experiment->id."/".$ele->id."_".$user->student.".png"))
                        <td style="background-color: #d9edf7"><a href="http://localhost/svg/{{ $experiment->id }}/{{  $ele->id }}_{{$user->student}}.png">http://localhost/svg/{{ $experiment->id }}/{{  $ele->id }}_{{$user->student}}.png</a></td>
                    @else
                        <td style="background-color: #d9edf7">&nbsp;</td>
                    @endif
                @elseif($ele->type == 2)
                    @foreach($subrow as $subsubrow)
                        <?php $fie = \App\Field::getField($subsubrow['field']) ?>
                        @if($fie->type == 3 OR $fie->type == 4 OR $fie->type == 5)
                            <td  style="background-color: #C1D4DE;">{{\App\Field::getFieldAnswers($subsubrow['field'], \App\Answer::getValue($subid, $subsubrow['field'],$user->student)) }} </td>
                        @else
                            <td style="background-color: #C1D4DE">{{ \App\Answer::getValue($subid, $subsubrow['field'],$user->student) }}  </td>
                        @endif
                    @endforeach
                @else
                    <td style="background-color: #d9edf7">{{ $ele->title }}</td>
                @endif
            @endforeach
            @endif
        @endforeach

    </tr>
    @endforeach

</table>