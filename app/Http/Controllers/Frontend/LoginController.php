<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Repositories\RegisteredContestRepository;

class LoginController extends Controller
{
    protected $userRepository;
    protected $registeredContestRepository;

    public function __construct()
    {
        $this->userRepository = resolve(UserRepository::class);
        $this->registeredContestRepository = resolve(RegisteredContestRepository::class);
    }

    //FOMR LOGIN FRONTENG
    public function formLogin(){
        return view('frontend.login');
    }

    //ACTION LOGIN FRONTENT
    public function save(Request $request){
        Session::put('actionAuthFront', 'login');
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);
        $userInfo = User::where('email', '=', $request->email)->first();
        if($userInfo){
            if ($this->attemptLogin($request)) {
            // if(Hash::check($request->password, $userInfo->password)){
            //     Auth::login($userInfo, true);
                if($request->workshop_id){
                    $userInfo->workshopJoiners()->syncWithoutDetaching([$request->workshop_id]);

                    // DB::statement("INSERT INTO workshop_joiners (workshop_id, joiner_id) VALUES ($request->workshop_id, $userInfo->id)");
                }
                return redirect()->back();
            }else{
                return back()->with('fail', 'Incorrect Password');
            }
        }else{
            return back()->with('fail', 'We do not recognize your email address.');
        }
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    //LOGOUT FRINT END
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }

    public function deepLinkLogin(Request $request)
    {
        $loginToken = $request->login_token ?? '';
        $contestId = $request->contest_id ?? '';

        $entry = $this->userRepository->findUserByToken($loginToken);

        if (!$entry) {
            return back()->with('fail', 'Invalid token!');
        }

        Auth::loginUsingId($entry->id);

        if (!$contestId) {
            return redirect()
                ->route('my_contest')
                ->with('success_token_login', 'Welcome user: ' . $entry->FullName);
        }

        if (!backpack_user() || !backpack_user()->isStudentRole()) {
            return redirect()->route('logout');
        }

        $this->registeredContestRepository->updateRegContestDate($contestId);
        return redirect()
            ->route('taking_exam', ['regContestId' => $contestId])
            ->with('success_token_login', 'Welcome user: ' . $entry->FullName);
    }

}
