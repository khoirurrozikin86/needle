<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use Illuminate\Support\Carbon;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function Addtransaction(){
        return view('transaction.add_transaction');
    }
    public function Addtransactionout(){
        return view('transaction.add_transactionout');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function Alltransaction()
    {   
  
        $transaction = Transaction::with('employee')->latest()->get();

        return view('transaction.all_transaction',compact('transaction'));
    }



    public function GetTransactionIN()
    {
        // Hitung jumlah total karyawan
        // $in = Transaction::where('type1', 'IN')->count();

        // Get today's date

        try {
            // Get today's date
            $today = Carbon::today();
    
            // Count the number of transactions with type "IN" for today
            $inTodayCount = Transaction::where('type1', 'IN')
                                        ->whereDate('created_at', $today)
                                        ->count();
    
            // Return the total count of "IN" transactions for today as a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Total "IN" count for today retrieved successfully',
                'data' => [
                    'in' => $inTodayCount
                ]
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'success' => false,
                'message' => 'Error fetching "IN" count for today: ' . $e->getMessage()
            ]);
        }
    }



    
    public function GetTransactionOUT()
    {
        try {
            // Get today's date
            $today = Carbon::today();
    
            // Count the number of transactions with type "IN" for today
            $inTodayCount = Transaction::where('type2', 'OUT')
                                        ->whereDate('updated_at', $today)
             							->whereDate('created_at', $today)
                                        ->count();
    
            // Return the total count of "IN" transactions for today as a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Total "OUT" count for today retrieved successfully',
                'data' => [
                    'out' => $inTodayCount
                ]
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'success' => false,
                'message' => 'Error fetching "IN" count for today: ' . $e->getMessage()
            ]);
        }
    }
    public function GetTransactionSTAY()
    {
        // Hitung jumlah total karyawan
        $stay = Transaction::where('remark', 'IN')->count();

        // Return the total employee count as a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Total in count retrieved successfully',
            'data' => [
                'stay' => $stay
            ]
        ]);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeTransaction(Request $request)
{
    $request->validate([
        'employee_id' => 'required', // Validasi bahwa employee_id diharapkan dari request
    ]);

    // Membuat nomor transaksi
    $lastTransaction = Transaction::latest()->first();
    $nextId = $lastTransaction ? $lastTransaction->id + 1 : 1;
    $currentYear = date('Y'); // Get the current year
	$noTrx = 'TRX-' . $currentYear . sprintf('%010d', $nextId);

    if ($request->types == "IN" || $request->types == "in") {
        // Periksa apakah sudah ada transaksi IN yang belum di-close dengan OUT untuk NIK yang sama
        $existingTransaction = Transaction::where('nik', $request->employee_id)
                                          ->where('remark', 'IN')
                                        //   ->whereNull('type2') 
                                          ->first();
        if ($existingTransaction) {
            // Jika ada, kirim response gagal untuk menghindari duplikasi
            return response()->json([
                'success' => false,
                'message' => 'Status masih IN!',
                'alert-type' => 'error'
            ]);
        }

        // Jika tidak ada transaksi IN yang terbuka, buat transaksi baru
        $transaction = Transaction::create([
            'no_trx' => $noTrx,
            'nik' => $request->employee_id,
            'type1' => 'IN',
            'type2' => '',
            'remark' => 'IN'
        ]);
    } elseif ($request->types == "OUT" || $request->types == "out") {
        // Jika types adalah OUT, update transaksi terakhir dengan status IN dan NIK yang sama
        $transaction = Transaction::where('nik', $request->employee_id)
                                  ->where('remark', 'IN')
                                  ->latest('id')
                                  ->first();

        if ($transaction) {
            // Update transaksi yang ditemukan dengan OUT
            $transaction->update([
                'type2' => 'OUT',
                'remark' => 'OUT'
            ]);
        } else {
            // Jika tidak ditemukan transaksi yang bisa diupdate, kirim error response
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada transaksi IN yang sesuai ditemukan untuk diupdate!',
                'alert-type' => 'error'
            ]);
        }
    }

    // Kirim response sukses jika semua proses di atas berjalan tanpa error
    return response()->json([
        'success' => true,
        'message' => 'Transaksi berhasil disimpan!',
        'data' => $transaction,
        'alert-type' => 'success'
    ]);
}

    public function storeTransactionold1(Request $request)
{
    $request->validate([
        'employee_id' => 'required', // Validasi bahwa employee_id diharapkan dari request
    ]);

    // Membuat nomor transaksi
    $lastTransaction = Transaction::latest()->first();
    $nextId = $lastTransaction ? $lastTransaction->id + 1 : 1;
    $noTrx = 'TRX-' . sprintf('%06d', $nextId);

    if ($request->types == "IN") {
        // Jika types adalah IN, buat transaksi baru
        $transaction = Transaction::create([
            'no_trx' => $noTrx,
            'nik' => $request->employee_id,
            'type1' => 'IN',
            'type2' => '',
            'remark' => 'IN'
        ]);
    } elseif ($request->types == "OUT") {
        // Jika types adalah OUT, update transaksi terakhir dengan status IN dan NIK yang sama
        $transaction = Transaction::where('nik', $request->employee_id)
                                  ->where('remark', 'IN')
                                  ->latest('id')
                                  ->first();

        if ($transaction) {
            // Update transaksi yang ditemukan dengan OUT
            $transaction->update([
                'type2' => 'OUT',
                'remark' => 'OUT'
            ]);
        } else {
            // Jika tidak ditemukan transaksi yang bisa diupdate, kirim error response
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada transaksi IN yang sesuai ditemukan untuk diupdate!',
                'alert-type' => 'error'
            ]);
        }
    }

    // Kirim response sukses jika semua proses di atas berjalan tanpa error
    return response()->json([
        'success' => true,
        'message' => 'Transaksi berhasil disimpan!',
        'data' => $transaction,
        'alert-type' => 'success'
    ]);
}

    public function StoreTransactionold(Request $request)
    {
        if( $request->types == "IN"){

            $request->validate([
              
                'employee_id' => 'required',
    
            ]);


            // Membuat nomor transaksi
             
                $lastTransaction = Transaction::latest()->first(); // Mendapatkan transaksi terakhir
                $nextId = $lastTransaction ? $lastTransaction->id + 1 : 1; // Menghitung ID berikutnya
                $noTrx = 'TRX-' . sprintf('%06d', $nextId); // Format nomor transaksi




            $post = Transaction::updateOrCreate([

                    'no_trx' => $noTrx,
                    'nik' => $request->employee_id,
                    'type1' => 'IN',
                    'type2' =>'',
                    'remark' => 'IN'
        
                ]);
        
    
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $post,
                    'alert-type' => 'success'  
                ]);
    

        }
        elseif ( $request->types == "OUT"){
            $request->validate([
               
                'employee_id' => 'required',
    
            ]);

            $post = Transaction::updateOrCreate([

   
                'id' => $request->types
        
                 ],[
                    'no_trx' => $noTrx,
                    'nik' => $request->nik,
                    'type1' => 'OUT',
                    'type2' =>'',
                    'remark' => 'OUT'
        
                ]);
        
        
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $post,
                    'alert-type' => 'success'  
                ]);
    
        }
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function Deletetransaction($id)
    {
        $del = Transaction::findOrFail($id)->delete();
       

        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);

    }


    public function Exporttransaction()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }



    public function exportPdf()
        {
            $transactions = Transaction::with('employee')->get();  // Ensure you have the employee relationship

            // Load a view for the PDF content
            $pdf = PDF::loadView('transaction.pdf', compact('transactions'));

            // Download the PDF file
            return $pdf->download('transactions.pdf');
        }

	public function Gettransactionfilter(Request $request)
{
   $startDate = Carbon::parse($request->start_date)->startOfDay();
    $endDate = Carbon::parse($request->end_date)->endOfDay();

    $transactions = Transaction::with('employee')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();

    return datatables()->of($transactions)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="#" class="dropdown-item text-danger" data-id="'.$row->id.'" id="deletes"><i class="feather-16" data-feather="trash-2"></i> &nbsp; Delete</a>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
}





}
