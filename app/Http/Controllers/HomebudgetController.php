<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeBudget;

class HomebudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homebudgets = HomeBudget::with('category')->orderBy('date','desc')->paginate(5);        
        $income=HomeBudget::where('category_id', 6)->sum('price');
        $payment= HomeBudget::where('category_id', '!=', 6)->sum('price');
        return view('homebudget.index', compact('homebudgets', 'income', 'payment'));
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
        $validated = $request->validate([
       'date' => 'required|date',
       'category' => 'required|numeric',
       'price' => 'required|numeric',
       ]);

       $result = HomeBudget::create([
        'date' => $request->date,
        'category_id' => $request->category,
        'price' => $request->price,
       ]);

       if(!empty($result)){
          session()->flash('flash_message','支出を登録しました。' );
       }else{
        session()->flash('flash_message','支出を登録できませんでした。');
       }
        
       return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $homebudget=HomeBudget::find($id);
        return view('homebudget.edit', compact('homebudget'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
       'date' => 'required|date',
       'category' => 'required|numeric',
       'price' => 'required|numeric',
       ]);

     try {
      $budget = HomeBudget::find($request->id);

      if ($budget) {
        $budget->update([
            'date' => $request->date,
            'category_id' => $request->category,
            'price' => $request->price,
        ]);
        session()->flash('flash_message', '支出を更新しました');
       } else {
        session()->flash('flash_error_message', '支出が見つかりませんでした');
      }

      return redirect('/');
     } catch (\Exception $e) {
       dd('エラー: ' . $e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $homebudget = HomeBudget::find($id);
    
     if ($homebudget) {
        $homebudget->delete();
        session()->flash('flash_message', '支出を削除しました');
     } else {
        session()->flash('flash_error_message', '削除するデータが見つかりませんでした');
     }
    
     return redirect('/');
     }
    }
