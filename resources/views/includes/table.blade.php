@foreach($list_date as $key => $date)
    @php($hour = $key + 6)
    <tr data-hour="{{ $hour }}">
        <td>{{ number_format($hour, 2, ':', '') }}</td>
        @foreach($date as $key_w => $w)
            @php($date_carbon = \Carbon\Carbon::parse($key_w))
            <td>
                @if( isset($w->date) )
                    <a href="#" data-hour="{{ $hour }}" data-week="{{ $w }}" id="{{ $hour .'-'. $date_carbon->dayOfWeek }}"
                       data-id="{{$w->id}}" data-toggle="modal" data-target="#roomModal" class="item-reunion">
                        <span>Reserved for {{ $w->name ?? '' }}</span>
                    </a>
                    <i class="far fa-times-circle room-remove" data-toggle="modal" data-target="#rooRemoveModal"></i>
                @else
                    <a href="#" data-hour="{{ $hour }}" data-week="{{ $key_w }}" id="{{ $hour .'-'. $date_carbon->dayOfWeek }}"
                       data-id="" data-toggle="modal" data-target="#roomModal" class="item-reunion">
                        <span>Available</span>
                    </a>
                    <i class="far fa-times-circle" data-toggle="modal" data-target="#rooRemoveModal" style="display: none;"></i>
                @endif

            </td>
        @endforeach
    </tr>
@endforeach

