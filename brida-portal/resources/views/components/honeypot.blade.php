{{-- Komponen Jebakan Anti-Spam Honeypot (Tidak Terlihat oleh Manusia, Menangkap Bot Otomatis) --}}
<div style="position: absolute; left: -9999px; top: -9999px; opacity: 0; pointer-events: none;" aria-hidden="true">
    <label for="website_hp_url">Jangan isi kolom ini jika Anda manusia</label>
    <input type="text" name="website_hp_url" id="website_hp_url" value="" tabindex="-1" autocomplete="off">
    <input type="hidden" name="hp_timestamp" value="{{ encrypt(now()->timestamp) }}">
</div>
