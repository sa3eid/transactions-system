<!-- income edit form -->
<div>
    <form id="iform" class="form-horizontal" type="post">
        <input type="hidden" name="income_id" value="<?= $Id ?>">

        <div class="form-group row">
            <label for="category_selection" class="col-sm-4 col-form-label"><?= $this->lang->line('income category'); ?> </label>
            <div class="col-sm-8">
                <select style="width: 50%;" id="category_selection" name="income_category">
                    <!-- <option value=''></option> -->
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="i_amount" class="col-sm-4 col-form-label"><?= $this->lang->line('income amount'); ?></label>
            <div class="col-sm-8">
                <input style="width: 50%;" name="income_amount" type="text" id="i_amount" class="form-control" placeholder="<?= $this->lang->line('income amount'); ?>" value="<?= $Amount ?>">
            </div>
        </div>

        <div class="form-group row my-3 date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
            <label for="d_income" class="col-sm-4 col-form-label"><?= $this->lang->line('income date'); ?></label>
            <div class="col-sm-8">
                <input style="width: 50%;" id="d_income" class="form-control" type="text" name="income_date" placeholder="YYYY-MM-DD" value="<?= $Date ?>">
                <div class="input-group-addon">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </div>
            </div>

        </div>

        <div class="form-group row my-3">
            <label for="income_comment" class="col-sm-4 col-form-label"><?= $this->lang->line('income comment'); ?></label>
            <div class="col-sm-8">
                <textarea style="width: 50%;" class="form-control" name="comment_area" id="income_comment"><?= $Comment ?></textarea>
            </div>
        </div>

        <input style="margin-left: 11.6vw;" name="income_edit_save" id="iedit_save" class="btn btn-success" type="submit" value="<?= $this->lang->line('Save Edit'); ?>">

    </form>
</div>

<script>
    $(document).ready(function() {
        // ajax call to send edit income form data to serverside for processing
        $("#iedit_save").on('click', function(e) {

            e.preventDefault();
            $(this).attr('disabled', true);
            if ($('input[name=income_name]').val() == '' || $('input[name=income_amount]').val() == '') {
                PNotify.error({
                    text: '<?= $this->lang->line('Missing or incorrect data type Fields') ?>'
                });
            } else {
                $.ajax({
                    url: "<?= site_url('dashboard/income_edit'); ?>",
                    method: "POST",
                    data: $("#iform").serialize(),
                    success: function(data) {

                        PNotify.success({
                            text: '<?= $this->lang->line('Income Data Edit Saved Successfully') ?>'
                        });
                        $("#iedit_save").attr('disabled', false);
                    }
                })
                $("#itable").DataTable().draw();
            }


        })

    })
</script>

<script>
    //ajax call for select2 plugin to user_couintry function at RegisterLogn controller

    $(document).ready(function() {
        $('#category_selection').select2({
            placeholder: "Select and Search",
            ajax: {
                url: '<?= site_url('dashboard/income_selection') ?>',
                type: 'post',
                dataType: 'json',

                //sending data to serverside
                data: function(params) {
                    return {
                        searchTerm: params.term
                    };
                },
                //receiving data from serverside
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    }
                },
                cache: true,
            }

        });

        // append the option and update Select2
        var $option = $('<option value="<?= $CategoryId ?>"><?= $Name ?></option>');
        $('#category_selection').append($option).trigger('change');

    });
</script>