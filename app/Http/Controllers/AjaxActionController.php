<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MatchModelTrait;
use App\Http\Requests\AnswerRequest;
use App\Repositories\ScoreRepository;
use App\Repositories\AnswerRepository;
use App\Repositories\ContestRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\StatisticRepository;

class AjaxActionController extends Controller
{
    use MatchModelTrait;

    protected $answerRepository;
    protected $contestRepository;
    protected $questionRepository;
    protected $statisticRepository;
    protected $scoreRepository;

    public function __construct()
    {
        $this->answerRepository = resolve(AnswerRepository::class);
        $this->contestRepository = resolve(ContestRepository::class);
        $this->questionRepository = resolve(QuestionRepository::class);
        $this->statisticRepository = resolve(StatisticRepository::class);
        $this->scoreRepository = resolve(ScoreRepository::class);
    }

    public function responseFormat($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    public function webAjaxCall(Request $request)
    {
        $page = $request->page ?? 10;
        $table = $request->table ?? '';
        $value = $request->q ?? '';
        $type = $request->type ?? 'ajax';

        $query = $this->actionType($table, $value, $type);

        return $query->paginate($page);
    }

    public function modalFormAction(AnswerRequest $request)
    {
        return $this->answerRepository->create($request->all());
    }

    public function objectRelationAction(Request $request, $id)
    {
        $updated = $this->answerRepository->updateScore($id, $request);

        if (!$updated) {
            return $this->responseFormat([
                'message' => trans('custom.failed_to_update_score'),
                'success' => false,
            ], 422);
        }

        return $this->responseFormat([
            'message' => trans('custom.score_updated'),
            'success' => true,
            'data' => $this->answerRepository->updateScore($id, $request)
        ]);
    }

    public function getContestQuestionIds($contestId)
    {
        $entry = $this->contestRepository->getExamQuestionIds($contestId);

        if (!$entry) {
            return $this->responseFormat([
                'message' => trans('custom.failed'),
                'success' => false,
            ], 422);
        }

        return $this->responseFormat([
            'message' => trans('custom.success'),
            'success' => true,
            'data' => $entry,
        ]);
    }

    public function getAttemptQuestion(Request $request, $id)
    {
        $registeredContest = $request->registered_contest ?? '';
        $entry = $this->questionRepository->getById($id);

        if (!$entry) {
            return $this->responseFormat([
                'message' => trans('custom.failed'),
                'success' => false,
            ], 422);
        }

        return $this->responseFormat([
            'message' => trans('custom.success'),
            'success' => true,
            'data' => [
                'id' => $entry->id,
                'title' => $entry->TitleLang,
                'description' => $entry->DescriptionLang,
                'answers' => $entry->answers->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'title' => $v->TitleLang,
                        'description' => $v->DescriptionLang,
                    ];
                }),
                'chose_answer' => optional($this->statisticRepository->getChose($registeredContest, $id))->chose_answer_id,
            ],
        ]);
    }

    public function submitAnswer(Request $request)
    {
        $entry = $this->statisticRepository->updateOrCreateStat($request);

        if (!$entry) {
            return $this->responseFormat([
                'message' => trans('custom.failed'),
                'success' => false,
            ], 422);
        }

        return $this->responseFormat([
            'message' => trans('custom.success'),
            'success' => true,
            'data' => $entry,
        ]);
    }

    public function submitExam(Request $request)
    {
        $entry = $this->scoreRepository->setScoreAfterExam($request);

        if (!$entry) {
            return $this->responseFormat([
                'message' => trans('custom.failed'),
                'success' => false,
            ], 422);
        }

        return $this->responseFormat([
            'message' => trans('custom.success'),
            'success' => true,
            'data' => $entry,
        ]);
    }
}
