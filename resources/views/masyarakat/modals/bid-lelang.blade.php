<!-- Modal Bid Lelang -->
<div class="modal fade" id="bidModal{{ $lelang->id_lelang }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajukan Penawaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('masyarakat.lelang.bid', $lelang->id_lelang) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        @if ($lelang->barang->gambarPrimary)
                            <img src="{{ asset('storage/barang/' . $lelang->barang->gambarPrimary->gambar) }}"
                                class="img-fluid rounded mb-3" style="width: 150px; height: 150px; object-fit: cover;"
                                alt="{{ $lelang->barang->nama_barang }}">
                        @endif
                        <h6>{{ $lelang->barang->nama_barang }}</h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Harga Saat Ini</strong></label>
                        <div class="alert alert-info py-2">
                            <h5 class="mb-0 text-center">
                                Rp
                                {{ number_format($lelang->harga_akhir > 0 ? $lelang->harga_akhir : $lelang->barang->harga_awal, 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>

                    @php
                        $minBid = $lelang->harga_akhir > 0 ? $lelang->harga_akhir : $lelang->barang->harga_awal;
                        $increment = 0;
                        if ($minBid <= 500000) {
                            $increment = 10000;
                        } elseif ($minBid <= 2000000) {
                            $increment = 50000;
                        } elseif ($minBid <= 10000000) {
                            $increment = 100000;
                        } elseif ($minBid <= 50000000) {
                            $increment = 500000;
                        } else {
                            $increment = 1000000;
                        }
                        $minRequired = $minBid + $increment;
                    @endphp

                    <div class="mb-3">
                        <label for="penawaran_harga" class="form-label">
                            <strong>Penawaran Anda</strong>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="penawaran_harga" name="penawaran_harga"
                                min="{{ $minRequired }}" value="{{ $minRequired }}" required
                                onchange="validateBid({{ $minRequired }}, this)">
                        </div>
                        <div class="form-text">
                            <small>
                                <i class="icofont-info-circle"></i>
                                Penawaran minimal: <strong>Rp {{ number_format($minRequired, 0, ',', '.') }}</strong>
                                <br>
                                <i class="icofont-law-document"></i>
                                Increment: Rp {{ number_format($increment, 0, ',', '.') }}
                            </small>
                        </div>
                    </div>

                    <!-- Info pemenang saat ini -->
                    @if ($lelang->harga_akhir > 0)
                        <div class="alert alert-warning py-2">
                            <small>
                                <i class="icofont-crown"></i>
                                Saat ini memimpin:
                                <strong>
                                    @if ($lelang->historyLelang->where('penawaran_harga', $lelang->harga_akhir)->first())
                                        @php
                                            $currentLeader = $lelang->historyLelang
                                                ->where('penawaran_harga', $lelang->harga_akhir)
                                                ->first()->user;
                                        @endphp
                                        @if ($currentLeader->id_user == Auth::guard('masyarakat')->id())
                                            Anda
                                        @else
                                            {{ $currentLeader->nama_lengkap }}
                                        @endif
                                    @endif
                                </strong>
                            </small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="icofont-handshake-deal"></i> Ajukan Penawaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateBid(minRequired, input) {
        if (parseInt(input.value) < minRequired) {
            input.setCustomValidity('Penawaran minimal harus Rp ' + minRequired.toLocaleString('id-ID'));
        } else {
            input.setCustomValidity('');
        }
    }
</script>
