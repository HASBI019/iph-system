@extends('layouts.admin')
@section('title', 'Pengaturan Tampilan Publik')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-6 bg-white rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-blue-800">⚙️ Pengaturan Tampilan Publik</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Judul Utama</label>
                <input type="text" name="judul" value="{{ old('judul', $setting->judul) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300">
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Subjudul</label>
                <input type="text" name="subjudul" value="{{ old('subjudul', $setting->subjudul) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300">
            </div>
        </div>

        <div>
            <label class="block font-semibold mb-1 text-gray-700">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300">{{ old('alamat', $setting->alamat) }}</textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300">
            </div>
            <div>
    <label class="block font-semibold mb-1 text-gray-700">
        Email (bisa lebih dari satu, pisahkan pakai titik koma)
    </label>
    <input type="text" name="email" value="{{ old('email', $setting->email) }}"
           class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300"
           placeholder="bps3206@bps.go.id ; pengaduan3206@bps.go.id">
</div>

        </div>

        <div class="grid md:grid-cols-3 gap-6 mt-4">
            {{-- Logo Utama --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Logo Utama</label>
                @if(!cache('hide_logo_admin_preview') && $setting->logo)
                    <img src="{{ asset('storage/'.$setting->logo) }}" class="h-16 mb-3 rounded">
                @endif
                <input type="file" name="logo"
                       class="w-full border rounded px-3 py-2 file:bg-blue-800 file:text-white">
            </div>

            {{-- Logo Berakhlak --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Logo Berakhlak</label>
                @if(!cache('hide_logo_admin_preview') && $setting->logo_berakhlak)
                    <img src="{{ asset('storage/'.$setting->logo_berakhlak) }}" class="h-16 mb-3 rounded">
                @endif
                <input type="file" name="logo_berakhlak"
                       class="w-full border rounded px-3 py-2 file:bg-blue-800 file:text-white">
            </div>

            {{-- Logo IPH --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Logo IPH</label>
                @if(!cache('hide_logo_admin_preview') && $setting->logo_iph)
                    <img id="preview_logo_iph" src="{{ asset('storage/' . $setting->logo_iph) }}"
                         class="h-16 mb-3 rounded">
                @else
                    <img id="preview_logo_iph" src="" class="h-16 mb-3 hidden rounded">
                @endif
                <input type="file" name="logo_iph"
                       onchange="previewLogoIph(this)"
                       class="w-full border rounded px-3 py-2 file:bg-blue-800 file:text-white">
            </div>
        </div>
        <div>
    <label class="block font-semibold mb-1 text-gray-700">Tahukah Kamu (optional)</label>
    <textarea name="tahukah_kamu" rows="3"
              class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300"
              placeholder="Grand Hotel Preanger is one of the oldest hotels in Bandung.">{{ old('tahukah_kamu', $setting->tahukah_kamu) }}</textarea>
</div>


        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-800 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
                💾 Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
function previewLogoIph(input) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('preview_logo_iph');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    }
    if (input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
