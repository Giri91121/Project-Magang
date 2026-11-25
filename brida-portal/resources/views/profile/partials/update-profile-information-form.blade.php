<section>
    <header>
        <h2 class="text-base font-black text-slate-900">
            Informasi Profil Akun
        </h2>
        <p class="mt-1 text-xs text-slate-500">
            Perbarui nama tampilan akun Anda. Email dikunci agar tetap sinkron dengan Google.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-5 space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-xs sm:text-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-xs sm:text-sm bg-slate-100 text-slate-500 cursor-not-allowed" :value="$user->email" readonly />
            <p class="mt-1.5 text-[11px] text-slate-500">
                <i class="fa-solid fa-lock mr-1 text-slate-400"></i> Email dikunci karena terhubung langsung dengan akun Google Anda.
            </p>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2 border-t border-bone-200">
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-xs font-bold text-emerald-600">
                    Tersimpan!
                </p>
            @endif
            <button type="submit" class="bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
