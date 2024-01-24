@extends('layout')

@section('content')
    <h1 class="text-body-emphasis">
        Get started with <em class="fw-bold text-danger">Shorties</em>
    </h1>

    <p class="fs-5 col-md-8 mb-5">Quickly create sexy shorty URLs from those ghastly long ones. Upload a list of URLs and let
        Shorties do its thing!
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="my-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-5">
        <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload</button>
        <a href="{{ route('app.analytics.index') }}" class="btn btn-secondary btn-lg px-4">Stats</a>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('app.upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Shorty's CSV Uploader</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">CSV of URLs</label>
                            <input class="form-control" type="file" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Nevermind</button>
                        <button type="submit" class="btn btn-sm btn-primary">Make 'em Short</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
