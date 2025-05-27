@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Editar Locação</h1>

    <form action="{{ route('rentals.update', $rental) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="block mb-1">Equipamento</label>
            <input type="text" value="{{ $rental->equipment->name }}" disabled
                class="w-full border p-2 rounded bg-gray-200 text-gray-700">
        </div>

        <div class="mb-3">
            <label class="block mb-1">Data de Início</label>
            <input type="date" name="start_date" required class="w-full border p-2 rounded"
                value="{{ \Carbon\Carbon::parse($rental->start_date)->format('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label class="block mb-1">Data de Término</label>
            <input type="date" name="end_date" required class="w-full border p-2 rounded"
                value="{{ \Carbon\Carbon::parse($rental->end_date)->format('Y-m-d') }}">
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('rentals.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Atualizar</button>
        </div>
    </form>
@endsection
