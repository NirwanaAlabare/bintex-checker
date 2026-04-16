@extends('layouts.index')

@section('custom-link')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{-- <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        .table {
            width: 99% !important;
        }

        .table-responsive table td,
        .table-responsive table th {
            font-size: 15px !important;
        }

        body {
            font-size: 19px;
        }
    </style>
@endsection


@section('content')
    {{-- <form id="form" name='form'> --}}
        <div class="card card-sb collapsed-card" id = "scan-qr-header">
            <div class="card-header" data-card-widget="collapse">
                <h5 class="card-title fw-bold mb-0"><i class="fas fa-hand-pointer"></i> Scan Barcode Bintex</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-end justify-content-center">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label label-input"><small><b>QR Code</b></small></label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm border-input" name="txtqr" id="txtqr" autocomplete="off" enterkeyhint="go" onkeyup="if (event.keyCode == 13) document.getElementById('scan_qr').click()" autofocus>
                                {{-- <input type="button" class="btn btn-sm btn-sb" value="Scan Line" /> --}}
                                {{-- style="display: none;" --}}
                                <button class="btn btn-sm btn-primary" type="button" id="scan_qr" onclick="scanqr()">Scan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div></div>
                    </div>
                    <div class="col-md-8">
                        <center>
                            {{-- <div id="reader_s"></div> --}}
                            <video id="scan-qr-nimic" style="max-width: 100%;max-height: 300px;"></video>
                        </center>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </div>
        </div>
    {{-- </form> --}}

    <div class="card card-sb">
        <div class="card-header">
            <h5 class="card-title fw-bold mb-0"><i class="fas fa-list"></i> Item Detail</h5>
        </div>
        <div class="card-body">
            <h3 class="text-sb fw-bold" id="label_kode_numbering">Kode Barcode Bintex</h3>
            <div class="row align-items-end justify-content-center">
                <div class="col-3 col-md-3">
                    <div class="mb-3">
                        <label class="form-label"><small><b>ID Item</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_id_item" id="detail_id_item" readonly>
                    </div>
                </div>
                <div class="col-9 col-md-9">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Nama Item</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_nama_item" id="detail_nama_item" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Supplier</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_supplier" id="detail_supplier" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Buyer</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_buyer" id="detail_buyer" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Worksheet</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_worksheet" id="detail_worksheet" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Style</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_style" id="detail_style" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Color Item</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_color_item" id="detail_color_item" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Color Garment</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_color_garment" id="detail_color_garment" readonly>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Lot</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_lot" id="detail_lot" readonly>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Roll</b></small></label>
                        <input type="text" class="form-control form-control-sm text-end" name="detail_no_roll" id="detail_no_roll" readonly>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Roll Buyer</b></small></label>
                        <input type="text" class="form-control form-control-sm text-end" name="detail_no_roll_buyer" id="detail_no_roll_buyer" readonly>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Ukuran</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="detail_ukuran" id="detail_ukuran" readonly>
                    </div>
                </div>
                
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Qty Awal</b></small></label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm text-end" name="detail_qty_awal" id="detail_qty_awal" readonly>
                            <input type="text" class="form-control form-control-sm" name="detail_satuan_qty_awal" id="detail_satuan_qty_awal" readonly style="width: auto; max-width: 40%;">
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b></b></small></label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm text-end" name="detail_qty_akhir" id="detail_qty_akhir" readonly>
                            <input type="text" class="form-control form-control-sm" name="detail_satuan_qty_akhir" id="detail_satuan_qty_akhir" readonly style="width: auto; max-width: 40%;">
                        </div>
                    </div>
                </div>

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">PENERIMAAN KAIN</h5>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No BPB</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="penerimaan_no_bpb" id="penerimaan_no_bpb"
                            readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tgl BPB</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="penerimaan_tgl_bpb" id="penerimaan_tgl_bpb"
                            readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Packing List</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="penerimaan_no_packing_list" id="penerimaan_no_packing_list"
                            readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Lokasi</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="penerimaan_lokasi" id="penerimaan_lokasi"
                            readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tipe</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="penerimaan_tipe" id="penerimaan_tipe"
                            readonly>
                    </div>
                </div>

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">FABRIC INSPECTION</h5>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Inspect Result</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_inspect_result" id="fabric_inspect_result" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tgl Inspect</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_tgl_inspect" id="fabric_tgl_inspect" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Mesin Inspect</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_mesin_inspect" id="fabric_mesin_inspect" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Grouping Result</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_grouping_result" id="fabric_grouping_result" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tgl Grouping</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_tgl_grouping" id="fabric_tgl_grouping" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Grouping User</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_grouping_user" id="fabric_grouping_user" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Start Relax</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_start_relax" id="fabric_start_relax" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Finish Relax</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_finish_relax" id="fabric_finish_relax" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Mesin Relax</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="fabric_mesin_relax" id="fabric_mesin_relax" readonly>
                    </div>
                </div>

                {{-- <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">MUTASI RAK</h5>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Trans Mutasi</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="mutasi_no_trans" id="mutasi_no_trans" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tgl Mutasi</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="mutasi_tgl" id="mutasi_tgl" readonly>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Bintex Mutasi</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="mutasi_no_bintex" id="mutasi_no_bintex" readonly>
                    </div>
                </div> --}}

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">MUTASI RAK</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>No Trans Mutasi</th>
                                <th>Tgl Mutasi</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Rak Asal</th>
                                <th>Rak Tujuan</th>
                                <th>No Bintex Mutasi</th>
                            </tr>
                        </thead>
                        <tbody id="tbMutasiRak">
                        </tbody>
                    </table>
                </div>

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">PENGELUARAN KAIN</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>No Req</th>
                                <th>Tgl Request</th>
                                <th>No BPPB</th>
                                <th>Tgl BPPB</th>
                                <th>Tujuan</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>No WS Aktual</th>
                            </tr>
                        </thead>
                        <tbody id="tbPengeluaranKain">
                        </tbody>
                    </table>
                </div>

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">PENERIMAAN CUTTING</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Tgl Terima</th>
                                <th>Barcode</th>
                                <th>Qty Out</th>
                                <th>Unit</th>
                                <th>Qty Konv</th>
                                <th>Unit Konv</th>
                                <th>No Req</th>
                                <th>No BPPB</th>
                                <th>Tgl BPPB</th>
                                <th>Tujuan</th>
                                <th>No WS</th>
                                <th>No WS Act</th>
                                <th>ID Item</th>
                                <th>Style</th>
                                <th>Warna</th>
                                <th>No Lot</th>
                                <th>No Roll</th>
                                <th>No Roll Buyer</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody id="tbPenerimaanCutting">
                        </tbody>
                    </table>
                </div>

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">PEMAKAIAN KAIN</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Tgl Spreading</th>
                                <th>No Form</th>
                                <th>Worksheet</th>
                                <th>Group</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Tot Pemakaian</th>
                                <th>Reject</th>
                                <th>Sisa Kain</th>
                                <th>Short Roll</th>
                                <th>% Short Roll</th>
                                <th>Operator</th>
                            </tr>
                        </thead>
                        <tbody id="tbPemakaianKain">
                        </tbody>
                    </table>
                </div>

                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">RETURN KAIN</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>No BPB</th>
                                <th>Tgl BPB</th>
                                <th>Qty Return</th>
                                <th>Unit</th>
                                <th>No Bintex Return</th>
                            </tr>
                        </thead>
                        <tbody id="tbReturnKain">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(async function() {
            $('#scan-qr-header').on('expanded.lte.cardwidget', () => {
                document.getElementById("txtqr").focus();
                $("#txtqr").val('');

                initScanNimiq();
            });

            $(document).ready(function() {
                scanqr();
            })
        })

        // Scan QR Module :
        // Variable List :
        var html5QrcodeScanner = null;

        // Function List :
        // -Initialize Scanner-
        async function initScan() {
            if (document.getElementById("reader_s")) {
                if (html5QrcodeScanner) {
                    await html5QrcodeScanner.clear();
                }

                function onScanSuccess(decodedText, decodedResult) {
                    // handle the scanned code as you like, for example:
                    console.log(`Code matched = ${decodedText}`, decodedResult);

                    // store to input text
                    // let breakDecodedText = decodedText.split('-');

                    document.getElementById('txtqr').value = decodedText;

                    scanqr();

                    html5QrcodeScanner.clear();

                    $("#scan-qr-header").CardWidget('collapse');

                }

                function onScanFailure(error) {
                    // handle scan failure, usually better to ignore and keep scanning.
                    // for example:
                    console.warn(`Code scan error = ${error}`);
                }

                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader_s", {
                        fps: 120,
                        qrbox: {
                            width: 150,
                            height: 100
                        },
                        rememberLastUsedCamera: true,
                        aspectRatio: 1.7777778,
                        useBarCodeDetectorIfSupported: true,
                        showTorchButtonIfSupported: true,
                        showZoomSliderIfSupported: true,
                        defaultZoomValueIfSupported: 1,
                    },
                    /* verbose= */
                    false);

                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }
        }

        async function initScanNimiq() {
            const nimiqScanner = await import('{{ asset('plugins/js/nimiq-scan.js') }}');

            await nimiqScanner.initScanNimiq(document.getElementById('scan-qr-nimic'), document.getElementById('txtqr'));
        }

        $("#txtqr").on("change", () => {
            if ($("#txtqr").val()) {
                scanqr();
            }
        });

        let ajaxDone = 0;
        let totalAjax = 8; 
        let isProcessing = false;

        async function scanqr() {
            if (isProcessing) return;
            isProcessing = true;

            $('#loading').removeClass('d-none');
            ajaxDone = 0;

            let txtqr = $("#txtqr").val();

            if (txtqr == '') {
                $('#loading').addClass('d-none');
                isProcessing = false;
                return;
            }

            $('#label_kode_numbering').text("Kode Barcode Bintex : " + txtqr);

            getData(txtqr);
            getDataPenerimaanKain(txtqr);
            getDataFabricInspection(txtqr);
            getDataMutasiRak(txtqr);
            getDataPengeluaranKain(txtqr);
            getDataPenerimaanCutting(txtqr);
            getDataPemakaianKain(txtqr);
            getDataReturnKain(txtqr);
        }

        function getData(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getData') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    $("#detail_id_item").val(response.id_item);
                    $("#detail_nama_item").val(response.item_desc);
                    $("#detail_supplier").val(response.supplier);
                    $("#detail_buyer").val(response.buyer);
                    $("#detail_worksheet").val(response.worksheet);
                    $("#detail_style").val(response.style);
                    $("#detail_color_item").val(response.color);
                    $("#detail_color_garment").val(response.color_gmt);
                    $("#detail_lot").val(response.no_lot);
                    $("#detail_no_roll").val(response.no_roll);
                    $("#detail_no_roll_buyer").val(response.no_roll_buyer);
                    $("#detail_ukuran").val(response.ukuran);
                    $("#detail_qty_awal").val(response.qty);
                    $("#detail_satuan_qty_awal").val(response.unit);
                    if (response.unit == 'YRD' || response.unit == 'YARD') {
                        $('#detail_qty_akhir').val((response.qty * 0.9144).toFixed(2));
                        $('#detail_satuan_qty_akhir').val('METER');
                    } else {
                        $('#detail_qty_akhir').val(response.qty);
                        $('#detail_satuan_qty_akhir').val(response.unit);
                    }

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data detail.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataPenerimaanKain(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataPenerimaanKain') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    $("#penerimaan_no_bpb").val(response.no_bpb);
                    $("#penerimaan_tgl_bpb").val(response.tgl_bpb);
                    $("#penerimaan_no_packing_list").val(response.no_packing_list);
                    $("#penerimaan_lokasi").val(response.lokasi);
                    $("#penerimaan_tipe").val(response.tipe);

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data penerimaan kain.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataFabricInspection(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataFabricInspection') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    $("#fabric_inspect_result").val(response.result);
                    $("#fabric_tgl_inspect").val(response.tgl_form);
                    $("#fabric_mesin_inspect").val(response.no_mesin);
                    $("#fabric_grouping_result").val(response.group);
                    $("#fabric_tgl_grouping").val(response.tgl_group);
                    $("#fabric_grouping_user").val(response.grouping_user);
                    $("#fabric_start_relax").val(response.start_form);
                    $("#fabric_finish_relax").val(response.finish_form);
                    $("#fabric_mesin_relax").val(response.no_mesin_relax);

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data fabric inspection.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataMutasiRak(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataMutasiRak') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    let tbMutasiRak = $('#tbMutasiRak');
                    tbMutasiRak.empty();

                    const safe = val => (val !== null && val !== undefined && val !== '' ? val : '-');

                    if (!response || response.length === 0) {
                        tbMutasiRak.append(`
                            <tr>
                                <td colspan="7" style="text-align:center;">Tidak ada data</td>
                            </tr>
                        `);
                    } else {
                        $.each(response, function(index, item) {
                            tbMutasiRak.append(`
                                <tr>
                                    <td>${safe(item.no_mut)}</td>
                                    <td>${safe(item.tgl_mut)}</td>
                                    <td class="text-end">${safe(item.qty_mutasi)}</td>
                                    <td>${safe(item.unit)}</td>
                                    <td>${safe(item.rak_asal)}</td>
                                    <td>${safe(item.rak_tujuan)}</td>
                                    <td>${safe(item.idbpb_det)}</td>
                                </tr>
                            `);
                        });
                    }

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data mutasi rak.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataPengeluaranKain(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataPengeluaranKain') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    let tbPengeluaran = $('#tbPengeluaranKain');
                    tbPengeluaran.empty();

                    const safe = val => (val !== null && val !== undefined && val !== '' ? val : '-');

                    if (!response || response.length === 0) {
                        tbPengeluaran.append(`
                            <tr>
                                <td colspan="8" style="text-align:center;">Tidak ada data</td>
                            </tr>
                        `);
                    } else {
                        $.each(response, function(index, item) {
                            tbPengeluaran.append(`
                                <tr>
                                    <td>${safe(item.no_req)}</td>
                                    <td>${safe(item.tanggal_request)}</td>
                                    <td>${safe(item.no_bppb)}</td>
                                    <td>${safe(item.tanggal_bppb)}</td>
                                    <td>${safe(item.tujuan)}</td>
                                    <td class="text-end">${safe(item.qty)}</td>
                                    <td>${safe(item.unit)}</td>
                                    <td>${safe(item.no_ws_aktual)}</td>
                                </tr>
                            `);
                        });
                    }

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data pengeluaran kain.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataPenerimaanCutting(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataPenerimaanCutting') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {
                    console.log(response)

                    let tbPenerimaanCutting = $('#tbPenerimaanCutting');
                    tbPenerimaanCutting.empty();

                    const safe = val => (val !== null && val !== undefined && val !== '' ? val : '-');

                    if (!response || response.length === 0) {
                        tbPenerimaanCutting.append(`
                            <tr>
                                <td colspan="9" style="text-align:center;">Tidak ada data</td>
                            </tr>
                        `);
                    } else {
                        $.each(response, function(index, item) {
                            tbPenerimaanCutting.append(`
                                <tr>
                                    <td>${safe(item.tanggal_terima)}</td>
                                    <td>${safe(item.barcode)}</td>
                                    <td class="text-end">${safe(item.qty_out)}</td>
                                    <td>${safe(item.unit)}</td>
                                    <td class="text-end">${safe(item.qty_konv)}</td>
                                    <td>${safe(item.unit_konv)}</td>
                                    <td>${safe(item.no_req)}</td>
                                    <td>${safe(item.no_bppb)}</td>
                                    <td>${safe(item.tanggal_bppb)}</td>
                                    <td>${safe(item.tujuan)}</td>
                                    <td>${safe(item.no_ws)}</td>
                                    <td>${safe(item.no_ws_act)}</td>
                                    <td>${safe(item.id_item)}</td>
                                    <td>${safe(item.style)}</td>
                                    <td>${safe(item.warna)}</td>
                                    <td>${safe(item.no_lot)}</td>
                                    <td class="text-end">${safe(item.no_roll)}</td>
                                    <td class="text-end">${safe(item.no_roll_buyer)}</td>
                                    <td>${safe(item.user)}</td>
                                </tr>
                            `);
                        });
                    }

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data pengeluaran kain.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataPemakaianKain(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataPemakaianKain') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    let tbPemakaian = $('#tbPemakaianKain');
                    tbPemakaian.empty();

                    const safe = val => (val !== null && val !== undefined && val !== '' ? val : '-');

                    if (!response || response.length === 0) {
                        tbPemakaian.append(`
                            <tr>
                                <td colspan="12" style="text-align:center;">Tidak ada data</td>
                            </tr>
                        `);
                    } else {
                        $.each(response, function(index, item) {
                            tbPemakaian.append(`
                                <tr>
                                    <td>${formatDate(item.created_at)}</td>
                                    <td>${safe(item.no_form_cut_input)}</td>
                                    <td>${safe(item.act_costing_ws)}</td>
                                    <td>${safe(item.group_roll)}</td>
                                    <td class="text-end">${safe(item.qty_awal)}</td>
                                    <td>${safe(item.unit_roll)}</td>
                                    <td class="text-end">${safe(item.total_pemakaian_roll)}</td>
                                    <td class="text-end">${safe(item.reject)}</td>
                                    <td class="text-end">${safe(item.sisa_kain)}</td>
                                    <td class="text-end">${safe(Number(item.short_roll).toFixed(2))}</td>
                                    <td class="text-end">${safe(Number(item.short_roll_percentage).toFixed(2))}</td>
                                    <td>${safe(item.operator)}</td>
                                </tr>
                            `);
                        });
                    }

                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data pemakaian kain.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function getDataReturnKain(txtqr) {
            $('#loading').removeClass('d-none');

            $.ajax({
                type: "GET",
                url: '{{ route('getDataReturnKain') }}',
                data: { txtqr: txtqr },
                dataType: 'json',
                success: function(response) {

                    let tbReturnKain = $('#tbReturnKain');
                    tbReturnKain.empty();

                    const safe = val => (val !== null && val !== undefined && val !== '' ? val : '-');

                    if (!response || response.length === 0) {
                        tbReturnKain.append(`
                            <tr>
                                <td colspan="5" style="text-align:center;">Tidak ada data</td>
                            </tr>
                        `);
                    } else {
                        $.each(response, function(index, item) {
                            tbReturnKain.append(`
                                <tr>
                                    <td>${safe(item.no_bpb)}</td>
                                    <td>${safe(item.tgl_bpb)}</td>
                                    <td class="text-end">${safe(item.qty)}</td>
                                    <td>${safe(item.unit)}</td>
                                    <td>${safe(item.no_bintex_return)}</td>
                                </tr>
                            `);
                        });
                    }


                    handleAjaxDone();
                },
                error: function(request, status, error) {
                    handleAjaxDone();

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan saat menarik data return kain.',
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                },
            });
        }

        function handleAjaxDone() {
            ajaxDone++;

            if (ajaxDone === totalAjax) {
                $('#scan-qr-header').CardWidget('toggle');
                $('#loading').addClass('d-none');
                isProcessing = false;
            }
        }

        function formatDate(dateString) {
            if (!dateString) return '-';

            let date = new Date(dateString);

            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();

            return `${day}-${month}-${year}`;
        }
    </script>
@endsection
