@extends('layout')

@section('content')
    <div class="container">
        @formsection(isset($project) ? "Edit $project->name" : 'New project')
            @isset($project)
                <form method="POST" action="{{ route('projects.update', $project) }}">
                @method('PATCH')
            @else
                <form method="POST" action="{{ route('projects.store') }}">
            @endisset

                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Project name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name ?? '') }}" required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <span class="col-md-4 col-form-label text-md-right">Visibility</span>

                    <div class="col-md-6 pt-2">
                        @php
                            $public = \Arbify\Models\Project::VISIBILITY_PUBLIC;
                            $private = \Arbify\Models\Project::VISIBILITY_PRIVATE;
                            $oldVisibility = old('visibility', $project->visibility ?? $public);
                        @endphp
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="visibility.public" name="visibility" value="{{ $public }}" class="custom-control-input"
                                   @if($oldVisibility === $public) checked @endif required>
                            <label class="custom-control-label" for="visibility.public">
                                <b class="d-block">Public.</b>
                                <span class="d-block mt-1 mb-2">Every registered user with the role <i>User</i> will be able to see this project.</span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="visibility.private" name="visibility" value="{{ $private }}" class="custom-control-input"
                                   @if($oldVisibility === $private) checked @endif required>
                            <label class="custom-control-label" for="visibility.private">
                                <b class="d-block">Private.</b>
                                <span class="d-block mt-1 mb-2">Only registered users with any role in this project will be able to see it.</span>
                            </label>
                        </div>

                        @error('visibility')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @isset($project)
                                Update project
                            @else
                                Create project
                            @endisset
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection
