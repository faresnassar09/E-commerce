@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="#" class="logo" alt="Grocery store">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
