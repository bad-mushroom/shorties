@extends('layout')

@section('content')
    <h1 class="text-body-emphasis">
        <a href="{{ route('app.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-2 text-info"></i>
        </a>
        <span class="fw-bold text-danger">Shorties</span> Analytics
    </h1>
    <p class="fs-5 col-md-8 mb-5">Your shorter URLs are burning hot - check out those clicks!</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Shorty</th>
                <th scope="col">Longy</th>
                <th scope="col">Clicks</th>
                <th scope="col">Since</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($urls as $url)
                <tr>
                    <td><a href="{{ $url->long_url }}" target="_blank">http://localhost/{{ $url->short_code }}</a></td>
                    <td>{{ $url->long_url }}</td>
                    <td>{{ $url->visits }}</td>
                    <td>{{ $url->created_at->format('m/d/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
