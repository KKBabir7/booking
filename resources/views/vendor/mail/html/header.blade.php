@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; color: #f76156; font-size: 24px; font-weight: bold; text-decoration: none;">
    @if (trim($slot) === 'Laravel')
        Nice Guest House
    @else
        {!! $slot !!}
    @endif
</a>
</td>
</tr>
