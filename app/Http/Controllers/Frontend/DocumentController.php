<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\DocumentRepository;

class DocumentController extends Controller
{
    protected $documentRepository;

    public function __construct()
    {
        $this->documentRepository = resolve(DocumentRepository::class);
    }

    public function index()
    {
        // $user = backpack_user();
        // if (isset(request()->technical) && !$user
        //     || ($user && $user->isAdminRole() && $user->isMemberRole())
        // ) {
        //     return redirect(RouteServiceProvider::HOME);
        // }
        $entry = $this->documentRepository->getModelByType();
        return view('frontend.document.document', ['entry' => $entry]);
    }
}

