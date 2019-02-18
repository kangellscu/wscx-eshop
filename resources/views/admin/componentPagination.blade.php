@inject('request', 'Illuminate\Http\Request')
@php
    $navNum = 5;
    if ($page == 1) {
        $navStart = 0;
    } elseif ($page % $navNum == 0) {
        $navStart = $page - $navNum;
    } else {
        $navStart = ((int) floor($page/$navNum)) * $navNum;
    }
    $nextFirstStep = $navStart + $navNum + 1;
@endphp
<nav aria-label="...">
    <ul class="pagination">

@if ($navStart == 0)
        <li class="disabled">
            <a href="javascript:void();" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
@else
        <li>
            <a href="{{ $request->fullUrlWithQuery(['page' => $navStart]) }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
@endif

@foreach (range(1, $navNum) as $step)
    @php
        $stepPage = $navStart + $step;
    @endphp
    @if ($stepPage > $totalPages)
        @break
    @endif
    @if ($stepPage == $page)
        <li class="active">
            <a href="javascript:void();">{{ $stepPage }}</a>
        </li>
    @else
        <li>
            <a href="{{ $request->fullUrlWithQuery(['page' => $stepPage]) }}">{{ $stepPage }}</a>
        </li>
    @endif
@endforeach

@if ($nextFirstStep > $totalPages)
        <li class="disabled">
            <a href="javascript:void();" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
@else
        <li>
            <a href="{{ $request->fullUrlWithQuery(['page' => $nextFirstStep]) }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
@endif

    </ul>
</nav>
