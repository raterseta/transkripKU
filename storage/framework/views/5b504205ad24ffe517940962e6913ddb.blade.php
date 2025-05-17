<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['entry'])
<x-filament-infolists::entry-wrapper :entry="$entry" >

{{ $slot ?? "" }}
</x-filament-infolists::entry-wrapper>