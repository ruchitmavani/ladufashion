<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use yajra\Datatables\Datatables;
use setasign\Fpdi\Fpdi;

class BillsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Bills::select('*')->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('final_amount', function($row){
                    return '₹ '.number_format($row->final_amount, 2);
                })
                ->addColumn('bill_date', function($row){
                    return date('d-m-Y', strtotime($row->bill_date));
                })
                ->addColumn('action', function($row){
                    $html = "<a class='btn btn-primary btn-icon' href='". route('bills.edit', ['id' => $row['id']]) ."'><i class='fa fa-pen'></i></a>
                    <a class='btn btn-success btn-icon' href='".asset('bills/'.$row->file_name)."' target='_blanl'><i class='fa fa-eye'></i></a>";
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('bills');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firmData = Firm::where('id', $request->firm)->first();
        $temp = Bills::select('bill_no')->orderBy('id', 'desc')->first();
        $input['party_id'] = $request->firm;
        $input['name'] = $firmData['name'];
        $input['address'] = $request->address;
        $input['state'] = $request->state;
        $input['gst'] = $request->gst;
        $input['bill_date'] = $request->bill_date;
        $input['due_date'] = $request->due_date;
        $input['bill_no'] = $temp ? $temp['bill_no'] + 1 : 1;
        $input['shipping'] = $request->shipping_name;
        $input['shipping_address'] = $request->shipping_address;
        $input['shipping_place'] = $request->shipping_place;
        $input['challan'] = $request->challan_no;
        $input['challan_date'] = $request->challan_date;
        $input['products'] = "[".$request->products."]";
        $input['total_amount'] = $request->total_amount;
        $input['discount'] = $request->discount;
        $input['cgst'] = $request->cgst;
        $input['sgst'] = $request->sgst;
        $input['igst'] = $request->igst;
        $input['final_amount'] = round($request->final);
        $input['bank'] = $request->bank;
        $input['account_no'] = $request->account_no;
        $input['ifsc'] = $request->ifsc;
        $name = time().'.pdf';
        $input['file_name'] = $name;
        $check = Bills::create($input);


        $pdf = new Fpdi();
        $pdf->AddPage();
        
        $pdf->setSourceFile(public_path('ladufashion.pdf'));
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);
        $pdf->SetFont('courier', '', '12');
        // M/s  
        $pdf->SetXY(26, 52);
        $pdf->Write(4, $firmData['name']);
        // add 
        $pdf->SetFont('courier', '', '9');
        $pdf->SetXY(26, 59);
        $pdf->MultiCell(100, 3, $request->address);
        //  GST
        $pdf->SetFont('courier', '', '12');
        $pdf->SetXY(26, 66);
        $pdf->Write(4, $request->gst);
        //  State
        $pdf->SetXY(40, 72.5);
        $pdf->Write(4, $request->state);

        // Ship 
        $pdf->SetXY(26, 79.7);
        $pdf->Write(4, $request->shipping_name);
        //  add
        $pdf->SetXY(26, 86.7);
        $pdf->Write(4, $request->shipping_address);
        //  place
        $pdf->SetXY(26, 93.7);
        $pdf->Write(4, $request->shipping_place);

        // Invoice No  
        $pdf->SetXY(160, 54);
        $pdf->Write(4, $temp ? $temp['bill_no'] + 1 : 1);
        //  date
        $pdf->SetXY(150, 62);
        $pdf->Write(4, date('d/m/Y', strtotime($request->bill_date)));
        //  due date
        $pdf->SetXY(158, 69.5);
        $pdf->Write(4, date('d/m/Y', strtotime($request->due_date)));

        //party  challan N0  
        $pdf->SetXY(170, 82.5);
        $pdf->Write(4, $request->challan_no);
        //  party challan date
        $pdf->SetXY(172, 90);
        $pdf->Write(4, $request->challan_date ? date('d/m/Y', strtotime($request->challan_date)) : '');

        $products = json_decode('['.$request->products.']', true);
        $i = 0;
        $startY = 110;
        foreach($products as $product){
            $pdf->SetXY(15.5, $startY);
            $pdf->Write(4, ++$i);

            $pdf->SetXY(25, $startY);
            $pdf->Write(4, $product['name']);

            $pdf->SetXY(99, $startY);
            $pdf->Write(4, $product['hsn']);

            $pdf->SetXY(124.5, $startY);
            $pdf->Write(4, $product['qty']);

            $pdf->SetXY(146, $startY);
            $pdf->Write(4, $product['rate']);

            // Amount
            $pdf->SetXY(170, $startY);
            $pdf->Write(4, number_format($product['rate'] * $product['qty'], 2));

            $startY = $startY + 7;
        }

        // Total Invice Amount Words
        $pdf->SetXY(17, 205);
        $pdf->MultiCell(100, 5, $this->amountToWords($request->final));


        //Amount Before GST
        $pdf->SetXY(170, 198.5);
        $pdf->Write(4, number_format($request->total_amount, 2));

        // Discount
        $pdf->SetXY(170, 206);
        $pdf->Write(4, $request->discount.'(%)');

        // cgst
        $pdf->SetXY(170, 213);
        $pdf->Write(4, $request->cgst);

        // sgst
        $pdf->SetXY(170, 220);
        $pdf->Write(4, $request->sgst);

        // IGST
        $pdf->SetXY(170, 227);
        $pdf->Write(4, $request->igst);

        // Total Tax
        $pdf->SetXY(170, 234);
        $pdf->Write(4, number_format($request->tax, 2));

        // Total Amount A. T.
        $pdf->SetXY(170, 241);
        $pdf->Write(4, number_format(round($request->final), 2));

        // Bank
        $pdf->SetXY(25, 227);
        $pdf->Write(4, $request->bank);

        // Bank A/c.
        $pdf->SetXY(33, 234);
        $pdf->Write(4, $request->account_no);

        // IFSC Code
        $pdf->SetXY(44, 241);
        $pdf->Write(4, $request->ifsc);
        
        $pdf->Output(public_path('bills/'.$name),'F');



        if($check){
            $response['success'] = true;
            $response['message'] = "Bill saved successfully";
            $response['data'] = ['link' => asset('bills/'.$name)];
        }
        else{
            $response['success'] = false;
            $response['message'] = "Something went wrong";
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function show(Bills $bills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bill = Bills::find($id);
        $bill['products'] = json_decode($bill['products'], true);

        $temp = $bill['total_amount'] - ($bill['total_amount'] * ($bill['discount']/100));
        $tax = $temp * ($bill['cgst']/100);
        $tax += $temp * ($bill['sgst']/100);
        $tax += $temp * ($bill['igst']/100);
        $bill['tax'] = $tax;
        $firms = Firm::orderBy('name')->get();
        $data['bill'] = $bill;
        $data['firms'] = $firms;
        return view('edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bills $bills)
    {
        $firmData = Firm::where('id', $request->firm)->first();
        $billData = Bills::where('id', $request->id)->first();
        
        $input['party_id'] = $request->firm;
        $input['name'] = $firmData['name'];
        $input['address'] = $request->address;
        $input['state'] = $request->state;
        $input['gst'] = $request->gst;
        $input['bill_date'] = $request->bill_date;
        $input['due_date'] = $request->due_date;
        $input['shipping'] = $request->shipping_name;
        $input['shipping_address'] = $request->shipping_address;
        $input['shipping_place'] = $request->shipping_place;
        $input['challan'] = $request->challan_no;
        $input['challan_date'] = $request->challan_date;
        $input['total_amount'] = $request->total_amount;
        $input['discount'] = $request->discount;
        $input['cgst'] = $request->cgst;
        $input['sgst'] = $request->sgst;
        $input['igst'] = $request->igst;
        $input['final_amount'] = round($request->final);
        $input['bank'] = $request->bank;
        $input['account_no'] = $request->account_no;
        $input['ifsc'] = $request->ifsc;
        $name = $billData['file_name'];
        $input['file_name'] = $name;

        $input['products'] = "[".$request->products."]";

        $check = Bills::where('id', $request->id)->update($input);


        $pdf = new Fpdi();
        $pdf->AddPage();
        
        $pdf->setSourceFile(public_path('ladufashion.pdf'));
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);
        $pdf->SetFont('courier', '', '12');
        // M/s  
        $pdf->SetXY(26, 52);
        $pdf->Write(4, $firmData['name']);
        // add 
        $pdf->SetFont('courier', '', '9');
        $pdf->SetXY(26, 59);
        $pdf->MultiCell(100, 3, $request->address);
        //  GST
        $pdf->SetFont('courier', '', '12');
        $pdf->SetXY(26, 66);
        $pdf->Write(4, $request->gst);
        //  State
        $pdf->SetXY(40, 72.5);
        $pdf->Write(4, $request->state);

        // Ship 
        $pdf->SetXY(26, 79.7);
        $pdf->Write(4, $request->shipping_name);
        //  add
        $pdf->SetXY(26, 86.7);
        $pdf->Write(4, $request->shipping_address);
        //  place
        $pdf->SetXY(26, 93.7);
        $pdf->Write(4, $request->shipping_place);

        // Invoice No  
        $pdf->SetXY(160, 54);
        $pdf->Write(4, $billData['bill_no']);
        //  date
        $pdf->SetXY(150, 62);
        $pdf->Write(4, date('d/m/Y', strtotime($request->bill_date)));
        //  due date
        $pdf->SetXY(158, 69.5);
        $pdf->Write(4, date('d/m/Y', strtotime($request->due_date)));

        //party  challan N0  
        $pdf->SetXY(170, 82.5);
        $pdf->Write(4, $request->challan_no);
        //  party challan date
        $pdf->SetXY(172, 90);
        $pdf->Write(4, $request->challan_date ? date('d/m/Y', strtotime($request->challan_date)) : '');

        $products = json_decode('['.$request->products.']', true);
        $i = 0;
        $startY = 110;
        foreach($products as $product){
            $pdf->SetXY(15.5, $startY);
            $pdf->Write(4, ++$i);

            $pdf->SetXY(25, $startY);
            $pdf->Write(4, $product['name']);

            $pdf->SetXY(99, $startY);
            $pdf->Write(4, $product['hsn']);

            $pdf->SetXY(124.5, $startY);
            $pdf->Write(4, $product['qty']);

            $pdf->SetXY(146, $startY);
            $pdf->Write(4, $product['rate']);

            // Amount
            $pdf->SetXY(170, $startY);
            $pdf->Write(4, number_format($product['rate'] * $product['qty'], 2));

            $startY = $startY + 7;
        }

        // Total Invice Amount Words
        $pdf->SetXY(17, 205);
        $pdf->MultiCell(100, 5, $this->amountToWords($request->final));


        //Amount Before GST
        $pdf->SetXY(170, 198.5);
        $pdf->Write(4, number_format($request->total_amount, 2));

        // Discount
        $pdf->SetXY(170, 206);
        $pdf->Write(4, $request->discount.'(%)');

        // cgst
        $pdf->SetXY(170, 213);
        $pdf->Write(4, $request->cgst);

        // sgst
        $pdf->SetXY(170, 220);
        $pdf->Write(4, $request->sgst);

        // IGST
        $pdf->SetXY(170, 227);
        $pdf->Write(4, $request->igst);

        // Total Tax
        $pdf->SetXY(170, 234);
        $pdf->Write(4, number_format($request->tax, 2));

        // Total Amount A. T.
        $pdf->SetXY(170, 241);
        $pdf->Write(4, number_format(round($request->final), 2));

        // Bank
        $pdf->SetXY(25, 227);
        $pdf->Write(4, $request->bank);

        // Bank A/c.
        $pdf->SetXY(33, 234);
        $pdf->Write(4, $request->account_no);

        // IFSC Code
        $pdf->SetXY(44, 241);
        $pdf->Write(4, $request->ifsc);
        
        $pdf->Output(public_path('bills/'.$name),'F');



        if($check){
            $response['success'] = true;
            $response['message'] = "Bill updated successfully";
            $response['data'] = ['link' => asset('bills/'.$name)];
        }
        else{
            $response['success'] = false;
            $response['message'] = "Something went wrong";
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bills $bills)
    {
        //
    }
}
