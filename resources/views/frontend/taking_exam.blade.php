@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.taking_exam'),
        // 'items' => [
        //     trans('custom.home') => route('homepage'),
        //     trans('custom.my_contests') => route('my_contest'),
        //     trans('custom.taking_exam') => '#',
        // ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    $contestId = isset($regContest['contest']) ? $regContest['contest']->id : '';
@endphp

@section('content')
    <div class="section wb" id="taking_exam">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-md-4">
                    <div class="jumbotron rounded-0">
                        <div class="p-3 mb-3" style="background-color: #004D40;">
                            <timer-component
                                starttime="{{ $regContest['start_date'] }}"
                                endtime="{{ $regContest['end_date'] }}"
                                trans='{"hours":"{{ trans("custom.hours") }}","minutes":"{{ trans("custom.minutes") }}","seconds":"{{ trans("custom.seconds") }}","expired":"{{ trans("custom.times_up") }}","running":"{{ trans("custom.remaining") }}","status": {"expired":"Expired","running":"Running"}}'
                            />
                        </div>
                        <div
                            class="d-flex flex-wrap"
                        >
                            <button
                                v-for="({id, attempted}, i) in questions"
                                :class="`btn ${active != i && attempted ? 'btn-info' : (active == i ? 'btn-primary' : 'btn-outline-primary')} mr-2 mb-2`"
                                style="width: 38px;"
                                @click="getAttemptQuestion(id, i)"
                                :key="i"
                            >
                                @{{ i + 1 }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-md-8">
                    <h2
                        class="font-weight-bold"
                        v-html="`${active + 1}. ${question.title}`"
                    ></h2>
                    <p v-html="question.description"></p>
                    <div
                        class="form-check"
                        v-for="({ id, description, chose_answer }, i) in question.answers"
                        :key="i"
                    >
                        <input
                            class="form-check-input mt-2"
                            type="radio"
                            name="answer_radios"
                            :id="`answer_${i}`"
                            v-model="answer"
                            :value="id"
                        />
                        <label
                            class="form-check-label"
                            :for="`answer_${i}`"
                            v-html="description"
                        >
                        </label>
                    </div>
                    <div :set="index = active + 1">
                        <button
                            :class="`btn btn-success mr-1${!answer ? ' disabled' : ''}`"
                            @click="submitQuestion"
                        >
                            {{ trans('custom.submit_answer') }}
                        </button>
                        <button
                            v-if="typeof questions[questions.length - 1] !== 'undefined' && question.id != questions[questions.length - 1].id"
                            class="btn btn-primary"
                            @click="getAttemptQuestion(questions[index].id, index)"
                        >
                            {{ trans('custom.attempt_later') }}
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </button>
                        <button
                            v-else
                            class="btn btn-danger"
                            @click="submitExams"
                        >
                            {{ trans('custom.submit_exam') }}
                        </button>
                    </div>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection

@push('after_styles')
    <style>
        .timer {
            font-size: 20px;
            color: #fff;
            text-align: center;
        }

        .timer .day,
        .timer .hour,
        .timer .min,
        .timer .sec {
            font-size: 30px;
            display: inline-block;
            font-weight: 500;
            text-align: center;
            margin: 0 5px;
        }

        .timer .day .format,
        .timer .hour .format,
        .timer .min .format,
        .timer .sec .format {
            font-weight: 300;
            font-size: 14px;
            opacity: 0.8;
            width: 60px;
        }

        .timer .number{
            background: rgba(51, 51, 51, 0.5);
            padding: 0 5px;
            border-radius: 5px;
            display: inline-block;
            width: 60px;
            text-align: center;
        }

        .timer .message {
            font-size: 14px;
            font-weight: 400;
            margin-top: 5px;
        }
        .timer .status-tag {
            width: 100%;
            margin: 10px auto;
            padding: 8px 0;
            font-weight: 500;
            color: #000;
            text-align: center;
            border-radius: 15px;
        }

        .timer .status-tag.upcoming{
            background-color: lightGreen;
        }
        .timer .status-tag.running{
            background-color: gold;
        }
        .timer .status-tag.expired{
            background-color: silver;
        }
    </style>
@endpush

@push('after_scripts')
    <script type="text/javascript">
        Vue.component('timer-component', {
            template: `
                <div class="timer">
                    <div v-show="statusType !== 'expired'" class="mt-2">
                        <div class="hour">
                            <span class="number">
                                @{{ hours.toLocaleString('en-US', {
                                    minimumIntegerDigits: 2,
                                    useGrouping: false
                                }) }}
                            </span>
                            <div class="format">@{{ wordString.hours }}</div>
                        </div>
                        <div class="min">
                            <span class="number">
                                @{{ minutes.toLocaleString('en-US', {
                                    minimumIntegerDigits: 2,
                                    useGrouping: false
                                }) }}
                            </span>
                            <div class="format">@{{ wordString.minutes }}</div>
                        </div>
                        <div class="sec">
                            <span class="number">
                                @{{ seconds.toLocaleString('en-US', {
                                    minimumIntegerDigits: 2,
                                    useGrouping: false
                                }) }}
                            </span>
                            <div class="format">@{{ wordString.seconds }}</div>
                        </div>
                    </div>
                    <div class="message">@{{ message }}</div>
                    <div class="status-tag" :class="statusType">@{{ statusText }}</div>
                </div>
            `,
            props: ['starttime', 'endtime', 'trans'] ,
            data() {
                return{
                    timer: "",
                    wordString: {},
                    start: "",
                    end: "",
                    interval: "",
                    minutes: "",
                    hours: "",
                    seconds: "",
                    message: "",
                    statusType: "",
                    statusText: "",
                };
            },
            created() {
                this.wordString = JSON.parse(this.trans);
            },
            mounted() {
                this.start = new Date(this.starttime).getTime();
                this.end = new Date(this.endtime).getTime();
                // Update the count down every 1 second
                this.timerCount(this.start,this.end);
                this.interval = setInterval(() => {
                    this.timerCount(this.start,this.end);
                }, 1000);
            },
            methods: {
                timerCount: async function(start,end) {
                    // Get todays date and time
                    const now = new Date().getTime();

                    // Find the distance between now an the count down date
                    let distance = start - now;
                    let passTime = end - now;

                    if (distance < 0 && passTime < 0) {
                        this.message = this.wordString.expired;
                        this.statusType = "expired";
                        this.statusText = this.wordString.status.expired;
                        clearInterval(this.interval);
                        await takingExamVue.submitExams();
                        return;

                    } else if (distance < 0 && passTime > 0) {
                        this.calcTime(passTime);
                        this.message = this.wordString.running;
                        this.statusType = "running";
                        this.statusText = this.wordString.status.running;

                    } else if (distance > 0 && passTime > 0) {
                        this.calcTime(distance);
                        this.message = this.wordString.upcoming;
                        this.statusType = "upcoming";
                        this.statusText = this.wordString.status.upcoming;
                    }
                },
                calcTime: function(dist) {
                    this.hours = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((dist % (1000 * 60)) / 1000);
                }
            }
        });

        const takingExamVue = new Vue({
            el: '#taking_exam',
            data() {
                return {
                    questions: [],
                    question: {},
                    answer: 0,
                    active: 0,
                    dirty_form: true,
                };
            },
            methods: {
                getQuestions: async function(questions = []) {
                    const vm = this;

                    if (questions.length) {
                        vm.$set(vm, 'questions', questions);
                        return false;
                    }

                    await axios.get(`{{ route('exam_questions', ['contestId' => $contestId]) }}`)
                        .then(async ({ data: { data } }) => {
                            await vm.$set(vm, 'questions', data.map(v => {
                                return {
                                    id: v,
                                    attempted: null,
                                };
                            }));
                            localStorage.setItem('data_questions', JSON.stringify(vm.questions));
                        })
                        .catch(err => console.error(err));
                },
                getAttemptQuestion: async function(id, index = 0) {
                    if (typeof id === 'undefined') return false;
                    const vm = this;
                    await axios.get(`{{ url('exam-attempt-questions') }}/${id}?registered_contest={{ $regContest['id'] }}`)
                        .then(({ data: { data } }) => {
                            vm.$set(vm, 'question', data);
                            vm.$set(vm, 'active', index);
                            vm.$set(vm, 'answer', data.chose_answer);
                            localStorage.setItem('active_question', index);
                        })
                        .catch(err => console.error(err));
                },
                submitQuestion: async function() {
                    const vm = this;
                    if (typeof vm.question === 'undefined') return false;

                    const param = {
                        question: vm.question.id,
                        registered_contest: {{ $regContest['id'] }},
                        chose_answer: vm.answer,
                    };
                    await axios.post(`{{ route('exam_submit_question') }}`, param)
                        .then(({ data: { data } }) => {
                            const index = vm.active + 1;
                            vm.questions[vm.active].attempted = vm.answer;
                            localStorage.setItem('data_questions', JSON.stringify(vm.questions));
                            if (typeof vm.questions[index] !== 'undefined')
                                vm.getAttemptQuestion(vm.questions[index].id, index);
                        })
                        .catch(err => console.error(err));
                },
                submitExams: async function() {
                    await axios.post(`{{ route('submit_exam') }}`, {
                        registered_contest: {{ $regContest['id'] }}
                    })
                        .then(({ data: { success, message: text } }) => {
                            if (success) {
                                new Noty({
                                    type: "success",
                                    text,
                                    timeout: 3000,
                                }).show();
                                localStorage.setItem('active_question', '');
                                localStorage.setItem('data_questions', '');
                                setTimeout(() => window.location.href = '{{ route("view_contest_stat", ["regContestId" => $regContest["id"]]) }}', 1000);
                            }
                        })
                        .catch(err => console.error(err));
                }
            },
            async mounted() {
                @if (Session::get('success_token_login'))
                    new Noty({
                        type: "success",
                        text: "{{ Session::get('success_token_login') }}",
                        timeout: 3000,
                    }).show();
                @endif
                const active = localStorage.getItem('active_question') ? parseInt(localStorage.getItem('active_question')) : 0;
                const data_questions = localStorage.getItem('data_questions') ? JSON.parse(localStorage.getItem('data_questions')) : '';

                await this.getQuestions(data_questions);
                if (typeof this.questions[active] !== 'undefined')
                    await this.getAttemptQuestion(this.questions[active].id, active);
            },
        });

        window.onbeforeunload = function(e) {
            var dialogText = 'We are saving the status of your listing. Are you realy sure you want to leave?';
            e.returnValue = dialogText;
            return dialogText;
        };
    </script>
@endpush
