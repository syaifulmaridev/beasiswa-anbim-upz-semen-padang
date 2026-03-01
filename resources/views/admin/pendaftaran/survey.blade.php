@extends('layouts.app')

@section('title','Form Survey Beasiswa')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

<h1 class="text-2xl font-bold text-[#1f4a44]">
    Form Survey - {{ $pendaftaran->user->name }}
</h1>

<form method="POST"
      action="{{ route('admin.pendaftaran.storeSurvey', $pendaftaran->id) }}"
      class="space-y-8">

@csrf
{{-- ===================================================== --}}
{{-- TANGGAL SURVEY --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-4">

    <h2 class="font-bold text-lg border-b pb-2">Informasi Survey</h2>

    <div class="grid md:grid-cols-2 gap-4 text-sm">

        <div>
            <label class="font-medium">Tanggal Survey</label>
            <input type="date"
                   name="tanggal_survey"
                   value="{{ old('tanggal_survey', now()->format('Y-m-d')) }}"
                   class="w-full border rounded p-2 mt-1">
        </div>
    </div>

</div>

{{-- ===================================================== --}}
{{-- FOTO RUMAH (6 FOTO TERPISAH) --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-6">

    <h2 class="font-bold text-lg border-b pb-2">
        Dokumentasi Kondisi Rumah
    </h2>

    <div class="grid md:grid-cols-2 gap-6">

        @for($i = 1; $i <= 6; $i++)
        <div class="space-y-2">
            <label class="font-medium text-sm">Foto {{ $i }}</label>

            <input type="file"
                   name="foto_{{ $i }}"
                   accept="image/*"
                   class="w-full border rounded p-2 text-sm">

            <div id="preview{{ $i }}"
                 class="w-full h-32 bg-slate-50 border rounded-lg flex items-center justify-center text-xs text-gray-400">
                Belum ada foto
            </div>
        </div>
        @endfor

    </div>

</div>



{{-- ===================================================== --}}
{{-- 1. INDEKS RUMAH (FULL WIDTH - PADAT) --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-4">

    <h2 class="font-bold text-lg border-b pb-2">Indeks Rumah</h2>

    <div class="grid md:grid-cols-2 gap-4 text-sm">

        <div>
            <label class="font-medium">Ukuran Rumah</label>
            <select name="skor_rumah" class="w-full border rounded p-2">
                <option value="5">Sangat Kecil (&lt;4m²)</option>
                <option value="4">Kecil (4-6m²)</option>
                <option value="3">Sedang (6-8m²)</option>
                <option value="2">Besar (&gt;8m²)</option>
                <option value="1">Sangat Besar</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Kepemilikan</label>
            <select name="skor_kepemilikan" class="w-full border rounded p-2">
                <option value="5">Menumpang</option>
                <option value="4">Kontrak</option>
                <option value="3">Keluarga</option>
                <option value="1">Milik Sendiri</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Jenis Dinding</label>
            <select name="skor_dinding" class="w-full border rounded p-2">
                <option value="5">Bambu/Kayu</option>
                <option value="3">Semi</option>
                <option value="1">Tembok</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Jenis Lantai</label>
            <select name="skor_lantai" class="w-full border rounded p-2">
                <option value="5">Tanah</option>
                <option value="4">Panggung</option>
                <option value="3">Semen</option>
                <option value="1">Keramik</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Jenis Atap</label>
            <select name="skor_atap" class="w-full border rounded p-2">
                <option value="5">Ijuk/Kirai</option>
                <option value="3">Genteng/Seng</option>
                <option value="1">Azbes</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Fasilitas Dapur</label>
            <select name="skor_dapur" class="w-full border rounded p-2">
                <option value="5">Tungku</option>
                <option value="4">Minyak Tanah</option>
                <option value="2">Gas</option>
                <option value="1">Listrik</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Tempat Duduk</label>
            <select name="skor_kursi" class="w-full border rounded p-2">
                <option value="5">Lesehan</option>
                <option value="4">Balai Bambu</option>
                <option value="2">Kayu</option>
                <option value="1">Sofa</option>
            </select>
        </div>

    </div>
</div>

{{-- ===================================================== --}}
{{-- DATA ANGGOTA KELUARGA --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg border-b pb-2">
            Data Anggota Keluarga
        </h2>

        <button type="button"
                onclick="tambahKeluarga()"
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm">
            + Tambah
        </button>
    </div>

    <div id="keluargaWrapper" class="space-y-6">
        {{-- Form anggota akan muncul di sini --}}
    </div>

</div>

{{-- ===================================================== --}}
{{-- 2. KEUANGAN KELUARGA --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-6">

<h2 class="font-bold text-lg border-b pb-2">Keuangan Keluarga</h2>

{{-- ================= PENDAPATAN (A) ================= --}}
<div>
    <h3 class="font-semibold mb-3">Pendapatan Keluarga (A)</h3>

    <div class="space-y-3 text-sm">

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Pendapatan Ayah</label>
            <input type="number" name="ayah" class="income border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Pendapatan Ibu</label>
            <input type="number" name="ibu" class="income border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Usaha Lainnya</label>
            <input type="number" name="usaha_lain" class="income border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Dari Anak / Menantu</label>
            <input type="number" name="dari_anak" class="income border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

    </div>

    <div class="mt-4 flex justify-between font-bold text-sm border-t pt-3">
        <span>Total Pendapatan (A)</span>
        <span>Rp <span id="totalIncome">0</span></span>
    </div>
</div>


{{-- ================= PENGELUARAN (B) ================= --}}
<div>
    <h3 class="font-semibold mb-3 mt-6">Pengeluaran Rutin (B)</h3>

    <div class="space-y-3 text-sm">

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Kebutuhan Dapur</label>
            <input type="number" name="dapur" class="expense border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Pendidikan</label>
            <input type="number" name="pendidikan" class="expense border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Kesehatan</label>
            <input type="number" name="kesehatan" class="expense border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Listrik & Air</label>
            <input type="number" name="listrik" class="expense border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Transportasi</label>
            <input type="number" name="transportasi" class="expense border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

        <div class="grid grid-cols-3 gap-4 items-center">
            <label>Pengeluaran Lainnya</label>
            <input type="number" name="lainnya" class="expense border p-2 rounded col-span-2" placeholder="Jumlah / Bulan">
        </div>

    </div>

    <div class="mt-4 flex justify-between font-bold text-sm border-t pt-3">
        <span>Total Pengeluaran (B)</span>
        <span>Rp <span id="totalExpense">0</span></span>
    </div>
</div>


{{-- ================= HASIL AKHIR ================= --}}
<div class="mt-6 bg-slate-50 p-4 rounded-lg border">

    <div class="flex justify-between font-bold text-base">
        <span>Sisa Pendapatan (A - B)</span>
        <span id="finalResult" class="text-green-600">Rp 0</span>
    </div>

</div>

</div>



{{-- ================= SCRIPT OTOMATIS ================= --}}
<script>
document.addEventListener("input", function() {

    let incomeFields = document.querySelectorAll(".income");
    let expenseFields = document.querySelectorAll(".expense");

    let totalIncome = 0;
    let totalExpense = 0;

    incomeFields.forEach(input => {
        totalIncome += parseInt(input.value) || 0;
    });

    expenseFields.forEach(input => {
        totalExpense += parseInt(input.value) || 0;
    });

    let final = totalIncome - totalExpense;

    document.getElementById("totalIncome").innerText = totalIncome.toLocaleString();
    document.getElementById("totalExpense").innerText = totalExpense.toLocaleString();

    let finalEl = document.getElementById("finalResult");
    finalEl.innerText = "Rp " + final.toLocaleString();

    if(final < 0){
        finalEl.classList.remove("text-green-600");
        finalEl.classList.add("text-red-600");
    } else {
        finalEl.classList.remove("text-red-600");
        finalEl.classList.add("text-green-600");
    }

});
</script>


{{-- ===================================================== --}}
{{-- 3. ASET & KEPEMILIKAN --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-6">

<h2 class="font-bold text-lg border-b pb-2">Aset & Kepemilikan</h2>

<div class="space-y-4 text-sm">

    {{-- Kendaraan --}}
    <div class="grid grid-cols-3 gap-4 items-center">
        <label>Kendaraan</label>
        <select name="nama_kendaraan" class="border p-2 rounded">
            <option value="">Pilih Kendaraan</option>
            <option>Sepeda</option>
            <option>Motor</option>
            <option>Mobil</option>
            <option>Tidak Ada</option>
        </select>
        <input type="number" name="jumlah_kendaraan"
               class="asset border p-2 rounded"
               placeholder="Jumlah Unit">
    </div>

    {{-- Emas / Tabungan --}}
    <div class="grid grid-cols-3 gap-4 items-center">
        <label>Aset Keuangan</label>
        <select name="nama_aset_keuangan" class="border p-2 rounded">
            <option value="">Pilih Aset</option>
            <option>Emas</option>
            <option>Tabungan Bank</option>
            <option>Deposito</option>
            <option>Tidak Ada</option>
        </select>
        <input type="number" name="nilai_aset_keuangan"
               class="asset border p-2 rounded"
               placeholder="Nilai (Rp)">
    </div>

    {{-- Kebun / Sawah --}}
    <div class="grid grid-cols-3 gap-4 items-center">
        <label>Kebun / Sawah</label>
        <select name="nama_kebun" class="border p-2 rounded">
            <option value="">Pilih Jenis</option>
            <option>Sawah</option>
            <option>Kebun</option>
            <option>Ladang</option>
            <option>Tidak Ada</option>
        </select>
        <input type="number" name="luas_kebun"
               class="asset border p-2 rounded"
               placeholder="Luas (m²)">
    </div>

    {{-- Ternak --}}
    <div class="grid grid-cols-3 gap-4 items-center">
        <label>Ternak</label>
        <select name="nama_ternak" class="border p-2 rounded">
            <option value="">Pilih Ternak</option>
            <option>Sapi</option>
            <option>Kambing</option>
            <option>Ayam</option>
            <option>Bebek</option>
            <option>Tidak Ada</option>
        </select>
        <input type="number" name="jumlah_ternak"
               class="asset border p-2 rounded"
               placeholder="Jumlah Ekor">
    </div>

    {{-- Elektronik --}}
    <div class="grid grid-cols-3 gap-4 items-center">
        <label>Elektronik</label>
        <select name="nama_elektronik" class="border p-2 rounded">
            <option value="">Pilih Elektronik</option>
            <option>TV</option>
            <option>Kulkas</option>
            <option>Laptop</option>
            <option>Mesin Cuci</option>
            <option>Tidak Ada</option>
        </select>
        <input type="number" name="jumlah_elektronik"
               class="asset border p-2 rounded"
               placeholder="Jumlah Unit">
    </div>

</div>

{{-- TOTAL ASET --}}
<div class="mt-6 flex justify-between font-bold text-sm border-t pt-3">
    <span>Total Nilai / Jumlah Aset</span>
    <span>Rp <span id="totalAsset">0</span></span>
</div>

</div>

<script>
document.addEventListener("input", function() {

    let assetFields = document.querySelectorAll(".asset");
    let totalAsset = 0;

    assetFields.forEach(input => {
        totalAsset += parseInt(input.value) || 0;
    });

    document.getElementById("totalAsset").innerText = totalAsset.toLocaleString();

});
</script>

{{-- ===================================================== --}}
{{-- 4. PENILAIAN KEAGAMAAN --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-6">

<h2 class="font-bold text-lg border-b pb-2">Penilaian Keagamaan</h2>

<div class="space-y-4 text-sm">

    {{-- 1 --}}
    <div>
        <label class="font-medium">Kelancaran Baca Al Qur'an</label>
        <select name="skor_baca_quran" class="w-full border rounded p-2 mt-1 skor-agama">
            <option value="4">Lancar, fasih tajwid, dan irama murotal</option>
            <option value="3">Lancar dan biasa saja</option>
            <option value="2">Kurang lancar terbata-bata</option>
            <option value="1">Tidak bisa</option>
        </select>
    </div>

    {{-- 2 --}}
    <div>
        <label class="font-medium">Hafalan Al Qur'an</label>
        <select name="skor_hafalan" class="w-full border rounded p-2 mt-1 skor-agama">
            <option value="4">3 Juz</option>
            <option value="3">2 Juz</option>
            <option value="2">1 Juz</option>
            <option value="1">Kurang 1 juz</option>
        </select>
    </div>

    {{-- 3 --}}
    <div>
        <label class="font-medium">Tatacara Ibadah Shalat</label>
        <select name="skor_shalat" class="w-full border rounded p-2 mt-1 skor-agama">
            <option value="4">Sangat lancar bacaan dan gerakan</option>
            <option value="3">Lancar bacaan dan gerakan</option>
            <option value="2">Kurang lancar gerakan dan bacaan</option>
            <option value="1">Tidak bisa bacaan dan gerakan</option>
        </select>
    </div>

    {{-- 4 --}}
    <div>
        <label class="font-medium">Keaktifan Ibadah</label>
        <select name="skor_ibadah" class="w-full border rounded p-2 mt-1 skor-agama">
            <option value="4">Aktif Shalat</option>
            <option value="3">Cukup Aktif</option>
            <option value="2">Kurang Aktif</option>
            <option value="1">Tidak Aktif</option>
        </select>
    </div>

</div>
</div>

{{-- ===================================================== --}}
{{-- HASIL SKOR --}}
{{-- ===================================================== --}}
<div class="bg-yellow-50 p-6 rounded-xl border space-y-4">

    <!-- NILAI UTAMA -->
    <div class="flex justify-between items-center">
        <span class="text-lg font-semibold">Nilai Akhir</span>
        <span id="nilaiAkhir" class="text-3xl font-bold text-green-700">0</span>
    </div>

    <!-- STATUS -->
    <div class="flex justify-between font-semibold text-base">
        <span>Status Kelayakan</span>
        <span id="status">-</span>
    </div>

    <!-- Skor mentah kecil -->
    <div class="text-sm text-gray-500 border-t pt-2">
        Skor Mentah: <span id="totalSkor">0</span> / 52
    </div>

</div>

{{-- ===================================================== --}}
{{-- 4. REKOMENDASI --}}
{{-- ===================================================== --}}
<div class="bg-white p-6 rounded-xl shadow space-y-4">

<h2 class="font-bold text-lg border-b pb-2">Rekomendasi Surveyor</h2>

<select name="status_survey" class="w-full border p-2 rounded">
    <option value="Sangat Layak">Sangat Layak</option>
    <option value="Layak">Layak</option>
    <option value="Dipertimbangkan">Dipertimbangkan</option>
    <option value="Ditolak">Ditolak</option>
</select>

<textarea name="catatan"
          rows="4"
          placeholder="Catatan hasil survey..."
          class="w-full border p-2 rounded"></textarea>

</div>


<div class="flex justify-between items-center mt-6">

    <a href="{{ route('admin.pendaftaran.index', $pendaftaran->id) }}"
       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
        ← Kembali
    </a>

    <button type="submit"
            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
        Simpan Hasil Survey
    </button>

</div>

</form>
</div>

<script>
document.addEventListener("change", function() {

    let totalSkor = 0;

    document.querySelectorAll("select[name^='skor_']").forEach(function(e){
        totalSkor += parseInt(e.value) || 0;
    });

    // Tampilkan skor mentah kecil
    document.getElementById("totalSkor").innerText = totalSkor;

    // Konversi ke 0–100
    let nilaiAkhir = Math.round((totalSkor / 52) * 100);

    document.getElementById("nilaiAkhir").innerText = nilaiAkhir;

    let status = "";

    if (nilaiAkhir >= 70) {
        status = "Sangat Layak";
    } 
    else if (nilaiAkhir >= 55) {
        status = "Dipertimbangkan";
    } 
    else {
        status = "Tidak Cocok";
    }

    document.getElementById("status").innerText = status;

});
</script>

<script>
for (let i = 1; i <= 6; i++) {

    document.querySelector("input[name='foto_" + i + "']")
        .addEventListener("change", function(e){

        let preview = document.getElementById("preview" + i);
        preview.innerHTML = "";

        let file = e.target.files[0];

        if(file){

            let reader = new FileReader();

            reader.onload = function(event){
                let img = document.createElement("img");
                img.src = event.target.result;
                img.classList.add("w-full","h-32","object-cover","rounded-lg");
                preview.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    });
}
</script>

<script>
let indexKeluarga = 0;

function tambahKeluarga() {

    const wrapper = document.getElementById('keluargaWrapper');

    const html = `
    <div class="border p-4 rounded-lg relative bg-slate-50">

        <button type="button"
                onclick="this.parentElement.remove()"
                class="absolute top-2 right-2 text-red-500 text-sm">
            ✕
        </button>

        <div class="grid md:grid-cols-2 gap-4 text-sm">

            <div>
                <label>Nama</label>
                <input type="text" name="keluarga[${indexKeluarga}][nama]"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Umur</label>
                <input type="number" name="keluarga[${indexKeluarga}][umur]"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Status</label>
                <select name="keluarga[${indexKeluarga}][status]"
                        class="w-full border rounded p-2">
                    <option>Belum Menikah</option>
                    <option>Menikah</option>
                    <option>Cerai</option>
                </select>
            </div>

            <div>
                <label>Hubungan</label>
                <input type="text" name="keluarga[${indexKeluarga}][hubungan]"
                       class="w-full border rounded p-2"
                       placeholder="Ayah / Ibu / Saudara">
            </div>

            <div>
                <label>Pendidikan</label>
                <input type="text" name="keluarga[${indexKeluarga}][pendidikan]"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Pekerjaan</label>
                <input type="text" name="keluarga[${indexKeluarga}][pekerjaan]"
                       class="w-full border rounded p-2">
            </div>

        </div>
    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);

    indexKeluarga++;
}
</script>

@endsection