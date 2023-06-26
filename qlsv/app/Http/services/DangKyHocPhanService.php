<?php

namespace App\Http\Services;

use App\Models\dkhocphan;
use App\Models\LopMonHoc;
use Illuminate\Support\Facades\DB;

class DangKyHocPhanService
{
    public function getClass()
    {
        $data = DB::select("select * from lop_mon_hocs");
        //return $data;
        return LopMonHoc::all();
    }
    // Phương thức đếm số lượng sinh viên đăng ký lớp môn học có id = $idlop
    public function countWhereIdLop($idlop)
    {
        $count = DB::table('dkhocphans')
            ->where('idlop', '=', $idlop)
            ->count();
        return $count;
    }
    // Phương thức lấy ra số lượng sinh viên max trong lớp môn học có id = $idlop
    public  function totalAll($idlop)
    {
        $soluongsv = LopMonHoc::where('id', '=', $idlop)->value('soluongsv');
        return $soluongsv;
    }
    public function checkmany($request)
    {
        $idsv = $request->input('idsv');
        $idlop = $request->input('idlop');

        $arr = explode(",", $idsv);
        $countAdd = count($arr); // Lấy ra số lượng bản ghi muốn thêm hàng loạt

        // Lấy ra số lượng sinh viên cho phép thêm vào lớp môn học có id = $idlop
        $soluongsv = LopMonHoc::where('id', '=', $idlop)->value('soluongsv');
        // Số sinh viên đã đăng ký vào lớp môn học có id = $idlop
        $count = DB::table('dkhocphans')
            ->where('idlop', '=', $idlop)
            ->count();
        $check = $soluongsv - $count;
        if ($check > 0) {
            if (($check - $countAdd) >= 0) {
                foreach ($arr as $sv) {
                    try {
                        DB::table("dkhocphans")
                            ->insert([
                                'idsv' => $sv,
                                'idlop' =>  $idlop
                            ]);
                    }
                    //xử lý exception, nếu có exception thì lấy ra message và hiển thị ra màn hình.
                    catch (\Exception $ex) {
                        return -1;
                    }
                }
                return 0;
            } else {
                return $check;
            }
        } else {
            return -2;
        }
    }
    public function check($request)
    {
        $idsv = $request->input('idsv');
        $idlop = $request->input('idlop');

        $soluongsv = LopMonHoc::where('id', '=', $idlop)->value('soluongsv');
        $count = DB::table('dkhocphans')
            ->where('idlop', '=', $idlop)
            ->count();
        $check = $soluongsv - $count;
        if ($check > 0) {
            return $this->create($idsv, $idlop);
        } else {
            return -1;
        }
    }
    public function create($idsv, $idlop)
    {
        // $idsv = $request->input('idsv');
        // $idlop = $request->input('idlop');

        try {
            DB::table("dkhocphans")
                ->insert([
                    'idsv' => $idsv,
                    'idlop' =>  $idlop
                ]);
            return 1;
        }
        //xử lý exception, nếu có exception thì lấy ra message và hiển thị ra màn hình.
        catch (\Exception $ex) {
            return 0;
        }
        return 1;
    }

    public function getAll($search = null, $optionSearch = null, $perPage = 5, $idlop)
    {
        // 
        $query = DB::table('sinh_viens as sv')
            ->join('lop_quan_lies as lql', 'sv.class_id', '=', 'lql.id')
            ->leftJoin('dkhocphans as c', function ($join) use ($idlop) {
                $join->on('sv.id', '=', 'c.idsv')
                    ->where('c.idlop', '=', $idlop);
            })
            ->select('sv.*', 'lql.tenlop')
            ->whereNull('c.idsv');

        if ($search) {
            if ($optionSearch == "mssv") {
                $query->where('sv.mssv', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "name") {
                $query->where('sv.name', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "tenlop") {
                $query->where('lql.tenlop', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "phone") {
                $query->where('sv.phone', 'LIKE', "%{$search}%");
            }
        }
        return $query->paginate($perPage);
    }

    public function getAll2($search = null, $optionSearch = null, $perPage = 5, $idlop)
    {
        $query = DB::table('sinh_viens as sv')
            ->join('lop_quan_lies as lql', 'sv.class_id', '=', 'lql.id')
            ->join('dkhocphans as c', 'sv.id', '=', 'c.idsv')
            ->join('lop_mon_hocs as lmh', function ($join) use ($idlop) {
                $join->on('c.idlop', '=', 'lmh.id')
                    ->where('c.idlop', '=', $idlop);
            })
            ->select('sv.*', 'lql.tenlop', 'c.id as iddk');

        if ($search) {
            if ($optionSearch == "mssv") {
                $query->where('sv.mssv', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "name") {
                $query->where('sv.name', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "tenlop") {
                $query->where('lql.tenlop', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "phone") {
                $query->where('sv.phone', 'LIKE', "%{$search}%");
            }
        }
        return $query->paginate($perPage);
    }

    public function delete($request)
    {
        $data = dkhocphan::where('id', $request->input('id'));
        if ($data) {
            return $data->delete();
        }
        return false;
    }
    public function deletemany($request)
    {
        $data = dkhocphan::whereIn('id', explode(',', $request->input('ids')));
        if ($data) {
            return $data->delete();
        }
        return false;
    }
}
