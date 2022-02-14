<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Mail\ContactUs;
use App\Models\Contest;
use App\Models\WorkShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use App\Repositories\ContestRepository;
use App\Repositories\StudentRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\RegisteredContestRepository;
use App\Repositories\WorkshopRepository;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $contestRepository;
    protected $categoryRepository;
    protected $studentRepository;
    protected $userRepository;
    protected $registeredContestRepository;
    protected $newsRepository;
    protected $workshopRepository;

    public function __construct()
    {
        $this->contestRepository = resolve(ContestRepository::class);
        $this->categoryRepository = resolve(CategoryRepository::class);
        $this->studentRepository = resolve(StudentRepository::class);
        $this->userRepository = resolve(UserRepository::class);
        $this->registeredContestRepository = resolve(RegisteredContestRepository::class);
        $this->newsRepository = resolve(NewsRepository::class);
        $this->workshopRepository = resolve(WorkshopRepository::class);
    }

    public function homepage()
    {
        return view('frontend.index', [
            'contest' => Contest::where('status', 'approved')->orderBy('updated_at', 'desc')->first(),
            'workshop' => WorkShop::where('status', 'approved')->orderBy('updated_at', 'desc')->first(),
            'news' => News::where('status', 'approved')->orderBy('updated_at', 'desc')->take(3)->get(),
        ]);
    }

    public function index()
    {
        $workShops = WorkShop::where('status', 'approved')->orderBy('end_date', 'asc')->get();
        return view('frontend.workshop.workshop', ['workShops' => $workShops]);
    }

    public function workshopDetails($id)
    {
        $workShop = WorkShop::where('status', 'approved')->where('id', $id)->first();
        return view('frontend.workshop.detail', ['entry' => $workShop]);
    }

    public function aboutUs()
    {
        return view('frontend.about_us');
    }

    public function contactUs()
    {
        return view('frontend.contact_us');
    }

    public function sendMailContactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
            'message' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        try {
            Mail::to(config('settings.contact_us_email'))->send(new ContactUs(collect([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => 'Contact',
                'message' => $request->message
            ])));
            return redirect()->back()->with(['res_obj' => [
                'success' => true,
                'message' => trans('custom.contact_us_send_mail_success_message'),
            ]]);
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with(['res_obj' => [
                'success' => false,
                'message' => trans('custom.contact_us_send_mail_error_message'),
            ]]);
        }
    }

    public function contest(Request $request)
    {
        $levelId = $request->level ?? '';
        $this->contestRepository->setScopesAttr(['StatusApproved' => []]);
        $query = $this->contestRepository;
        if ($levelId) {
            $query->where('level_id', $levelId);
        }
        return view('frontend.contest.index', [
            'entries' => $query->paginate(10),
        ]);
    }

    public function contestDetail($id)
    {
        return view('frontend.contest.detail', ['entry' => $this->contestRepository->getById($id)]);
    }

    public function newsDetail($id)
    {
        return view('frontend.news.detail', ['entry' => $this->newsRepository->getById($id)]);
    }

    public function studentBySchool()
    {
        $user = backpack_user();
        if (!$user || !$user->isSchoolRole()) {
            return redirect(RouteServiceProvider::HOME);
        }
        $entries = $this->studentRepository->getStudentByUser($user->id) ? $this->studentRepository->getStudentByUser($user->id) : [];
        return view('frontend.my_student', ['entries' => $entries]);
    }

    public function studentBySchoolDetail($id)
    {
        $user = backpack_user();
        if (!$user || !$user->isSchoolRole()) {
            return redirect(RouteServiceProvider::HOME);
        }
        return view('frontend.student_detail', ['entry' => $this->studentRepository->getById($id)]);
    }

    public function studentContests()
    {
        if (!backpack_user() || !backpack_user()->isStudentRole()) {
            return redirect(RouteServiceProvider::HOME);
        }
        $entries = $this->userRepository->getUserRegContests() ? $this->userRepository->getUserRegContests() : [];
        return view('frontend.my_contest', ['entries' => $entries]);
    }

    public function takingExam($regContestId)
    {
        $entry = $this->registeredContestRepository->getById($regContestId);
        if ($entry->score) {
            return redirect(RouteServiceProvider::HOME);
        }

        return view('frontend.taking_exam', [
            'regContest' => [
                'id' => $entry->id,
                'start_date' => $entry->start_date,
                'end_date' => $entry->end_date,
                'contest' => $entry->contest,
            ]
        ]);
    }

    public function startContest(Request $request, $id)
    {
        if (!backpack_user() || !backpack_user()->isStudentRole()) {
            return redirect(RouteServiceProvider::HOME);
        }
        $this->registeredContestRepository->updateRegContestDate($id);
        return redirect()->route('taking_exam', ['regContestId' => $request->registered_contest_id]);
    }

    public function viewContestStat($regConId)
    {
        $entry = $this->registeredContestRepository->getById($regConId);
        if (!backpack_user() || $entry->user_id != backpack_user()->id) {
            return redirect(RouteServiceProvider::HOME);
        }
        return view('frontend.view_stat', ['entry' => $entry]);
    }

    public function translateDate($date)
    {
        $nums = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        $months = ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];

        $dates = explode('-', $date);
        return 'ថ្ងៃទី' . $nums[$dates[0][0]] . $nums[$dates[0][1]] . ' ខែ' . $months[(int)$dates[1] - 1] . ' ឆ្នាំ' . $nums[$dates[2][0]] . $nums[$dates[2][1]] . $nums[$dates[2][2]] . $nums[$dates[2][3]];
    }

    public function certificate($regConId)
    {
        return view('frontend.certificate_template', [
            'entry' => $this->registeredContestRepository->getById($regConId),
            'current_date' => $this->translateDate(Carbon::now()->format('d-m-Y')),
        ]);
    }

    public function workshopCertificate($wsId)
    {
        return view('frontend.workshop_certificate', [
            'entry' => $this->workshopRepository->getById($wsId),
            'current_date' => $this->translateDate(Carbon::now()->format('d-m-Y')),
        ]);
    }

    public function creatStudent(StudentRequest $request)
    {
        resolve(StudentRepository::class)->create($request->all());
        return redirect()->back()->with([
            'success' => true,
            'message' => trans('custom.student_have_been_created_success'),
        ]);
    }

    public function myAccount()
    {
        if (!backpack_user()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return view('frontend.my_account');
    }
}
