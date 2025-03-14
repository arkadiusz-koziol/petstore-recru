@include('layouts.default')
    <!DOCTYPE html>
<html>
<head>
    <title>{{ __('Pet Details') }}</title>
</head>
<body>
<div class="container">
    <h1>{{ __('Pet Details') }}</h1>

    {{-- Display success or error messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Search Pet Form --}}
    <h2>{{ __('Search for a Pet') }}</h2>
    <form method="GET" action="{{ route('pet.show') }}">
        <div class="form-group">
            <label for="petId">{{ __('Enter Pet ID') }}</label>
            <input type="number" id="petId" name="petId" class="form-control"
                   value="{{ request('petId') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Search Pet') }}</button>
    </form>
    {{-- Display Pet Details --}}
    @if(isset($pet))
        <hr>
        <h2>{{ __('Pet Information') }}</h2>
        <ul>
            <li><strong>ID:</strong> {{ $pet['id'] }}</li>
            <li><strong>Name:</strong> {{ $pet['name'] }}</li>
            <li><strong>Status:</strong> {{ ucfirst($pet['status']) }}</li>
            <li><strong>Category:</strong> {{ $pet['category']['name'] ?? 'N/A' }}</li>
            {{-- Display Tags --}}
            <li>
                <strong>Tags:</strong>
                @if(!empty($pet['tags']))
                    <ul>
                        @foreach($pet['tags'] as $tag)
                            <li>{{ $tag['name'] }}</li>
                        @endforeach
                    </ul>
                @else
                    {{ __('No tags available') }}
                @endif
            </li>

            {{-- Display Photo URLs --}}
            <li>
                <strong>Photo URLs:</strong>
                @if(!empty($pet['photoUrls']))
                    <ul>
                        @foreach($pet['photoUrls'] as $url)
                            <li>
                                <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{ __('No photo URLs available') }}
                @endif
            </li>
        </ul>

        {{-- Edit Form --}}
        <h2>{{ __('Edit Pet') }}</h2>
        <form method="POST" action="{{ route('pet.update', $pet['id']) }}">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <div class="form-group">
                <label for="category_id">{{ __('Category ID') }}</label>
                <input type="number" id="category_id" name="category[id]" class="form-control"
                       value="{{ old('category.id', $pet['category']['id'] ?? '') }}">
            </div>

            <div class="form-group">
                <label for="category_name">{{ __('Category Name') }}</label>
                <input type="text" id="category_name" name="category[name]" class="form-control"
                       value="{{ old('category.name', $pet['category']['name'] ?? '') }}">
            </div>

            {{-- Name --}}
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="{{ old('name', $pet['name'] ?? '') }}">
            </div>

            {{-- Photo URLs --}}
            <div class="form-group">
                <label for="photoUrls">{{ __('Photo URLs (one per line)') }}</label>
                <textarea id="photoUrls" name="photoUrls" class="form-control">{{ old('photoUrls', implode("\n", $pet['photoUrls'] ?? [])) }}</textarea>
            </div>

            {{-- Tags --}}
            <div class="form-group">
                <label for="tags">{{ __('Tags (one per line)') }}</label>
                <textarea id="tags" name="tags" class="form-control">
                    {{ old('tags', implode("\n", array_column($pet['tags'] ?? [], 'name'))) }}
                </textarea>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="status">{{ __('Status') }}</label>
                <select id="status" name="status" class="form-control">
                    <option value="available" {{ old('status', $pet['status']) === 'available' ? 'selected' : '' }}>
                        {{ __('Available') }}
                    </option>
                    <option value="pending" {{ old('status', $pet['status']) === 'pending' ? 'selected' : '' }}>
                        {{ __('Pending') }}
                    </option>
                    <option value="sold" {{ old('status', $pet['status']) === 'sold' ? 'selected' : '' }}>
                        {{ __('Sold') }}
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update Pet') }}</button>
        </form>
    @endif
</div>
</body>
</html>
