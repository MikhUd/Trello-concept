<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desk;
class SpaController extends Controller
{
    public function index(){
        return view('index');
    }

    public function getDesks(){
        return Desk::all();
    }

    public function showDesk($id){
        return Desk::find($id);
    }

    public function createDesk(Request $request){
        $desk = new Desk($request->all());
        $desk->save();
        return Desk::all();
    }

    public function deleteDesk($id){
        $desk = Desk::find($id);
        $desk->delete();
        return Desk::all();
    }

    public function updateDesk(Request $request, $id){

        $task = Desk::find($id);
        $task->update($request->all());
        return $task;
    }

}
