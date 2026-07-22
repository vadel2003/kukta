@extends('layouts.app')

@section('title', 'Új recept')

@section('content')
    <h1>Új recept feltöltése</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('recipes.store') }}">
        @csrf

        <div>
            <label for="title">Recept címe</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Leírás</label>
            <textarea name="description" id="description" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Elkészítés lépései</label>
            @for ($i = 1; $i <= 5; $i++)
                <div>
                    <label for="step{{ $i }}">{{ $i }}. lépés</label>
                    <input type="text" name="step{{ $i }}" id="step{{ $i }}" value="{{ old('step' . $i) }}" placeholder="Add meg a {{ $i }}. lépést">
                    @error('step' . $i)
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
            @endfor
        </div>

        <div>
            <label>Alapanyagok</label>
            <div id="ingredients">
                @for ($i = 0; $i < 5; $i++)
                    <div>
                        <select name="ingredients[{{ $i }}][id]">
                            <option value="">-- Válassz alapanyagot --</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" {{ old('ingredients.' . $i . '.id') == $ingredient->id ? 'selected' : '' }}>
                                    {{ $ingredient->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="ingredients[{{ $i }}][quantity]" step="0.1" min="0" placeholder="Mennyiség" value="{{ old('ingredients.' . $i . '.quantity') }}">

                        <select name="ingredients[{{ $i }}][unit]">
                            <option value="">-- Mértékegység --</option>
                            <option value="g" {{ old('ingredients.' . $i . '.unit') == 'g' ? 'selected' : '' }}>g</option>
                            <option value="kg" {{ old('ingredients.' . $i . '.unit') == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="ml" {{ old('ingredients.' . $i . '.unit') == 'ml' ? 'selected' : '' }}>ml</option>
                            <option value="l" {{ old('ingredients.' . $i . '.unit') == 'l' ? 'selected' : '' }}>l</option>
                            <option value="db" {{ old('ingredients.' . $i . '.unit') == 'db' ? 'selected' : '' }}>db</option>
                            <option value="csésze" {{ old('ingredients.' . $i . '.unit') == 'csésze' ? 'selected' : '' }}>csésze</option>
                            <option value="evőkanál" {{ old('ingredients.' . $i . '.unit') == 'evőkanál' ? 'selected' : '' }}>evőkanál</option>
                            <option value="teáskanál" {{ old('ingredients.' . $i . '.unit') == 'teáskanál' ? 'selected' : '' }}>teáskanál</option>
                            <option value="csipet" {{ old('ingredients.' . $i . '.unit') == 'csipet' ? 'selected' : '' }}>csipet</option>
                            <option value="ízlés szerint" {{ old('ingredients.' . $i . '.unit') == 'ízlés szerint' ? 'selected' : '' }}>ízlés szerint</option>
                        </select>

                        @error('ingredients.' . $i . '.id')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        @error('ingredients.' . $i . '.quantity')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        @error('ingredients.' . $i . '.unit')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                @endfor
            </div>
            @error('ingredients')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Recept feltöltése</button>
    </form>
@endsection
