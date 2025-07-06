@csrf
<div class="alert alert-warning" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <strong>Penting:</strong> Pastikan **Kode Pos** diisi dengan benar untuk perhitungan ongkos kirim yang akurat.
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="label" class="form-label">Label Alamat <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label"
            value="{{ old('label', $address->label ?? '') }}" placeholder="Contoh: Rumah, Kantor" required>
        @error('label')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="recipient_name" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('recipient_name') is-invalid @enderror" id="recipient_name"
            name="recipient_name" value="{{ old('recipient_name', $address->recipient_name ?? '') }}" required>
        @error('recipient_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="phone_number" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
            name="phone_number" value="{{ old('phone_number', $address->phone_number ?? '') }}" required>
        @error('phone_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="postal_code" class="form-label">Kode Pos <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code"
            name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" required>
        @error('postal_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="full_address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
    <textarea class="form-control @error('full_address') is-invalid @enderror" id="full_address" name="full_address"
        rows="4" placeholder="Tulis nama jalan, nomor rumah, RT/RW, kelurahan, dan kecamatan." required>{{ old('full_address', $address->full_address ?? '') }}</textarea>
    @error('full_address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('customer.profile.alamat.index') }}" class="btn btn-secondary me-2">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan Alamat</button>
</div>
