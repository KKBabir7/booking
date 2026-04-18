@extends('emails.layout')

@section('content')
    <h1>{{ $subject }}</h1>
    
    <p style="white-space: pre-wrap;">{{ $body }}</p>

    @if(isset($actionUrl))
        <div class="button-wrapper">
            <a href="{{ $actionUrl }}" class="button">{{ $actionText ?? 'Visit Dashboard' }}</a>
        </div>
    @endif

    @if(isset($details) && count($details) > 0)
        <div class="details-box">
            <h3>Booking Information</h3>
            @foreach($details as $label => $value)
                <div class="detail-row">
                    <span class="detail-label">{{ $label }}:</span>
                    <span class="detail-value">{{ $value }}</span>
                </div>
            @endforeach
        </div>
    @endif
@endsection
