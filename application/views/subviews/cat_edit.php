<!-- category edit form -->

<form id="edit_categ_form" class="form-horizontal" type="post">


    <input name="edit_cid" type="text" hidden id="edit_categ_id" value="<?= $Id ?>">

    <div class="form-group row">
        <label for="catname" class="col-sm-6 col-form-label"><?= $this->lang->line('Category Name'); ?></label>
        <div class="col-sm-6">
            <input name="edit_categ_name" type="text" class="form-control" id="catname" placeholder="Income Name" value="<?= $Name ?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-6 col-form-label"><?= $this->lang->line('Category Type'); ?></label>
        <div class="form-group col-sm-6">
            <!-- Group of default radios - option 1 -->
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="option1" name="edit_categ_type" value="income">
                <label style="text-align: left;" class="custom-control-label" for="option1"><?= $this->lang->line('Income'); ?></label>
            </div>

            <!-- Group of default radios - option 2 -->
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="option2" name="edit_categ_type" value="outcome" checked>
                <label style="text-align: left;" class="custom-control-label" for="option2"><?= $this->lang->line('Outcome'); ?></label>
            </div>

            <!-- Group of default radios - option 3 -->
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="option3" name="edit_categ_type" value="both">
                <label style="text-align: left;" class="custom-control-label" for="option3"><?= $this->lang->line('Both'); ?></label>
            </div>

            <div class="form-group row my-2">
                <label for="edit_categ_save" class="col-sm-12"></label>
                <div class="col-sm-12">
                    <input name="edit_categ" id="edit_categ_save" class="btn btn-success" type="submit" value="<?= $this->lang->line('Save Edit'); ?>">
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // ajax call to send category edit form data to serverside for processing
        $("#edit_categ_save").on('click', function(e) {

            e.preventDefault();
            if ($('input[name=edit_categ_name]').val() == '' || $('input[name=edit_categ_type]').val() == '') {
                PNotify.error({
                    text: '<?= $this->lang->line('Missing Fields, Try Again') ?>'
                });

            } else {
                $.ajax({
                    url: "<?= site_url('dashboard/category_edit'); ?>",
                    method: "POST",
                    data: $("#edit_categ_form").serialize(),
                    success: function(data) {

                        PNotify.success({
                            text: '<?= $this->lang->line('Category Data Edit Saved Successfully') ?>'
                        });
                    }
                })
                $("#dtable").DataTable().draw();

                setTimeout(function() {
                    location.reload(true);
                }, 4000)
            }

        })
    })
</script>