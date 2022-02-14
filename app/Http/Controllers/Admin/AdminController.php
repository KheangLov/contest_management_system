<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Repositories\UserRepository;
use App\Repositories\ContestRepository;
use App\Repositories\WorkshopRepository;
use App\Repositories\RegisteredContestRepository;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view
    protected $userRepository;
    protected $contestRepository;
    protected $regContestRepository;
    protected $workshopRepository;


    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
        $this->userRepository = resolve(UserRepository::class);
        $this->regContestRepository = resolve(RegisteredContestRepository::class);
        $this->contestRepository = resolve(ContestRepository::class);
        $this->workshopRepository = resolve(WorkshopRepository::class);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            trans('backpack::crud.admin')     => backpack_url('dashboard'),
            trans('backpack::base.dashboard') => false,
        ];

        $this->data['userCount'] = $this->userRepository->count();
        $this->data['regContest'] = $this->regContestRepository->count();
        $this->contestRepository->setScopesAttr(['StatusApproved' => []]);
        $this->data['contest'] = $this->contestRepository->count();
        $this->workshopRepository->setScopesAttr(['StatusApproved' => []]);
        $this->data['workshop'] = $this->workshopRepository->count();

        return view(backpack_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
