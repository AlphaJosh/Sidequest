<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Input;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {

  protected $user;

  public function __construct()
  {
    $this->user = Auth::user();
  }
  
  public function postJoin()
  {
    $this->user
    ->subscription(Input::get('plan'))
    ->create(Input::get('token'),[
      'email' => $this->user->email,
      'description' => $this->user->name
    ]);

    return redirect()->back()->with('notice', 'You are now subscribed!');
  }

  public function postUpgrade()
  {
    return redirect()->back();
  }

  public function postCancel()
  {
    $this->user->subscription()->cancel();

    return redirect()->back();
  }

  public function postUpdateCreditCard()
  {
    $token = '';
    $this->user->updateCard($token);

    return redirect()->back();
  }

  public function postSwapPlan()
  {
    $input = Input::get('plan_to_swap_to');
    
    $this->user->subscription($input)->swap();
    
    return redirect()->back();

  }

}
