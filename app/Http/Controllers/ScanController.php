<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ScanController extends Controller
{
    public function index()
    {
        return view("production-qr");
    }

    public function getData(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::connection("mysql_sb")->select("
            SELECT
                whs_bppb_det.id_item,
                masteritem.id_gen,
                whs_bppb_det.item_desc,
                supp.supplier,
                buyer_ws.buyer,
                buyer_ws.no_ws AS worksheet,
                buyer_ws.styleno AS style,
                masteritem.color,
                COALESCE(gmt.color_gmt, masteritem.color) AS color_gmt,
                whs_bppb_det.no_lot,
                whs_bppb_det.no_roll,
                whs_lokasi_inmaterial.no_roll_buyer,
                masteritem.size AS ukuran,
                whs_bppb_det.qty_out AS qty,
                whs_bppb_det.satuan AS unit
            FROM whs_bppb_det
            LEFT JOIN whs_bppb_h
                ON whs_bppb_h.no_bppb = whs_bppb_det.no_bppb
            LEFT JOIN (
                SELECT no_barcode, id_item, no_roll_buyer
                FROM whs_lokasi_inmaterial
                WHERE no_barcode = ?
                GROUP BY no_barcode, no_roll_buyer
            ) whs_lokasi_inmaterial
                ON whs_lokasi_inmaterial.no_barcode = whs_bppb_det.id_roll
            LEFT JOIN masteritem
                ON masteritem.id_item = whs_lokasi_inmaterial.id_item
            LEFT JOIN bom_jo_item
                ON bom_jo_item.id_item = masteritem.id_gen
            LEFT JOIN so_det
                ON so_det.id = bom_jo_item.id_so_det
            LEFT JOIN so
                ON so.id = so_det.id_so
            LEFT JOIN act_costing
                ON act_costing.id = so.id_cost
            LEFT JOIN mastersupplier
                ON mastersupplier.Id_Supplier = act_costing.id_buyer
            LEFT JOIN (
                SELECT
                    jod.id_jo,
                    ac.kpno AS no_ws,
                    ac.styleno,
                    ms.supplier AS buyer
                FROM act_costing ac
                INNER JOIN mastersupplier ms
                    ON ms.id_supplier = ac.id_buyer
                INNER JOIN so
                    ON ac.id = so.id_cost
                INNER JOIN jo_det jod
                    ON so.id = jod.id_so
                GROUP BY jod.id_jo
            ) buyer_ws
                ON buyer_ws.id_jo = whs_bppb_det.id_jo
            LEFT JOIN (
                SELECT
                    k.id_item,
                    k.id_jo,
                    GROUP_CONCAT(DISTINCT sd.color) AS color_gmt
                FROM bom_jo_item k
                INNER JOIN so_det sd
                    ON sd.id = k.id_so_det
                WHERE k.status = 'M'
                AND k.cancel = 'N'
                GROUP BY k.id_item, k.id_jo
            ) gmt
                ON gmt.id_item = masteritem.id_gen
            LEFT JOIN(
                SELECT
                    whs_lokasi_inmaterial.no_barcode,
                    whs_inmaterial_fabric.supplier
                FROM whs_inmaterial_fabric
                INNER JOIN whs_lokasi_inmaterial ON whs_lokasi_inmaterial.no_dok = whs_inmaterial_fabric.no_dok
                WHERE whs_lokasi_inmaterial.no_barcode = ?
            ) supp ON supp.no_barcode = whs_bppb_det.id_roll
            WHERE whs_bppb_det.id_roll = ?
            GROUP BY whs_bppb_det.id_roll LIMIT 1
        ", [
            $request->txtqr,
            $request->txtqr,
            $request->txtqr
        ]);

        return response()->json($data[0] ?? [
            'id_item' => null,
            'id_gen' => null,
            'item_desc' => null,
            'supplier' => null,
            'buyer' => null,
            'worksheet' => null,
            'style' => null,
            'color' => null,
            'color_gmt' => null,
            'no_lot' => null,
            'no_roll' => null,
            'no_roll_buyer' => null,
            'ukuran' => null,
            'qty' => null,
            'unit' => null
        ]);

    }

    public function getDataPenerimaanKain(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::connection("mysql_sb")->select("
            SELECT DISTINCT
                whs_inmaterial_fabric.no_dok AS no_bpb,
                DATE_FORMAT(whs_inmaterial_fabric.tgl_dok, '%d-%m-%Y') AS tgl_bpb,
                whs_inmaterial_fabric.no_invoice AS no_packing_list,
                whs_lokasi_inmaterial.kode_lok AS lokasi,
                whs_inmaterial_fabric.type_pch AS tipe
            FROM
                whs_inmaterial_fabric
            INNER JOIN whs_lokasi_inmaterial ON whs_lokasi_inmaterial.no_dok = whs_inmaterial_fabric.no_dok
            WHERE whs_lokasi_inmaterial.no_barcode = ?
        ", [
            $request->txtqr
        ]);

        return response()->json($data[0] ?? [
            'no_bpb' => null,
            'tgl_bpb' => null,
            'no_packing_list' => null,
            'lokasi' => null,
            'tipe' => null,
            'supplier' => null
        ]);
    }

    public function getDataFabricInspection(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::connection("mysql_sb")->select("
            SELECT
                qc_inspect_form.result,
                DATE_FORMAT(qc_inspect_form.tgl_form, '%d-%m-%Y') AS tgl_form,
                qc_inspect_form.no_mesin,
                qc_inspect_shade_band.group,
                DATE_FORMAT(qc_inspect_shade_band.tgl_trans, '%d-%m-%Y') AS tgl_group,
                qc_inspect_shade_band.created_by AS grouping_user,
                qc_inspect_fabric_relaxation.start_form,
                qc_inspect_fabric_relaxation.finish_form,
                qc_inspect_fabric_relaxation.no_mesin AS no_mesin_relax
            FROM
                qc_inspect_form
            LEFT JOIN qc_inspect_fabric_relaxation ON qc_inspect_fabric_relaxation.barcode = qc_inspect_form.barcode
            LEFT JOIN qc_inspect_shade_band ON qc_inspect_shade_band.barcode = qc_inspect_form.barcode
            WHERE qc_inspect_form.barcode = ?
        ", [
            $request->txtqr
        ]);

        return response()->json($data[0] ?? [
            'result' => null,
            'tgl_form' => null,
            'no_mesin' => null,
            'group' => null,
            'tgl_group' => null,
            'grouping_user' => null,
            'start_form' => null,
            'finish_form' => null,
            'no_mesin_relax' => null
        ]);
    }

    public function getDataMutasiRak(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::connection("mysql_sb")->select("
            SELECT
                whs_mut_lokasi.no_mut,
                DATE_FORMAT(whs_mut_lokasi.tgl_mut, '%d-%m-%Y') AS tgl_mut,
                whs_mut_lokasi.qty_mutasi,
                whs_mut_lokasi.unit,
                whs_mut_lokasi.rak_asal,
                whs_mut_lokasi.rak_tujuan,
                whs_mut_lokasi.idbpb_det
            FROM
                whs_mut_lokasi
            WHERE whs_mut_lokasi.idbpb_det = ?
        ", [
            $request->txtqr
        ]);

        return json_encode($data);
    }

    public function getDataPengeluaranKain(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::connection("mysql_sb")
            ->table('whs_bppb_det')
            ->selectRaw("
                whs_bppb_h.no_req,
                DATE_FORMAT(whs_bppb_h.tgl_bppb, '%d-%m-%Y') AS tanggal_request,
                whs_bppb_det.no_bppb,
                DATE_FORMAT(whs_bppb_h.tgl_bppb, '%d-%m-%Y') AS tanggal_bppb,
                whs_bppb_h.tujuan,
                whs_bppb_det.qty_out AS qty,
                whs_bppb_det.satuan AS unit,
                whs_bppb_h.no_ws_aktual
            ")
            ->leftJoin('whs_bppb_h', 'whs_bppb_h.no_bppb', '=' ,'whs_bppb_det.no_bppb')
            ->where('whs_bppb_det.no_bppb', 'NOT LIKE', 'MT/%')
            ->where('whs_bppb_det.id_roll', $request->txtqr)
            ->get();

        return json_encode($data);
    }

    public function getDataPenerimaanCutting(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::table('penerimaan_cutting')
            ->selectRaw("
                penerimaan_cutting.id,
                DATE_FORMAT(penerimaan_cutting.tanggal_terima, '%d-%m-%Y') as tanggal_terima,
                penerimaan_cutting.id_roll AS barcode,
                penerimaan_cutting.created_by_username,
                DATE_FORMAT(penerimaan_cutting.created_at, '%d-%m-%Y %H:%i:%s') as created_at_format,
                whs_bppb_h.no_req,
                whs_bppb_det.no_bppb,
                whs_bppb_h.tgl_bppb AS tanggal_bppb,
                whs_bppb_h.tujuan,
                whs_bppb_h.no_ws,
                whs_bppb_h.no_ws_aktual AS no_ws_act,
                whs_bppb_det.qty_out,
                whs_bppb_det.satuan AS unit,
                penerimaan_cutting.qty_konv,
                penerimaan_cutting.unit_konv,
                whs_bppb_det.no_lot,
                whs_bppb_det.no_roll,
                whs_bppb_det.no_roll_buyer,
                whs_bppb_det.id_item,
                whs_bppb_det.item_desc AS nama_barang,
                buyer_ws.styleno AS style,
                masteritem.color AS warna,
                penerimaan_cutting.created_by_username AS user
            ")
            ->leftJoin('signalbit_erp.whs_bppb_det', 'signalbit_erp.whs_bppb_det.id', '=', 'penerimaan_cutting.whs_bppb_det_id')
            ->leftJoin('signalbit_erp.whs_bppb_h', 'signalbit_erp.whs_bppb_h.no_bppb', '=', 'signalbit_erp.whs_bppb_det.no_bppb')
            ->leftJoin('signalbit_erp.masteritem', 'signalbit_erp.masteritem.id_item', '=', 'signalbit_erp.whs_bppb_det.id_item')
            ->leftJoinSub(
                DB::table('signalbit_erp.act_costing as ac')
                    ->selectRaw('jod.id_jo, ac.kpno AS no_ws, ac.styleno')
                    ->join('signalbit_erp.so as so', 'ac.id', '=', 'so.id_cost')
                    ->join('signalbit_erp.jo_det as jod', 'so.id', '=', 'jod.id_so')
                    ->groupBy('jod.id_jo', 'ac.kpno', 'ac.styleno'),
                'buyer_ws',
                function ($join) {
                    $join->on('buyer_ws.id_jo', '=', 'signalbit_erp.whs_bppb_det.id_jo');
                }
            )
            ->where('penerimaan_cutting.id_roll', $request->txtqr)
            ->get();

            // LEFT JOIN bom_jo_item
            //     ON bom_jo_item.id_item = masteritem.id_gen
            // LEFT JOIN so_det
            //     ON so_det.id = bom_jo_item.id_so_det
            // LEFT JOIN so
            //     ON so.id = so_det.id_so
            // LEFT JOIN act_costing
            //     ON act_costing.id = so.id_cost

        return json_encode($data);
    }

    public function getDataPemakaianKain(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::select("
            select
                COALESCE(b.qty) qty_in,
                a.waktu_mulai,
                a.waktu_selesai,
                b.id,
                DATE_FORMAT(b.created_at, '%M') bulan,
                DATE_FORMAT(b.created_at, '%d-%m-%Y') tgl_input,
                b.no_form_cut_input,
                UPPER(meja.name) nama_meja,
                mrk.act_costing_ws,
                master_sb_ws.buyer,
                mrk.style,
                mrk.color,
                COALESCE(b.color_act, '-') color_act,
                mrk.panel,
                master_sb_ws.qty,
                cons_ws,
                cons_marker,
                a.cons_ampar,
                a.cons_act,
                (CASE WHEN a.cons_pipping > 0 THEN a.cons_pipping ELSE mrk.cons_piping END) cons_piping,
                panjang_marker,
                unit_panjang_marker,
                comma_marker,
                unit_comma_marker,
                lebar_marker,
                unit_lebar_marker,
                a.p_act panjang_actual,
                a.unit_p_act unit_panjang_actual,
                a.comma_p_act comma_actual,
                a.unit_comma_p_act unit_comma_actual,
                a.l_act lebar_actual,
                a.unit_l_act unit_lebar_actual,
                COALESCE(b.id_roll, '-') id_roll,
                b.id_item,
                b.detail_item,
                COALESCE(b.roll_buyer, b.roll) roll,
                COALESCE(b.lot, '-') lot,
                COALESCE(b.group_roll, '-') group_roll,
                (
                        CASE WHEN
                                b.status != 'extension' AND b.status != 'extension complete'
                        THEN
                                (CASE WHEN COALESCE(scanned_item.qty_in, b.qty) > b.qty AND c.id IS NULL THEN 'Sisa Kain' ELSE 'Roll Utuh' END)
                        ELSE
                                'Sambungan'
                        END
                ) status_roll,
                COALESCE(c.qty, b.qty) qty_awal,
                b.qty qty_roll,
                b.unit unit_roll,
                COALESCE(b.berat_amparan, '-') berat_amparan,
                b.est_amparan,
                b.lembar_gelaran,
                mrk.total_ratio,
                (mrk.total_ratio * b.lembar_gelaran) qty_cut,
                b.average_time,
                b.sisa_gelaran,
                b.sambungan,
                b.sambungan_roll,
                b.kepala_kain,
                b.sisa_tidak_bisa,
                b.reject,
                b.piping,
                ROUND(MIN(CASE WHEN b.status != 'extension' AND b.status != 'extension complete' THEN (b.sisa_kain) ELSE (b.qty - b.total_pemakaian_roll) END), 2) sisa_kain,
                ROUND((CASE WHEN b.status != 'extension complete' THEN ((CASE WHEN b.unit = 'KGM' THEN b.berat_amparan ELSE a.p_act + (a.comma_p_act/100) END) * b.lembar_gelaran) ELSE b.sambungan END) + (b.sisa_gelaran ) + (b.sambungan_roll ) , 2) pemakaian_lembar,
                ROUND((CASE WHEN b.status != 'extension complete' THEN ((CASE WHEN b.unit = 'KGM' THEN b.berat_amparan ELSE a.p_act + (a.comma_p_act/100) END) * b.lembar_gelaran) ELSE b.sambungan END) + (b.sisa_gelaran) + (b.sambungan_roll) + (b.kepala_kain) + (b.sisa_tidak_bisa) + (b.reject) + (b.piping), 2) total_pemakaian_roll,
                ROUND(((CASE WHEN b.status != 'extension complete' THEN ((CASE WHEN b.unit = 'KGM' THEN b.berat_amparan ELSE a.p_act + (a.comma_p_act/100) END) * b.lembar_gelaran) ELSE b.sambungan END) + (b.sisa_gelaran) + (b.sambungan_roll) + (b.kepala_kain) + (b.sisa_tidak_bisa) + (b.reject) + (b.piping))+(ROUND(MIN(CASE WHEN b.status != 'extension' AND b.status != 'extension complete' THEN (b.sisa_kain) ELSE (b.qty - b.total_pemakaian_roll) END), 2))-b.qty, 2) short_roll,
                ROUND((((CASE WHEN b.status != 'extension complete' THEN ((CASE WHEN b.unit = 'KGM' THEN b.berat_amparan ELSE a.p_act + (a.comma_p_act/100) END) * b.lembar_gelaran) ELSE b.sambungan END) + (b.sisa_gelaran) + (b.sambungan_roll) + (b.kepala_kain) + (b.sisa_tidak_bisa) + (b.reject) + (b.piping)+(ROUND(MIN(CASE WHEN b.status != 'extension' AND b.status != 'extension complete' THEN (b.sisa_kain) ELSE (b.qty - b.total_pemakaian_roll) END), 2)))-b.qty)/b.qty*100, 2) short_roll_percentage,
                b.status,
                a.operator,
                a.tipe_form_cut,
                b.created_at,
                b.updated_at,
                (CASE WHEN d.id is null and e.id is null THEN 'latest' ELSE 'not latest' END) roll_status
            from
                form_cut_input a
                left join form_cut_input_detail b on a.id = b.form_cut_id
                left join form_cut_input_detail c ON c.form_cut_id = b.form_cut_id and c.id_roll = b.id_roll and (c.status = 'extension' OR c.status = 'extension complete')
                LEFT JOIN form_cut_input_detail d on d.id_roll = b.id_roll AND b.id != d.id AND d.created_at > b.created_at
                LEFT JOIN form_cut_piping e on e.id_roll = b.id_roll AND e.created_at > b.created_at
                left join users meja on meja.id = a.no_meja
                left join (SELECT marker_input.*, SUM(marker_input_detail.ratio) total_ratio FROM marker_input LEFT JOIN marker_input_detail ON marker_input_detail.marker_id = marker_input.id GROUP BY marker_input.id) mrk on a.id_marker = mrk.kode
                left join (SELECT * FROM master_sb_ws GROUP BY id_act_cost) master_sb_ws on master_sb_ws.id_act_cost = mrk.act_costing_id
                left join scanned_item on scanned_item.id_roll = b.id_roll
            where
                (a.cancel = 'N'  OR a.cancel IS NULL)
                AND (mrk.cancel = 'N'  OR mrk.cancel IS NULL)
                AND a.status = 'SELESAI PENGERJAAN'
                and b.status != 'not complete'
                and b.id_item is not null
                and b.id_roll = ?
            group by
                b.id

            UNION ALL

            select
                COALESCE(form_cut_piping.qty) qty_in,
                form_cut_piping.created_at waktu_mulai,
                form_cut_piping.updated_at waktu_selesai,
                form_cut_piping.id,
                DATE_FORMAT(form_cut_piping.created_at, '%M') bulan,
                DATE_FORMAT(form_cut_piping.created_at, '%d-%m-%Y') tgl_input,
                'PIPING' no_form_cut_input,
                '-' nama_meja,
                form_cut_piping.act_costing_ws,
                master_sb_ws.buyer,
                form_cut_piping.style,
                form_cut_piping.color,
                form_cut_piping.color color_act,
                form_cut_piping.panel,
                master_sb_ws.qty,
                '0' cons_ws,
                0 cons_marker,
                '0' cons_ampar,
                0 cons_act,
                form_cut_piping.cons_piping cons_piping,
                0 panjang_marker,
                '-' unit_panjang_marker,
                0 comma_marker,
                '-' unit_comma_marker,
                0 lebar_marker,
                '-' unit_lebar_marker,
                0 panjang_actual,
                '-' unit_panjang_actual,
                0 comma_actual,
                '-' unit_comma_actual,
                0 lebar_actual,
                '-' unit_lebar_actual,
                form_cut_piping.id_roll,
                scanned_item.id_item,
                scanned_item.detail_item,
                COALESCE(scanned_item.roll_buyer, scanned_item.roll) roll,
                scanned_item.lot,
                '-' group_roll,
                'Piping' status_roll,
                COALESCE(scanned_item.qty_in, form_cut_piping.qty) qty_awal,
                form_cut_piping.qty qty_roll,
                form_cut_piping.unit unit_roll,
                0 berat_amparan,
                0 est_amparan,
                0 lembar_gelaran,
                0 total_ratio,
                0 qty_cut,
                '00:00' average_time,
                '0' sisa_gelaran,
                0 sambungan,
                0 sambungan_roll,
                0 kepala_kain,
                0 sisa_tidak_bisa,
                0 reject,
                form_cut_piping.piping piping,
                form_cut_piping.qty_sisa sisa_kain,
                form_cut_piping.piping pemakaian_lembar,
                form_cut_piping.piping total_pemakaian_roll,
                ROUND((form_cut_piping.piping + form_cut_piping.qty_sisa) - form_cut_piping.qty, 2) short_roll,
                ROUND(((form_cut_piping.piping + form_cut_piping.qty_sisa) - form_cut_piping.qty)/coalesce(scanned_item.qty_in, form_cut_piping.qty) * 100, 2) short_roll_percentage,
                null `status`,
                form_cut_piping.operator,
                'PIPING' tipe_form_cut,
                form_cut_piping.created_at,
                form_cut_piping.updated_at,
                (CASE WHEN c.id is null THEN 'latest' ELSE 'not latest' END) roll_status
            from
                form_cut_piping
                LEFT JOIN form_cut_input_detail b on b.id_roll = form_cut_piping.id_roll AND b.created_at > form_cut_piping.created_at
                LEFT JOIN form_cut_piping c on c.id_roll = form_cut_piping.id_roll AND c.id != form_cut_piping.id and c.created_at > form_cut_piping.created_at
                left join (SELECT * FROM master_sb_ws GROUP BY id_act_cost) master_sb_ws on master_sb_ws.id_act_cost = form_cut_piping.act_costing_id
                left join scanned_item on scanned_item.id_roll = form_cut_piping.id_roll
            where
                scanned_item.id_item is not null
                and form_cut_piping.id_roll = ?
            group by
                form_cut_piping.id

            UNION ALL

            SELECT
                form_cut_piece_detail.qty qty_in,
                form_cut_piece.created_at waktu_mulai,
                form_cut_piece.updated_at waktu_selesai,
                form_cut_piece.id,
                DATE_FORMAT( form_cut_piece.created_at, '%M' ) bulan,
                DATE_FORMAT( form_cut_piece.created_at, '%d-%m-%Y' ) tgl_input,
                form_cut_piece.no_form no_form_cut_input,
                '-' nama_meja,
                form_cut_piece.act_costing_ws,
                master_sb_ws.buyer,
                form_cut_piece.style,
                form_cut_piece.color,
                form_cut_piece.color color_act,
                form_cut_piece.panel,
                master_sb_ws.qty,
                form_cut_piece.cons_ws cons_ws,
                form_cut_piece.cons_ws cons_marker,
                '0' cons_ampar,
                0 cons_act,
                0 cons_piping,
                0 panjang_marker,
                '-' unit_panjang_marker,
                0 comma_marker,
                '-' unit_comma_marker,
                0 lebar_marker,
                '-' unit_lebar_marker,
                0 panjang_actual,
                '-' unit_panjang_actual,
                0 comma_actual,
                '-' unit_comma_actual,
                0 lebar_actual,
                '-' unit_lebar_actual,
                form_cut_piece_detail.id_roll,
                scanned_item.id_item,
                scanned_item.detail_item,
                COALESCE ( scanned_item.roll_buyer, scanned_item.roll ) roll,
                scanned_item.lot,
                '-' group_roll,
                ( CASE WHEN form_cut_piece_detail.qty >= COALESCE ( scanned_item.qty_in, 0 ) THEN 'Roll Utuh' ELSE 'Sisa Kain' END ) status_roll,
                COALESCE ( scanned_item.qty_in, form_cut_piece_detail.qty ) qty_awal,
                form_cut_piece_detail.qty qty_roll,
                form_cut_piece_detail.qty_unit unit_roll,
                0 berat_amparan,
                0 est_amparan,
                0 lembar_gelaran,
                0 total_ratio,
                0 qty_cut,
                '00:00' average_time,
                '0' sisa_gelaran,
                0 sambungan,
                0 sambungan_roll,
                0 kepala_kain,
                0 sisa_tidak_bisa,
                0 reject,
                0 piping,
                form_cut_piece_detail.qty_sisa sisa_kain,
                form_cut_piece_detail.qty_pemakaian pemakaian_lembar,
                form_cut_piece_detail.qty_pemakaian total_pemakaian_roll,
                ROUND(
                form_cut_piece_detail.qty - ( form_cut_piece_detail.qty_pemakaian + form_cut_piece_detail.qty_sisa )) short_roll,
                ROUND((form_cut_piece_detail.qty - ( form_cut_piece_detail.qty_pemakaian + form_cut_piece_detail.qty_sisa ))/ COALESCE ( scanned_item.qty_in, form_cut_piece_detail.qty ) * 100, 2 ) short_roll_percentage,
                form_cut_piece_detail.STATUS `status`,
                form_cut_piece.employee_name,
                'PCS' tipe_form_cut,
                form_cut_piece.created_at,
                form_cut_piece.updated_at,
                (CASE WHEN b.id is null THEN 'latest' ELSE 'not latest' END) roll_status
            FROM
                form_cut_piece
                LEFT JOIN form_cut_piece_detail ON form_cut_piece_detail.form_id = form_cut_piece.id
                LEFT JOIN form_cut_piece_detail b on b.id_roll = form_cut_piece_detail.id_roll AND b.created_at > form_cut_piece_detail.created_at
                LEFT JOIN ( SELECT * FROM master_sb_ws GROUP BY id_act_cost ) master_sb_ws ON master_sb_ws.id_act_cost = form_cut_piece.act_costing_id
                LEFT JOIN scanned_item ON scanned_item.id_roll = form_cut_piece_detail.id_roll
            WHERE
                scanned_item.id_item IS NOT NULL
                and form_cut_piece_detail.id_roll = ?
                AND form_cut_piece_detail.STATUS = 'complete'
            GROUP BY
                form_cut_piece_detail.id
        ", [$request->txtqr, $request->txtqr, $request->txtqr]);

        return json_encode($data);
    }

    public function getDataReturnKain(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '1024M');

        $data = DB::connection("mysql_sb")->select("
            SELECT
                whs_lokasi_inmaterial.no_dok AS no_bpb,
                DATE_FORMAT(whs_inmaterial_fabric.tgl_dok, '%d-%m-%Y') AS tgl_bpb,
                whs_lokasi_inmaterial.qty_aktual AS qty,
		        whs_lokasi_inmaterial.satuan AS unit,
                whs_lokasi_inmaterial.no_barcode AS no_bintex_return
            FROM
                whs_lokasi_inmaterial
            LEFT JOIn whs_inmaterial_fabric ON whs_inmaterial_fabric.no_dok = whs_lokasi_inmaterial.no_dok
            WHERE
                whs_lokasi_inmaterial.no_dok LIKE 'GK/RI%'
                AND whs_lokasi_inmaterial.no_barcode = ?
            UNION

            SELECT
                whs_bppb_det.no_bppb AS no_bpb,
                DATE_FORMAT(whs_bppb_h.tgl_bppb, '%d-%m-%Y') AS tgl_bpb,
                whs_bppb_det.qty_out AS qty,
		        whs_bppb_det.satuan AS unit,
                whs_bppb_det.id_roll AS no_bintex_return
            FROM
                whs_bppb_det
            LEFT JOIN whs_bppb_h ON whs_bppb_h.no_bppb = whs_bppb_det.no_bppb
            WHERE
                whs_bppb_det.no_bppb LIKE 'GK/RO%'
                AND whs_bppb_det.id_roll = ?
        ", [
            $request->txtqr,
            $request->txtqr
        ]);

        return json_encode($data);
    }
}
