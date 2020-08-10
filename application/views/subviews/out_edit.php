<form id="oform" class="form-horizontal" type="post">
    <input type="hidden" name="outcome_id" value="<?= $Id ?>">

    <div class="form-group row">
        <label for="ocategory_selection" class="col-sm-4 col-form-label"><?= $this->lang->line('outcome category'); ?></label>
        <div class="col-sm-8">
            <select style="width: 50%;" id="ocategory_selection" name="outcome_category">
                <!-- <option value=''></option> -->
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="o_amount" class="col-sm-4 col-form-label"><?= $this->lang->line('outcome amount'); ?></label>
        <div class="col-sm-8">
            <input style="width: 50%;" name="outcome_amount" type="text" class="form-control" id="o_amount" placeholder="<?= $this->lang->line('outcome amount'); ?>" value="<?= $Amount ?>">
        </div>
    </div>

    <div class="form-group row my-3 date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
        <label for="d_outcome" class="col-sm-4 col-form-label"><?= $this->lang->line('outcome date'); ?></label>
        <div class="col-sm-8">
            <input style="width: 50%;" id="d_outcome" class="form-control" type="text" name="outcome_date" placeholder="YYYY-MM-DD" value="<?= $Date ?>">
            <div class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
        </div>

    </div>

    <div class="form-group row my-3">
        <label for="outcome_comment" class="col-sm-4 col-form-label"><?= $this->lang->line('outcome comment'); ?></label>
        <div class="col-sm-8">
            <textarea style="width: 50%;" class="form-control" name="o_comment" id="outcome_comment"><?= $Comment ?></textarea>
        </div>
    </div>

    <input style="margin-left: 11.6vw;" name="outcome_edit_save" id="oedit_save" class="btn btn-success" type="submit" value="<?= $this->lang->line('Save Edit'); ?>">

</form>

<script>
    $(document).ready(function() {
        // ajax call to send edit outcome form data to serverside for processing
        $("#oedit_save").on('click', function(e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            if ($('input[name=outcome_name]').val() == '' || $('input[name=outcome_amount]').val() == '') {

                PNotify.error({
                    text: '<?= $this->lang->line('Missing or incorrect data type Fields') ?>'
                });
            } else {
                $.ajax({
                    url: "<?= site_url('dashboard/outcome_edit'); ?>",
                    method: "POST",
                    data: $("#oform").serialize(),
                    success: function(data) {

                        PNotify.success({
                            text: '<?= $this->lang->line('Outcome Data Edit Saved Successfully') ?>'
                        });
                        $("#oedit_save").attr('disabled', false);

                    }
                })

                $("#otable").DataTable().draw();
            }

        })
    })
</script>

<script>
    //ajax call for select2 plugin to user_couintry function at RegisterLogn controller

    $(document).ready(function() {
        $('#ocategory_selection').select2({
            placeholder: "Select and Search",
            ajax: {
                url: '<?= site_url('dashboard/outcome_selection') ?>',
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


        var $option = $('<option value="<?= $CategoryId ?>"><?= $Name ?></option>');
        $('#ocategory_selection').append($option).trigger('change'); // append the option and update Select2

    });
</script>