@push('crud_fields_scripts')
    <script>
        $(function() {
            var elements = $('input[name="answers"]').siblings('.row').find('input[type="checkbox"]');
            var refElements = $('input[name="answer"]').siblings('.row').find('input[type="checkbox"]');

            function elementFunc(ele, refEls) {
                refEls.prop('checked', false);
                refEls.prop('disabled', false);
                if (ele.is(':checked')) {
                    refEls.each(function() {
                        if ($(this).val() == ele.val()) {
                            $(this).closest('.checkbox').parent().removeClass('d-none');
                            return false;
                        }
                    });
                } else {
                    refEls.each(function() {
                        if ($(this).val() == ele.val()) {
                            var el = $(this).closest('.checkbox').parent();
                            if (!el.hasClass('d-none')) {
                                el.addClass('d-none');
                            }
                            return false;
                        }
                    });
                }
            }

            function bindClickForElements(els, refEls) {
                els.bind('click', function() {
                    elementFunc($(this), refEls);
                });
            }

            bindClickForElements(elements, refElements);
        });
    </script>
@endpush
