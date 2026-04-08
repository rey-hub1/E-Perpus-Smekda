@extends('layouts.admin')

@section('title', 'Anggota')
@section('page-title', 'Data Anggota')
@section('page-subtitle', 'Daftar siswa yang terdaftar di perpustakaan')

@section('content')
<div class="space-y-5">

    @if (session('success'))
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-gray-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <span class="text-gray-700 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-900">Daftar Siswa</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $users->total() }} total anggota terdaftar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-8">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Bergabung</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Pinjam</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Pinjam</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-5 py-4 text-gray-400 text-xs">{{ $index + $users->firstItem() }}</td>

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-gray-500">{{ $user->email }}</td>

                            <td class="px-5 py-4 text-xs text-gray-400">
                                {{ $user->created_at->translatedFormat('d F Y') }}
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if ($user->transactions->where('status', 'dipinjam')->count() > 0)
                                    <span class="inline-block bg-red-50 text-primary text-xs font-semibold px-2.5 py-1 rounded-full border border-red-100">
                                        Meminjam
                                    </span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        Bebas
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="text-sm font-semibold text-gray-700">{{ $user->transactions->count() }}</span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus anggota {{ $user->name }}? Data tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs font-semibold text-primary border border-red-100 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z"/>
                                </svg>
                                <p class="text-sm text-gray-400">Belum ada anggota terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                {{ $users->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
