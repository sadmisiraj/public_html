<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export payment logs to Excel
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPaymentExcel(Request $request)
    {
        // Get filtered deposit IDs or get all if no filters
        $query = $this->getFilteredDeposits($request);
        $deposits = $query->get()->map(function ($item) {
            return $this->formatDepositForExport($item);
        })->toArray();

        $data = $deposits;
        $fileName = 'Payment_Details_' . now()->format('Y-m-d') . '.xlsx';
        $headers = array_keys($data[0] ?? []);
        
        if (empty($data)) {
            return back()->with('error', 'No data to export');
        }
        
        $export = new ReportExport($data, $headers);
        return Excel::download($export, $fileName);
    }

    /**
     * Export payment logs to PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportPaymentPdf(Request $request)
    {
        // Get filtered deposit IDs or get all if no filters
        $query = $this->getFilteredDeposits($request);
        $deposits = $query->get()->map(function ($item) {
            return $this->formatDepositForExport($item);
        })->toArray();

        if (empty($deposits)) {
            return back()->with('error', 'No data to export');
        }

        $data = [
            'deposits' => $deposits,
            'headers' => array_keys($deposits[0]),
            'title' => 'Payment Details',
            'date' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = Pdf::loadView('admin.exports.payment_pdf', $data);
        return $pdf->download('Payment_Details_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export payout logs to Excel
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPayoutExcel(Request $request)
    {
        // Get filtered payout IDs or get all if no filters
        $query = $this->getFilteredPayouts($request);
        $payouts = $query->get()->map(function ($item) {
            return $this->formatPayoutForExport($item);
        })->toArray();

        $data = $payouts;
        $fileName = 'Payout_Details_' . now()->format('Y-m-d') . '.xlsx';
        $headers = array_keys($data[0] ?? []);
        
        if (empty($data)) {
            return back()->with('error', 'No data to export');
        }
        
        $export = new ReportExport($data, $headers);
        return Excel::download($export, $fileName);
    }

    /**
     * Export payout logs to PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportPayoutPdf(Request $request)
    {
        // Get filtered payout IDs or get all if no filters
        $query = $this->getFilteredPayouts($request);
        $payouts = $query->get()->map(function ($item) {
            return $this->formatPayoutForExport($item);
        })->toArray();

        if (empty($payouts)) {
            return back()->with('error', 'No data to export');
        }

        $data = [
            'payouts' => $payouts,
            'headers' => array_keys($payouts[0]),
            'title' => 'Payout Details',
            'date' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = Pdf::loadView('admin.exports.payout_pdf', $data);
        return $pdf->download('Payout_Details_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Apply filters to deposits query
     * 
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getFilteredDeposits(Request $request)
    {
        $filterTransactionId = $request->filterTransactionID;
        $filterStatus = $request->filterStatus;
        $filterMethod = $request->filterMethod;

        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0] ?? null;
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $query = Deposit::query()
            ->with(['user:id,username,firstname,lastname', 'gateway:id,name'])
            ->whereHas('user')
            ->whereHas('gateway')
            ->orderBy('id', 'desc')
            ->where('status', '!=', 0)
            ->when(!empty($filterTransactionId), function ($query) use ($filterTransactionId) {
                return $query->where('trx_id', $filterTransactionId);
            })
            ->when(isset($filterStatus) && $filterStatus != 'all', function ($query) use ($filterStatus) {
                return $query->where('status', $filterStatus);
            })
            ->when(isset($filterMethod) && $filterMethod != 'all', function ($query) use ($filterMethod) {
                return $query->whereHas('gateway', function ($subQuery) use ($filterMethod) {
                    $subQuery->where('id', $filterMethod);
                });
            })
            ->when(!empty($startDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($startDate) && !empty($endDate), function ($query) use ($startDate, $endDate) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            });

        return $query;
    }

    /**
     * Format deposit data for export
     * 
     * @param Deposit $item
     * @return array
     */
    private function formatDepositForExport($item)
    {
        $status = 'Unknown';
        if ($item->status == 0) {
            $status = trans('Pending');
        } else if ($item->status == 1) {
            $status = trans('Successful');
        } else if ($item->status == 2) {
            $status = trans('Pending');
        } else if ($item->status == 3) {
            $status = trans('Cancel');
        }

        return [
            'Transaction ID' => $item->trx_id,
            'Name' => optional($item->user)->firstname . ' ' . optional($item->user)->lastname,
            'Method' => optional($item->gateway)->name,
            'Amount' => fractionNumber(getAmount($item->amount)) .' ' . $item->payment_method_currency,
            'Charge' => fractionNumber(getAmount($item->percentage_charge) + getAmount($item->fixed_charge)) . ' ' . $item->payment_method_currency,
            'Payable Amount' => currencyPosition($item->payable_amount_in_base_currency),
            'Status' => $status,
            'Date' => dateTime($item->created_at),
        ];
    }

    /**
     * Apply filters to payouts query
     * 
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getFilteredPayouts(Request $request)
    {
        $filterTransactionId = $request->filterTransactionID;
        $filterStatus = $request->filterStatus;
        $filterMethod = $request->filterMethod;

        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0] ?? null;
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $query = \App\Models\Payout::query()
            ->with(['user:id,username,firstname,lastname', 'method:id,name'])
            ->whereHas('user')
            ->whereHas('method')
            ->orderBy('id', 'desc')
            ->where('status', '!=', 0)
            ->when(!empty($filterTransactionId), function ($query) use ($filterTransactionId) {
                return $query->where('trx_id', $filterTransactionId);
            })
            ->when(isset($filterStatus) && $filterStatus != 'all', function ($query) use ($filterStatus) {
                return $query->where('status', $filterStatus);
            })
            ->when(isset($filterMethod) && $filterMethod != 'all', function ($query) use ($filterMethod) {
                return $query->whereHas('method', function ($subQuery) use ($filterMethod) {
                    $subQuery->where('id', $filterMethod);
                });
            })
            ->when(!empty($startDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($startDate) && !empty($endDate), function ($query) use ($startDate, $endDate) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            });

        return $query;
    }

    /**
     * Format payout data for export
     * 
     * @param \App\Models\Payout $item
     * @return array
     */
    private function formatPayoutForExport($item)
    {
        $status = 'Unknown';
        if ($item->status == 0) {
            $status = trans('Pending');
        } else if ($item->status == 1) {
            $status = trans('Pending');
        } else if ($item->status == 2) {
            $status = trans('Successful');
        } else if ($item->status == 3) {
            $status = trans('Cancel');
        }

        return [
            'Transaction ID' => $item->trx_id,
            'Name' => optional($item->user)->firstname . ' ' . optional($item->user)->lastname,
            'Method' => optional($item->method)->name,
            'Amount' => fractionNumber(getAmount($item->amount)) .' ' . $item->payout_currency_code,
            'Charge' => fractionNumber(getAmount($item->charge)) . ' ' . $item->payout_currency_code,
            'Payout Amount' => currencyPosition($item->amount_in_base_currency),
            'Status' => $status,
            'Date' => dateTime($item->created_at),
        ];
    }

    /**
     * Export transaction logs to Excel
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportTransactionExcel(Request $request)
    {
        // Get filtered transactions
        $query = $this->getFilteredTransactions($request);
        $transactions = $query->get()->map(function ($item) {
            return $this->formatTransactionForExport($item);
        })->toArray();

        $data = $transactions;
        $fileName = 'Transaction_Details_' . now()->format('Y-m-d') . '.xlsx';
        $headers = array_keys($data[0] ?? []);
        
        if (empty($data)) {
            return back()->with('error', 'No data to export');
        }
        
        $export = new ReportExport($data, $headers);
        return Excel::download($export, $fileName);
    }

    /**
     * Export transaction logs to PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportTransactionPdf(Request $request)
    {
        // Get filtered transactions
        $query = $this->getFilteredTransactions($request);
        $transactions = $query->get()->map(function ($item) {
            return $this->formatTransactionForExport($item);
        })->toArray();

        if (empty($transactions)) {
            return back()->with('error', 'No data to export');
        }

        $data = [
            'transactions' => $transactions,
            'headers' => array_keys($transactions[0]),
            'title' => 'Transaction Details',
            'date' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = Pdf::loadView('admin.exports.transaction_pdf', $data);
        return $pdf->download('Transaction_Details_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Apply filters to transactions query
     * 
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getFilteredTransactions(Request $request)
    {
        $filterTransactionId = $request->filterTransactionID;

        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0] ?? null;
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $query = \App\Models\Transaction::query()
            ->with(['user:id,username,firstname,lastname'])
            ->whereHas('user')
            ->orderBy('id', 'desc')
            ->when(!empty($filterTransactionId), function ($query) use ($filterTransactionId) {
                return $query->where('trx_id', $filterTransactionId);
            })
            ->when(!empty($startDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($startDate) && !empty($endDate), function ($query) use ($startDate, $endDate) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            });

        return $query;
    }

    /**
     * Format transaction data for export
     * 
     * @param \App\Models\Transaction $item
     * @return array
     */
    private function formatTransactionForExport($item)
    {
        return [
            'Transaction ID' => $item->trx_id,
            'User' => optional($item->user)->firstname . ' ' . optional($item->user)->lastname,
            'Amount' => $item->trx_type . ' ' . currencyPosition(getAmount($item->amount)),
            'Charge' => currencyPosition(getAmount($item->charge)),
            'Remarks' => $item->remarks,
            'Date' => dateTime($item->created_at),
        ];
    }
} 