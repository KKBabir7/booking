@extends('layouts.admin')

@section('header', 'Add New Conference Hall')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.conference.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2">
        <i class="bi bi-arrow-left"></i> Back to Conference Halls
    </a>
</div>

<div class="card-premium p-8 max-w-4xl">
    <div class="mb-8">
        <h3 class="text-xl font-bold text-slate-800">New Conference Hall Profile</h3>
        <p class="text-sm text-slate-500">Fill in the details to list a new corporate or training venue.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 px-4 py-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-600 text-sm font-semibold">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.conference.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.page.conference.form')
    </form>
</div>
@endsection
