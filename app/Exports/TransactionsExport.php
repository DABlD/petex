<?php

namespace App\Exports;

use App\Models\Transactions;
use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionsExport implements FromCollection, ShouldAutoSize, WithEvents
{
    public function __construct($from, $to, $title){
        $this->from = $from;
        $this->to = $to;
        $this->title = $title;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$cols = [
    		'transactions.fname',
    		'transactions.lname',
    		'transactions.contact',
    		'transactions.address',
    		'transactions.price',
    		'transactions.status',
    		'transactions.comments',
    		'transactions.created_at',
    		'transactions.rating',
    		's.fname as sfname',
    		's.lname as slname',
    		's.contact as scontact',
    		'r.fname as rfname',
    		'r.lname as rlname',
    		'r.contact as rcontact',
    	];

    	$to = now()->parse($this->to)->toDateString();
    	$from = $this->from ? now()->parse($this->from)->toDateString() : $to;

        $transactions = Transactions::select($cols)
        	->whereIn('status', ['Delivered', 'Cancelled', 'Rider Cancel'])
        	// ->where('transactions.created_at', '>=', $this->from ? $this->from . " 00:00:00" : $this->to . " 00:00:00")
        	// ->where('transactions.created_at', '<=', $this->to . " 23:59:59")
        	->where([
        		['transactions.created_at', '>=', $from ? $from . " 00:00:00" : $to . " 00:00:00"],
        		['transactions.created_at', '<=', $to . " 23:59:59"],
        		['transactions.sid', 'LIKE', auth()->user()->role == "Seller" ? auth()->user()->id : '%']
        	])
        	->join('users as s', 's.id', '=', 'transactions.sid')
        	->join('users as r', 'r.id', '=', 'transactions.tid')
        	->get();

        $income = 0;
        $delivered = 0;
        $cancelled = 0;
        $riderCancel = 0;

        foreach($transactions as $transaction){
        	if($transaction->status == "Delivered"){
        		$income += floatval($transaction->price * .75);
        		$delivered++;
        	}
        	elseif($transaction->status == "Cancelled"){
        		$cancelled++;
        	}
        	elseif($transaction->status == "Rider Cancel"){
        		$riderCancel++;
        	}
        }

        $transactions = collect([
        	[$this->title],
        	[""],
        	["Total Income", "₱" . number_format($income, 2)],
        	["Total Delivered", $delivered],
        	["Total Cancelled", $cancelled],
        	["Total Rider Cancel", $riderCancel],
        	[""],
        	["Cust. First Name","Cust. Last Name","Cust. Contact","Cust. Address","Price","Status","Comments","Booked On","Rating","Sel. First Name","Sel. Last Name","Sel. Contact","Rid. First Name","Rid. Last Name","Rid. Contact"]
        ])->concat($transactions);
        $this->transactions = $transactions;

        return $transactions;
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function(BeforeWriting $event) {
                $event->writer->getDefaultStyle()->getAlignment()->setHorizontal("center");
            },
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle("A1")->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle("A1")->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle("A8:O8")->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle("A1")->getAlignment()->setHorizontal("center");
                $event->sheet->getDelegate()->getStyle("A8:O8")->getAlignment()->setHorizontal("center");
            }
        ];
    }
}
