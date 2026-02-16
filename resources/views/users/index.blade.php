@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-secondary">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-primary">Kelola Anggota 👥</h2>
                <p class="text-gray-500 text-sm">Daftar siswa yang terdaftar di perpustakaan.</p>
            </div>
            <div class="bg-secondary/10 text-secondary px-4 py-2 rounded-lg font-bold">
                Total: {{ $users->total() }} Siswa
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 animate-fade-in-up">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 animate-fade-in-up">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Bergabung Sejak</th>
                        <th class="p-4">Status Pinjam</th>
                        <th class="p-4">Total Pinjam</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-500">{{ $index + $users->firstItem() }}</td>
                            <td class="p-4 font-bold text-primary">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600 font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="p-4 text-gray-600">{{ $user->email }}</td>
                            <td class="p-4 text-sm text-gray-500">
                                {{ $user->created_at->translatedFormat('d F Y') }}
                            </td>
                            <td class="p-4 text-gray-600 font-bold">
                                @if ($user->transactions->where('status', 'dipinjam')->count() > 0)
                                <span class="text-red-500">User Masih Meminjam</span>
                                @else
                                <span class="text-green-500">Bebas</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-600">{{ $user->transactions->count() }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau menghapus siswa {{ $user->name }}? Data tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Belum ada siswa yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
