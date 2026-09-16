@extends('layouts.app')

@section('title', 'Alapanyagok (admin)')

@section('content')
    <h1>Alapanyagok kezelése</h1>

    @if ($ingredients->isEmpty())
        <p>Nincs még alapanyag.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Kalória</th>
                    <th>Szénhidrát</th>
                    <th>Fehérje</th>
                    <th>Zsír</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingredients as $ingredient)
                    <tr>
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ $ingredient->calories }}</td>
                        <td>{{ $ingredient->carbohydrate }}</td>
                        <td>{{ $ingredient->protein }}</td>
                        <td>{{ $ingredient->fat }}</td>
                        <td>
                            <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törlöd ezt az alapanyagot? Minden receptből eltűnik!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
