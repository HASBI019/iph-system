@extends('layouts.admin')
@section('title', 'Pengaturan Tampilan Publik')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-6 bg-white rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-blue-800">⚙️ Pengaturan Tampilan Publik</h1>

    {{-- ✅ Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ❌ Error Message --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 📝 Form --}}
    <form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- 🔤 Judul & Subjudul --}}
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

        {{-- 🏠 Alamat --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300">{{ old('alamat', $setting->alamat) }}</textarea>
        </div>

        {{-- 📞 Kontak --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300">
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Email (pisahkan dengan titik koma)</label>
                <input type="text" name="email" value="{{ old('email', $setting->email) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300"
                       placeholder="bps3206@bps.go.id ; pengaduan3206@bps.go.id">
            </div>
        </div>

        {{-- 🖼️ Logo --}}
        <div class="grid md:grid-cols-3 gap-6 mt-4">
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Logo Utama</label>
                @if(!cache('hide_logo_admin_preview') && $setting->logo)
                    <img src="{{ asset('storage/'.$setting->logo) }}" class="h-16 mb-3 rounded">
                @endif
                <input type="file" name="logo"
                       class="w-full border rounded px-3 py-2 file:bg-blue-800 file:text-white">
            </div>

            <div>
                <label class="block font-semibold mb-2 text-gray-700">Logo Berakhlak</label>
                @if(!cache('hide_logo_admin_preview') && $setting->logo_berakhlak)
                    <img src="{{ asset('storage/'.$setting->logo_berakhlak) }}" class="h-16 mb-3 rounded">
                @endif
                <input type="file" name="logo_berakhlak"
                       class="w-full border rounded px-3 py-2 file:bg-blue-800 file:text-white">
            </div>

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

           {{-- 📷 Upload Foto IPH --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Ganti Foto IPH</label>
            @if($setting->foto_iph)
                <img src="{{ asset('storage/' . $setting->foto_iph) }}" class="h-32 mb-3 rounded shadow">
            @endif
            <input type="file" name="foto_iph"
                   class="w-full border rounded px-3 py-2 file:bg-blue-800 file:text-white">
        </div>

        {{-- 📝 Deskripsi IPH --}}
        <div>
            <label for="deskripsi_iph" class="block font-semibold mb-1 text-gray-700">Deskripsi IPH</label>
            <textarea id="deskripsi_iph" name="deskripsi_iph" rows="5"
                      class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-300"
                      placeholder="Indeks Perubahan Harga (IPH) adalah...">{{ old('deskripsi_iph', $setting->deskripsi_iph) }}</textarea>
        </div>

        {{-- 💾 Submit --}}
        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-800 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
                💾 Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

@push('script')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('deskripsi_iph', {
        height: 200,
        removeButtons: 'Image,Table,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe'
    });
</script>

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
@endpush
