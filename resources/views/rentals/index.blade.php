@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Pedidos de Locação</h1>

    <button id="openRentalModal" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl mb-4">
        + Nova Locação
    </button>

    <div id="rentalModal" class="hidden fixed inset-0 bg-[#00000080] flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-md mx-auto text-gray-700">
            <h2 class="text-lg font-semibold mb-4">Nova Locação</h2>
            <form action="{{ route('rentals.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Data de Início</label>
                    <input type="date" id="start_date" name="start_date" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Data de Término</label>
                    <input type="date" id="end_date" name="end_date" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Equipamento</label>
                    <select id="equipment_id" name="equipment_id" class="w-full border p-2 rounded" disabled>
                        <option>Selecione datas válidas</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="closeRentalModal"
                        class="px-4 py-2 bg-gray-400 text-white rounded cursor-pointer">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 cursor-pointer">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        @forelse ($rentals as $rental)
            <div class="bg-gray-800 p-5 rounded-xl shadow-md">
                <h2 class="text-lg font-semibold text-white mb-1">{{ $rental->equipment->name }}</h2>
                <p class="text-sm text-gray-400">De: {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }} —
                    Até: {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}</p>
                <p class="text-green-400 mt-1">Total: R$ {{ number_format($rental->value, 2, ',', '.') }}</p>

                <span
                    class="inline-block mt-2 px-3 py-1 rounded-full
                    @if (\Carbon\Carbon::now()->between($rental->start_date, $rental->end_date)) bg-yellow-500 text-white
                    @elseif (\Carbon\Carbon::now()->gt($rental->end_date))
                        bg-green-500 text-white
                    @else
                        bg-red-500 text-white @endif
                ">
                    @if (\Carbon\Carbon::now()->between($rental->start_date, $rental->end_date))
                        Em Andamento
                    @elseif (\Carbon\Carbon::now()->gt($rental->end_date))
                        Concluído
                    @else
                        Reservado
                    @endif
                </span>

                <div class="mt-3 flex gap-2">
                    @if (!\Carbon\Carbon::parse($rental->end_date)->isPast())
                        <a href="{{ route('rentals.edit', $rental->id) }}"
                            class="px-4 py-2 bg-yellow-200 text-gray-600 rounded hover:bg-yellow-600">
                            Editar
                        </a>
                        <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST"
                            onsubmit="return confirm('Tem certeza que deseja cancelar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                                Cancelar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-400">Nenhum pedido de locação encontrado.</p>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/rentals.js') }}"></script>
@endsection
