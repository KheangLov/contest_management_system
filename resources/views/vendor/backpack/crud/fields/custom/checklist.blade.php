<!-- checklist -->
@php
    $model = new $field['model'];
    $key_attribute = $model->getKeyName();
    $identifiable_attribute = $field['attribute'];
    $scope =  $field['scope'] ?? '';

    // calculate the checklist options
    if (!isset($field['options'])) {
        $field['options'] = $model;
        if ($scope) {
            $id = isset($entry) && $entry->id ? $entry->id : '';
            $field['options'] = $field['options']->{$scope}($id);
        }
        $field['options'] = $field['options']->orderBy('id')->get();
    } else {
        $field['options'] = call_user_func($field['options'], $field['model']::query());
    }

    // calculate the value of the hidden input
    $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
    if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
        $field['value'] = $field['value']->pluck($key_attribute)->toArray();
    } elseif (is_string($field['value'])){
        $field['value'] = json_decode($field['value']);
    }

    // define the init-function on the wrapper
    $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';
    $field['class_col'] =  $field['class_col'] ?? 'col-sm-4';
    $dialogForm = $field['dialog_form'] ?? '';
    $dialogIdentity = 'form_popup_dialog_' . $field['name'];
    $dialogButton = 'inline-add-component-' . $field['name'];
    $checkListIdentity = 'checklist_data_' . $field['name'];

    $checkListRelateIdentity = isset($field['relate_key']) ? 'checklist_data_' . $field['relate_key'] : '';
    $score = 0;
    $scoreId = 'score-show-' . $field['name'];
    $isCollapseRelation = isset($field['collapse_relation']) && $field['collapse_relation'];
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @if ($isCollapseRelation)
        <span class="text-info" id="{{ $scoreId }}">(0/100)</span>
    @endif
    @include('crud::fields.inc.translatable_icon')
    @if ($dialogForm)
        <div id="{{ $dialogButton }}" class="d-inline-block">
            <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#{{ $dialogIdentity }}">
                {{ trans('custom.add') }}
            </button>
        </div>
    @endif

    <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

    <div class="row" id="{{ $checkListIdentity }}">
        @forelse ($field['options'] as $key => $option)
            <div class="{{ $field['class_col'] }}{{ isset($field['show_list']) && !in_array($option->{$key_attribute}, $field['show_list']) ? ' d-none' : '' }}">
                <div class="checkbox mb-2">
                    <label class="font-weight-normal d-inline">
                        <input
                            type="checkbox"
                            value="{{ $option->{$key_attribute} }}"
                            @if (isset($field['custom_relationship']))
                                data-ref-checkbox="{{ $field['custom_relationship']['name'] . '_' . $option->{$key_attribute} }}"
                            @endif
                        >
                    </label>
                    @if ($isCollapseRelation && in_array($option->{$key_attribute}, $field['value']))
                        @php
                            $collapseId = 'collapse_' . $field['name'] . '_' . $option->{$key_attribute};
                        @endphp
                        <p
                            class="m-0 p-0 d-inline collapse-items-custom"
                            data-toggle="collapse"
                            data-target="#{{ $collapseId }}"
                            role="button"
                            aria-expanded="false"
                            aria-controls="{{ $collapseId }}"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="{{ trans('custom.click_for_collapse') }}"
                        >
                            {!! $option->{$identifiable_attribute} !!}
                        </p>
                        <div class="collapse collapse-questions" id="{{ $collapseId }}">
                            <ul class="list-group list-group-flush">
                                @forelse ($option->{$field['collapse_relation']} as $relation)
                                    <li class="list-group-item">
                                        @php
                                            $collapseRelationId = 'collapse_relation_' . $field['name'] . '_' . $relation->{$key_attribute};
                                            $btnRelationInput = 'button-input-relation-' . $field['name'] . '-' . $relation->{$key_attribute};
                                            $oneRelation = optional($option->{\Str::singular($field['collapse_relation'])});
                                        @endphp
                                        @if ($oneRelation->id == $relation->id)
                                            @php
                                                if (in_array($option->{$key_attribute}, $field['value'])) {
                                                    $score += $oneRelation->score;
                                                }
                                            @endphp
                                            <i class="las la-check text-success"></i>
                                        @else
                                            <i class="las la-times text-danger"></i>
                                        @endif
                                        <p
                                            class="m-0 p-0 d-inline collapse-items-custom"
                                            data-toggle="collapse"
                                            data-target="#{{ $collapseRelationId }}"
                                            role="button"
                                            aria-expanded="false"
                                            aria-controls="{{ $collapseRelationId }}"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            title="{{ trans('custom.click_for_collapse') }}"
                                        >
                                            {{ $relation->TitleLang }}
                                        </p>
                                        <div class="collapse{{ $oneRelation->id == $relation->id ? ' collapse-correct-answer' : '' }}" id="{{ $collapseRelationId }}">
                                            <div class="input-group w-25">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="{{ trans('custom.score') }}"
                                                    aria-label="{{ trans('custom.score') }}"
                                                    aria-describedby="{{ $btnRelationInput }}"
                                                    value="{{ $relation->score }}"
                                                />
                                                <div class="input-group-append">
                                                    <button
                                                        @click="httpRequest('{{ $relation->{$key_attribute} }}', '{{ $btnRelationInput }}', '{{ $option->{$key_attribute} }}')"
                                                        class="btn btn-outline-primary"
                                                        type="button"
                                                        id="{{ $btnRelationInput }}"
                                                    >
                                                        <div
                                                            v-if="requesting"
                                                            class="spinner-grow"
                                                            role="status"
                                                            style="width: 18px; height: 18px;"
                                                        >
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <i class="las la-sign-in-alt" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <p class="m-0">{{ trans('custom.no_data_dynamic', ['key' => trans('custom.' . $field['collapse_relation'])]) }}</p>
                                @endforelse
                            </ul>
                        </div>
                    @else
                        {!! $option->{$identifiable_attribute} !!}
                    @endif
                </div>
            </div>
        @empty
            <div class="{{ $field['class_col'] }}">
                <p class="m-0">{{ trans('custom.no_data_dynamic', ['key' => trans('custom.' . $field['name'])]) }}</p>
            </div>
        @endforelse
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

@push('after_styles')
    <style>
        .collapse-items-custom:hover,
        .collapse-items-custom:focus {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
@endpush
@push('after_scripts')
    @if ($dialogForm)
        <!-- Modal -->
        <div class="modal fade" id="{{ $dialogIdentity }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ isset($field['dialog_label']) ? $field['dialog_label'] : trans('custom.dialog_form_action') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group required">
                                <label>{{ trans('custom.title') }}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.title"
                                />
                                <div
                                    v-if="errors && errors.title && errors.title.length"
                                    class="invalid-feedback d-block"
                                >
                                    @{{ errors.title[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('custom.description') }}</label>
                                <textarea
                                    class="form-control"
                                    v-model="form.description"
                                ></textarea>
                                <div
                                    v-if="errors && errors.description && errors.description.length"
                                    class="invalid-feedback d-block"
                                >
                                    @{{ errors.description[0] }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{ trans('custom.cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary" @click="httpPostRequest">
                            {{ trans('custom.submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('packages/tinymce/tinymce.min.js') }}"></script>
        <script>
            new Vue({
                el: '#{{ $dialogButton }}'
            });

            new Vue({
                el: '#{{ $dialogIdentity }}',
                data: {
                    form: {},
                    errors: {},
                    textarea_selector: '#{{ $dialogIdentity }} textarea'
                },
                methods: {
                    httpPostRequest: function() {
                        axios.post('{{ route("modal-form-action") }}', this.form)
                            .then(async ({ data: { id, title }, status }) => {
                                if (status) {
                                    new Noty({
                                        type: "success",
                                        text: 'Success'
                                    }).show();
                                }
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                                // this.$set(this, 'form', {});
                                // $('#{{ $dialogIdentity }}').modal('hide');
                                // tinymce.activeEditor.setContent('');
                                // await $('#{{ $checkListIdentity }}').append(`<div class="{{ $field['class_col'] }}{{ isset($field['show_list']) && !in_array($key, $field['show_list']) ? ' d-none' : '' }}">
                                //         <div class="checkbox">
                                //             <label class="font-weight-normal">
                                //                 <input
                                //                     type="checkbox"
                                //                     value="${id}"
                                //                     @if (isset($field['custom_relationship']))
                                //                         data-ref-checkbox="{{ $field['custom_relationship']['name'] . '_' . $key }}"
                                //                     @endif
                                //                 > ${title}
                                //             </label>
                                //         </div>
                                //     </div>`);

                                // await $('#{{ $checkListRelateIdentity }}').append(`<div class="{{ $field['class_col'] }} d-none">
                                //             <div class="checkbox">
                                //                 <label class="font-weight-normal">
                                //                     <input
                                //                         type="checkbox"
                                //                         value="${id}"
                                //                         @if (isset($field['custom_relationship']))
                                //                             data-ref-checkbox="{{ $field['custom_relationship']['name'] . '_' . $key }}"
                                //                         @endif
                                //                     > ${title}
                                //                 </label>
                                //             </div>
                                //         </div>`);

                                // bindClickForElements(
                                //     $('input[name="{{ $field["name"] }}"]').siblings('.row').find('input[type="checkbox"]'),
                                //     $('input[name="{{ $checkListRelateIdentity }}"]').siblings('.row').find('input[type="checkbox"]')
                                // );
                            })
                            .catch(err => {
                                if (err.response && err.response.data) {
                                    const { errors, message: text } = err.response.data;
                                    if (text) {
                                        new Noty({
                                            type: "danger",
                                            text
                                        }).show();
                                    }
                                    this.$set(this, 'errors', errors);
                                }
                            });
                    }
                },
                mounted() {
                    const vm = this;
                    tinymce.init({
                        selector: vm.textarea_selector,
                        setup: function(editor) {
                            editor.on('change', function() {
                                vm.$set(vm.form, 'description', this.getContent());
                            });
                        }
                    });
                },
            });
        </script>
    @endif

    @if ($isCollapseRelation)
        <script>
            new Vue({
                el: '#{{ $checkListIdentity }}',
                data: {
                    requesting: false,
                },
                methods: {
                    httpRequest: async function(id, ref, qRef) {
                        this.requesting = true;
                        const score = $(`input[aria-describedby=${ref}]`).val();
                        const question = qRef;
                        const data = {
                            score,
                            question,
                            contest: '{{ isset($entry) && $entry ? $entry->id : '' }}',
                        };

                        await axios.put(`{{ url("admin/object-relation") }}/${id}`, data)
                            .then(async ({ data: { message: text, success, data: { current_score, total_score } }, status }) => {
                                if (success) {
                                    new Noty({
                                        type: "success",
                                        text
                                    }).show();
                                }
                                $('#{{ $scoreId }}').text(`(${total_score}/100)`);
                                if (current_score != score) {
                                    window.location.reload();
                                }
                            })
                            .catch(err => {
                                if (err.response && err.response.data) {
                                    const { message: text } = err.response.data;
                                    if (text) {
                                        new Noty({
                                            type: "danger",
                                            text
                                        }).show();
                                    }
                                    setTimeout(() => window.location.reload(), 1000);
                                }
                            });

                        this.requesting = false;
                    },
                }
            })
        </script>
    @endif
@endpush

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function bpFieldInitChecklist(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                var checkboxes = element.find('input[type=checkbox]');
                var container = element.find('.row');
                var maxCheck = parseInt(element.attr('data-max-check'));

                // set the default checked/unchecked states on checklist options
                checkboxes.each(function(key, option) {
                    var id = $(this).val();

                    if (selected_options.map(String).includes(id)) {
                        $(this).prop('checked', 'checked');
                    } else {
                        $(this).prop('checked', false);
                    }
                });

                if (maxCheck > 0) {
                    if (selected_options.length >= maxCheck) {
                        checkboxes.each(function() {
                            if (!$(this).is(':checked')) {
                                $(this).attr('disabled','disabled');
                            }
                        });
                    } else {
                        checkboxes.removeAttr('disabled');
                    }
                }

                // when a checkbox is clicked
                // set the correct value on the hidden input
                checkboxes.click(function() {
                    var newValue = [];

                    checkboxes.each(function() {
                        if ($(this).is(':checked')) {
                            var id = $(this).val();
                            newValue.push(id);
                        }
                    });

                    hidden_input.val(JSON.stringify(newValue));
                    if (maxCheck > 0) {
                        if (JSON.parse(hidden_input.val()).length >= maxCheck) {
                            checkboxes.each(function() {
                                var el = $(this);
                                if (!el.is(':checked')) {
                                    el.attr('disabled','disabled');
                                }
                            });
                        } else {
                            checkboxes.removeAttr('disabled');
                        }
                    }
                });

                @if ($isCollapseRelation)
                    $('#{{ $scoreId }}').text('({{ $score}}/100)');
                    $('.collapse-questions').collapse('show');
                    $('.collapse-correct-answer').collapse('show');
                @endif
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
