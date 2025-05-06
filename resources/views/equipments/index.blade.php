@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Equipamentos</h1>
        <div class="flex gap-2">
            <button id="openFilter" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-xl">
                Filtrar
            </button>
            <button id="openModal" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl">
                + Adicionar novo
            </button>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        @foreach ($equipments as $equipment)
            <div class="bg-gray-800 p-5 rounded-xl shadow-md hover:shadow-lg transition">
                <h2 class="text-xl font-semibold mb-2">{{ $equipment->name }}</h2>
                <p class="text-sm text-gray-400 mb-2">{{ $equipment->description }}</p>
                <p class="{{ $equipment->is_available ? 'text-green-400' : 'text-red-400' }} font-medium">
                    R$ {{ number_format($equipment->daily_value, 2, ',', '.') }} / dia
                </p>
                <p class="text-sm mt-1">
                    @if ($equipment->is_available)
                        <span class="text-green-400">Disponível</span>
                    @else
                        <span class="text-red-400">Indisponível até {{ $equipment->unavailable_until }}</span>
                    @endif
                </p>
            </div>
        @endforeach
    </div>


    <div id="modal" class="hidden fixed inset-0 bg-[#00000080] flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-md mx-auto text-gray-700">
            <h2 class="text-lg font-semibold mb-4">Novo Equipamento</h2>
            <form id="equipmentForm" action="{{ route('equipments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Nome</label>
                    <input type="text" name="name" required class="w-full border p-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Descrição</label>
                    <textarea name="description" required class="w-full border p-2 rounded"></textarea>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Valor Diária (R$)</label>
                    <input type="number" step="0.01" name="daily_value" required class="w-full border p-2 rounded">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="closeModal"
                        class="px-4 py-2 bg-gray-400 text-white rounded cursor-pointer">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 cursor-pointer">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="filterOverlay" class="hidden fixed inset-0 bg-[#00000080] z-40 flex justify-end">
        <div class="bg-white w-80 p-6 shadow-xl h-full text-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Filtrar Equipamentos</h2>
                <button id="closeFilter" class="text-gray-600 hover:text-black">✖</button>
            </div>
            <form method="GET" action="{{ route('equipments.index') }}">
                <div class="mb-4">
                    <label class="block mb-1">Nome</label>
                    <input type="text" value="{{ request('name')}}" name="name" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Disponibilidade</label>
                    <select name="available" class="w-full border p-2 rounded">
                        <option value="1" {{ request('available', '1') === '1' ? 'selected' : '' }}>Disponível</option>
                        <option value="0" {{ request('available') === '0' ? 'selected' : '' }}>Indisponível</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Data</label>
                    <input type="date" name="date" value="{{ request('date', now()->toDateString()) }}"
                        class="w-full border p-2 rounded">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Aplicar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/components.js') }}"></script>
@endsection
