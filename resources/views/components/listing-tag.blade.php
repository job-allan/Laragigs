@props(['tagsCsv'])


@php
$tags = explode(' ', $tagsCsv);

@endphp

<ul class="flex">
    @foreach($tags as $tag)
    <li class="flex items-center justify-center bg-black text-white rounded-xl px-3 py-1 mr-2 text-xs">
        <a href="/?tags={{$tag}}">{{$tag}}</a>
    </li>
    @endforeach
</ul>