@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-text">Profil Saya</h1>
            <p class="text-sm text-text/50 mt-1">Kelola informasi akunmu.</p>
        </div>

        {{-- Avatar + Stats card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col sm:flex-row items-center sm:items-start gap-6">

            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 border-2 border-gray-200 shadow-sm">
                    @if ($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-primary/10">
                            <span class="text-3xl font-black text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1 text-center sm:text-left">
                <h2 class="text-xl font-bold text-text">{{ $user->name }}</h2>
                <p class="text-sm text-text/50 mt-0.5">{{ $user->email }}</p>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-3">
                    @if ($user->kelas)
                        <span class="text-xs font-semibold bg-primary/10 text-primary px-3 py-1 rounded-full">
                            Kelas {{ $user->kelas }}
                        </span>
                    @endif
                    <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-3 py-1 rounded-full capitalize">
                        {{ $user->role }}
                    </span>
                </div>
            </div>

            {{-- Stats --}}
            <div class="flex sm:flex-col gap-3 sm:gap-2 text-center shrink-0">
                <div class="bg-yellow-50 border border-yellow-100 rounded-xl px-4 py-2 min-w-[80px]">
                    <div class="text-xl font-black text-yellow-600">{{ $dipinjam }}</div>
                    <div class="text-[10px] font-semibold text-yellow-500 uppercase tracking-wide">Dipinjam</div>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl px-4 py-2 min-w-[80px]">
                    <div class="text-xl font-black text-green-600">{{ $dikembalikan }}</div>
                    <div class="text-[10px] font-semibold text-green-500 uppercase tracking-wide">Selesai</div>
                </div>
                @if ($terlambat > 0)
                    <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-2 min-w-[80px]">
                        <div class="text-xl font-black text-red-600">{{ $terlambat }}</div>
                        <div class="text-[10px] font-semibold text-red-500 uppercase tracking-wide">Terlambat</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Edit Info Form --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-text">Informasi Pribadi</h3>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Avatar upload --}}
                <div>
                    <label class="block text-sm font-semibold text-text/70 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-100 border border-gray-200 shrink-0" id="avatarPreviewWrap">
                            @if ($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" id="avatarPreview" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-primary/10" id="avatarInitial">
                                    <span class="text-xl font-black text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <img id="avatarPreview" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <label class="cursor-pointer">
                            <span class="text-sm font-semibold text-primary border border-primary/30 bg-primary/5 hover:bg-primary/10 px-4 py-2 rounded-lg transition-colors">
                                Ganti Foto
                            </span>
                            <input type="file" name="avatar" accept="image/*" class="hidden" id="avatarInput">
                        </label>
                        <span class="text-xs text-text/40">JPG, PNG, WEBP. Maks 2MB</span>
                    </div>
                    @error('avatar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-text/70 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-text/70 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Kelas --}}
                    <div>
                        <label class="block text-sm font-semibold text-text/70 mb-1.5">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}"
                               placeholder="Contoh: XII IPA 1"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition">
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-semibold text-text/70 mb-1.5">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition">
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit"
                            class="bg-primary hover:bg-secondary text-white font-bold text-sm px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Ganti Password --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" id="password">

            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-text">Ganti Password</h3>
            </div>

            @if (session('success_password'))
                <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success_password') }}
                </div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-text/70 mb-1.5">Password Lama</label>
                    <input type="password" name="current_password"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition @error('current_password') border-red-400 @enderror">
                    @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-text/70 mb-1.5">Password Baru</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition @error('password') border-red-400 @enderror">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-text/70 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition">
                </div>

                <div class="pt-1">
                    <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white font-bold text-sm px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        document.getElementById('avatarInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById('avatarPreview');
                const initial = document.getElementById('avatarInitial');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (initial) initial.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
