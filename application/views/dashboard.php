<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Page</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.1.5/dist/sweetalert2.min.css">
    <link href="<?= base_url() . 'assets/node_modules/pnotify/dist/PNotifyBrightTheme.css' ?>" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url() . 'assets/js/select2.min.js' ?>"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="<?= base_url() . 'assets/node_modules/pnotify/dist/iife/PNotify.js' ?>"></script>
    <script type="text/javascript" src="<?= base_url() . 'assets/node_modules/pnotify/dist/iife/PNotifyButtons.js' ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.1.5/dist/sweetalert2.min.js"></script>

    <style>
        .card {
            -moz-border-radius: 2%;
            -webkit-border-radius: 2%;
            border-radius: 2%;
            box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.08);
        }

        .profile .profile-body {
            padding: 20px;
            background: #f7f7f7;
        }

        .profile .profile-bio {
            background: #fff;
            position: relative;
            padding: 15px 10px 5px 15px;
        }

        .profile .profile-bio a {
            left: 50%;
            bottom: 20px;
            margin: -62px;
            text-align: center;
            position: absolute;
        }

        .profile .profile-bio h2 {
            margin-top: 0;
            font-weight: 200;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #585f69;
            margin-top: 5px;
            text-shadow: none;
            font-weight: normal;
            font-family: 'Open Sans', sans-serif;
        }

        h2 {
            font-size: 24px;
            line-height: 33px;
        }

        p,
        li,
        li a {
            color: #555;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .v1 {
            border-right: 2px solid black;
            height: 500px;
            margin-top: 3.4vh;
        }

        hr {
            border: 1px solid black;
        }

        #upload_image {
            margin-bottom: 2vh;
            margin-right: -2vw;
        }

        #first-half {
            margin-left: 3vw;
        }

        #second-half {
            margin-left: 3vw;
            margin-top: 2vh;
        }

        label {
            display: inline-block;
            float: left;
            clear: left;
            width: 250px;
            text-align: right;
        }

        input {
            display: inline-block;
            float: left;
        }

        #income,
        #outcome {
            margin-left: 0vw;
        }

        /* animating the tab content */
        /* .tab-content{
            animation: show-tab 1.5s ease-in-out forwards;
        }

        @keyframes show-tab{
            from{
                opacity: 0;
            }
            to{
                opacity: 1;
            }
        } */

        #select2-category_selection-results {
            overflow-y: hidden !important;
            padding: 10px !important;
        }

        #category_selection {
            width: 200px;
        }

        #select2-ocategory_selection-results {
            overflow-y: hidden !important;
            padding: 10px !important;
        }

        #ocategory_selection {
            width: 200px;
        }

        #select2-box-results {
            overflow-y: hidden !important;
            padding: 10px !important;
        }

        #box_selection {
            width: 200px;
        }
    </style>
</head>

<body>
    <!-- handling user's profile bio in the main dashboard page -->
    <btn class="form-control btn btn-warning"><a href="<?= site_url('logout') ?>"><strong><?= $this->lang->line('Logout'); ?></strong></a></btn>
    <br><br>

    <h3 class="mx-3 my-3"><?= $this->lang->line('Welcome') ?>, <span class="text-info"><?= $this->session->username ?></span></h3>
    <!-- Nav pills -->
    <ul class="nav nav-pills mx-3 my-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#income" role="tab" aria-controls="pills-home" aria-selected="true"><?= $this->lang->line('Income'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#outcome" role="tab" aria-controls="pills-home" aria-selected="true"><?= $this->lang->line('Outcome'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#category" role="tab" aria-controls="pills-home" aria-selected="true"><?= $this->lang->line('Category'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-home" aria-selected="true"><?= $this->lang->line('Profile'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#statistics" role="tab" aria-controls="pills-home" aria-selected="true"><?= $this->lang->line('Statistics'); ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- income tab -->
        <div class="tab-pane container" id="income">
            <div class="row">
                <div id="first-part" class="col-sm-12 col-md-12 col-lg-4 text-center">
                    <!-- income sources form -->
                    <?php if ($Category != []) { ?>
                        <!-- check if there is no any income or both categories inserted -->
                        <?php foreach ($Category as $cat) { ?>
                            <?php if ($cat->Type != 'income' && $cat->Type != 'both') { ?>

                                <?php continue; ?>

                                <!-- <p class='text-secondary'>There is no income categories inserted yet.. insert from category tab</p> -->


                            <?php } else { ?>

                                <form id="income_form" class="my-3" type="post">
                                    <!-- getting dynamic form fields from categories db -->
                                    <?php $i = 0; ?>
                                    <?php foreach ($Category as $key => $cat) { ?>
                                        <?php if ($cat->Type == "income" || $cat->Type == "both") { ?>

                                            <div class="form-group row my-3">
                                                <label class="col-sm-6 col-form-label"><?= $cat->Name ?></label>
                                                <?php $cat->Name = str_replace(' ', '_', $cat->Name) ?>
                                                <div class="col-sm-6">
                                                    <input name="icategory[<?= $cat->Id ?>]" type="text" class="form-control income-input" placeholder="<?= $this->lang->line('Amount'); ?>">
                                                </div>
                                            </div>

                                        <?php } ?>
                                    <?php } ?>
                                    <?php $count = $i; ?>
                                    <input id="i_count" type="text" name="count" hidden value="<?= $count ?>">
                                    <div class="form-group row my-3">
                                        <label class="col-sm-6 col-form-label" style="text-align: right;" for="income_comment"><?= $this->lang->line('Comment'); ?></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="comment_area" id="income_comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <label class="col-sm-6" style="text-align: right;" for="d_income"><?= $this->lang->line('income date'); ?></label>
                                        <div class="form-group col-sm-6">
                                            <input id="d_income" class="form-control" type="text" name="income_date" placeholder="YYYY-MM-DD">
                                            <div class="form-group input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <input style="margin-left: 13.3vw;" name="income_save" id="income_save" class="btn btn-success" type="submit" value="<?= $this->lang->line('Save'); ?>">

                                </form>
                        <?php break;
                            }
                        } ?>
                    <?php } else { ?>
                        <p>There is no any inserted categories yet, select one from category tab </p>
                    <?php } ?>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4"></div>

                <div id="second-part" class="col-sm-12 col-md-12 col-lg-4">

                    <div class="row">
                        <div class="col-sm-8">
                            <form id="excel_iform" type="post" enctype="multipart/form-data">
                                <input type="file" id="iupload_excel" name="excel_ifile" class="my-2">
                                <input name="iupload" id="iupload" class="btn btn-outline-success" type="submit" value="<?= $this->lang->line('Upload data from Excel file') ?>">
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                                <?= $this->lang->line('Search income datatable'); ?>
                            </button>
                        </div>
                    </div>

                    <!-- search income table collapse widget -->
                    <div class="collapse" id="collapseExample1">
                        <div class="card card-body">
                            <form id="isform" class="form-horizontal" action="dashboard/income_table">

                                <div class="form-group row">
                                    <label for="ibox" class="col-sm-6 col-form-label"><?= $this->lang->line('category'); ?> </label>
                                    <div class="col-sm-6">
                                        <select style="width:100%;" id="ibox" name="icat[]" multiple="multiple" value=""></select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="iamount_f" class="col-sm-6 col-form-label"><?= $this->lang->line('amount from'); ?> </label>
                                    <div class="col-sm-6">
                                        <input style="width:100%;" type="text" id="iamount_f" name="iamount_f" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="iamount_t" class="col-sm-6 col-form-label"><?= $this->lang->line('amount to'); ?> </label>
                                    <div class="col-sm-6">
                                        <input style="width:100%;" type="text" id="iamount_t" name="iamount_t" class="form-control">
                                    </div>
                                </div>

                                <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <label for="idate_f" class="col-sm-6 col-form-label"><?= $this->lang->line('date from'); ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="idate_f" name="idate_f" class="form-control">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <label for="idate_t" class="col-sm-6 col-form-label"><?= $this->lang->line('date to'); ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="idate_t" name="idate_t" class="form-control">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div style="margin-left: 10vw;">
                                    <button type="button" id="ibtn-search" class="btn btn-primary my-3"><?= $this->lang->line('Search'); ?></button> &nbsp
                                    <button type="button" id="ibtn-reset" class="btn btn-secondary my-3"><?= $this->lang->line('Reset'); ?></button>
                                </div>
                        </div>
                        </form>
                    </div>




                    <!-- data table for income resources -->
                    <h3><?= $this->lang->line('Income table as follows'); ?> </h3>

                    <table id="itable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('Income'); ?></th>
                                <th><?= $this->lang->line('Outcome'); ?></th>
                                <th><?= $this->lang->line('Date'); ?></th>
                                <th><?= $this->lang->line('Comment'); ?></th>
                                <th><?= $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-info" colspan="4" id="income_subtotal"></th>
                                <th id="income_total"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- outcome tab -->
        <div class="tab-pane container fade" id="outcome">
            <div class="row">
                <div id="first-p" class="col-sm-12 col-md-12 col-lg-4 text-center">
                    <!-- Outcome sources form -->
                    <?php if ($Category != []) { ?>
                        <!-- check if there is no any outcome or both categories inserted -->
                        <?php foreach ($Category as $cat) { ?>
                            <?php if ($cat->Type != 'outcome' && $cat->Type != 'both') { ?>

                                <?php continue; ?>

                            <?php } else { ?>

                                <form id="outcome_form" class="my-3" type="post">
                                    <!-- getting dynamic form fields from categories db -->
                                    <?php $j = 0; ?>
                                    <?php foreach ($Category as $key => $ocat) { ?>
                                        <?php if ($ocat->Type == "outcome" || $ocat->Type == "both") { ?>
                                            <div class="form-group row my-3">

                                                <label class="col-sm-6" style="text-align: right;"><?= $ocat->Name ?></label>
                                                <?php $ocat->Name = str_replace(' ', '_', $ocat->Name) ?>
                                                <div class="col-sm-6 form-group">
                                                    <input name="ocategory[<?= $ocat->Id ?>]" type="text" class="form-control outcome-input" placeholder="<?= $this->lang->line('Amount'); ?>">
                                                </div>
                                            </div>

                                        <?php } ?>
                                    <?php } ?>
                                    <?php $total = $j; ?>


                                    <div class="form-group row my-3">
                                        <label class="col-sm-6 col-form-label" style="text-align: right;" for="outcome_comment"><?= $this->lang->line('Comment'); ?></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="o_comment" id="outcome_comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <label class="col-sm-6" style="text-align: right;" for="d_outcome"><?= $this->lang->line('outcome date'); ?></label>
                                        <div class="form-group col-sm-6">
                                            <input id="d_outcome" class="form-control" type="text" name="outcome_date" placeholder="YYYY-MM-DD">
                                            <div class="form-group input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <input style="margin-left: 13.3vw;" name="outcome_save" id="outcome_save" class="btn btn-success" type="submit" value="<?= $this->lang->line('Save'); ?>">
                                </form>
                        <?php break;
                            }
                        } ?>
                    <?php } else { ?>
                        <p> <?= $this->lang->line('There is no any inserted categories yet, select one from category tab') ?> </p>
                    <?php } ?>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4"></div>
                <div id="second-p" class="col-sm-12 col-md-12 col-lg-4">


                    <div class="row">
                        <div class="col-sm-8">
                            <form id="excel_oform" type="post" enctype="multipart/form-data">
                                <input type="file" id="oupload_excel" name="excel_ofile" class="my-2">
                                <input name="oupload" id="oupload" class="btn btn-outline-success" type="submit" value="<?= $this->lang->line('Upload data from Excel file') ?>">
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                                <?= $this->lang->line('Search outcome datatable'); ?>
                            </button>
                        </div>
                    </div>

                    <!-- search income table collapse widget -->
                    <div class="collapse" id="collapseExample2">
                        <div class="card card-body">
                            <form id="osform" class="form-horizontal" action="dashboard/outcome_table">

                                <div class="form-group row">
                                    <label for="obox" class="col-sm-6 col-form-label"><?= $this->lang->line('category'); ?> </label>
                                    <div class="col-sm-6">
                                        <select style="width:100%;" id="obox" name="ocat[]" multiple="multiple" value=""></select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="oamount_f" class="col-sm-6 col-form-label"><?= $this->lang->line('amount from'); ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="oamount_f" name="oamount_f" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="oamount_t" class="col-sm-6 col-form-label"><?= $this->lang->line('amount to'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" id="oamount_t" name="oamount_t" class="form-control">
                                    </div>
                                </div>

                                <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <label for="odate_f" class="col-sm-6 col-form-label"><?= $this->lang->line('date from'); ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="odate_f" name="odate_f" class="form-control">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <label for="odate_t" class="col-sm-6 col-form-label"><?= $this->lang->line('date to'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" id="odate_t" name="odate_t" class="form-control">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div style="margin-left: 10vw;">
                                    <button type="button" id="obtn-search" class="btn btn-primary my-3"><?= $this->lang->line('Search'); ?></button> &nbsp
                                    <button type="button" id="obtn-reset" class="btn btn-secondary my-3"><?= $this->lang->line('Reset'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- data table for outcome resources -->
                    <h3><?= $this->lang->line('Outcome table as follows'); ?></h3>

                    <table id="otable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('Outcome'); ?></th>
                                <th><?= $this->lang->line('Amount'); ?></th>
                                <th><?= $this->lang->line('Date'); ?></th>
                                <th><?= $this->lang->line('Comment'); ?></th>
                                <th><?= $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-info" colspan="4" id="outcome_subtotal"></th>
                                <th id="outcome_total"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- category tab -->
        <div class="tab-pane container fade" id="category">
            <!-- selecting category info form using collpase bootstrap -->
            <div>

                <div class="row">
                    <div id="category" class="my-5">

                        <form id="categ_form" class="form-horizontal" type="post">
                            <div class="form-group row">
                                <label for="category_name" class="col-sm-6 col-form-label"><?= $this->lang->line('Category Name'); ?></label>
                                <div class="col-sm-6">
                                    <input name="categ_name" type="text" class="form-control" id="category_name" placeholder="<?= $this->lang->line('Category Name'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-6"><?= $this->lang->line('Category Type'); ?></label>

                                <div class="form-group col-sm-6">
                                    <!-- Group of default radios - option 1 -->
                                    <div class="custom-control custom-radio col-sm-12">
                                        <input type="radio" class="custom-control-input" id="type1" name="categ_type" value="income">
                                        <label style="text-align: left;" class="custom-control-label" for="type1"><?= $this->lang->line('Income'); ?></label>
                                    </div>

                                    <!-- Group of default radios - option 2 -->
                                    <div class="custom-control custom-radio col-sm-12">
                                        <input type="radio" class="custom-control-input" id="type2" name="categ_type" value="outcome" checked>
                                        <label style="text-align: left;" class="custom-control-label" for="type2"><?= $this->lang->line('Outcome'); ?></label>
                                    </div>

                                    <!-- Group of default radios - option 3 -->
                                    <div class="custom-control custom-radio col-sm-12">
                                        <input type="radio" class="custom-control-input" id="type3" name="categ_type" value="both">
                                        <label style="text-align: left;" class="custom-control-label" for="type3"><?= $this->lang->line('Both'); ?></label>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label for="categ_save" class="col-sm-12"></label>
                                        <div class="col-sm-12">
                                            <input name="categ_save" id="categ_save" class="btn btn-success col-sm-6" type="submit" value="<?= $this->lang->line('Save'); ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                    <br>
                    <hr>
                    <!-- data table for categories -->

                    <table id="dtable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('Name'); ?></th>
                                <th><?= $this->lang->line('Type'); ?></th>
                                <th><?= $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>

                    <!-- Category Modal -->
                    <div class="modal fade w-100" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel"><?= $this->lang->line('Edit User\'s Data'); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $this->lang->line('close'); ?></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Income Edit Modal -->
        <div class="modal fade w-100" id="ieditModal" role="dialog" aria-labelledby="ieditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ieditModalLabel"><?= $this->lang->line('Edit User\'s Data'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $this->lang->line('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outcome Edit Modal -->
        <div class="modal fade w-100" id="oeditModal" role="dialog" aria-labelledby="oeditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="oeditModalLabel"><?= $this->lang->line('Edit User\'s Data'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $this->lang->line('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- profile tab -->
        <div class="tab-pane container fade" id="profile">

            <div class="container bootstrap snippet">
                <div class="profile card">
                    <div class="profile-body">
                        <div class="profile-bio">
                            <div class="row">
                                <div id="first-half" class="col-md-offset-1 col-md-4 text-center">
                                    <h2 class="text-primary"><?= $this->session->username ?></h2>
                                    <div id="profile">
                                        <?php if (($Photo->Photo != "default.png")) { ?>
                                            <img width="128px" src='<?= site_url('uploads/' . $Photo->Photo) ?> ' />

                                        <?php } else { ?>
                                            <img width="128px" src=' <?= site_url('uploads/default.png') ?> ' />
                                        <?php } ?>
                                    </div><br>
                                    <!-- upload a new photo and update the profile -->
                                    <form id="upload_form" type="post" enctype="multipart/form-data">
                                        <input style="margin-left: 0.9vw" type="file" id="upload_image" name="image_file" /><br>
                                        <input name="upload" id="upload" class="btn btn-primary" type="submit" value="<?= $this->lang->line('update profile'); ?>">
                                        <button class="btn btn-danger" id="del" type="button"><?= $this->lang->line('delete image'); ?></button>
                                    </form><br><br>

                                    <h3 class="text-primary"><strong><?= $this->lang->line('Biography'); ?></strong></h3>
                                    <p class="lead"><?= $this->session->bio ?></p>
                                </div>
                                <div class="col-md-2 col-md-offset-right-1"></div>
                                <div id="second-half" class="col-md-3 col-md-offset-right-1">
                                    <h3 class="text-success text-center"><strong><?= $this->lang->line('Edit User\'s Data'); ?></strong></h3><br>
                                    <?php echo form_open('dashboard/edit', array('id' => 'profile-form')); ?>
                                    <?php if (isset($_POST['mail'])) { ?>
                                        <div class="form-group row">
                                            <div class="text-danger"><?php echo form_error('mail'); ?></div>
                                            <label class="sr-only col-sm-6" for="email"><?= $this->lang->line('Email'); ?></label>
                                            <div class="form-group col-sm-6">
                                                <input style="width: 100%" type="email" name="mail" value="<?= $_POST['mail'] ?>" placeholder="<?= $this->lang->line('Email'); ?>" class="form-email form-control" id="form-email" required>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <div class="text-danger"><?php echo form_error('mail'); ?></div>
                                            <label class="sr-only col-sm-6" for="mail"><?= $this->lang->line('Email'); ?></label>
                                            <div class="form-group col-sm-6">
                                                <input id="mail" style="width: 200%" type="email" name="mail" placeholder="<?= $this->lang->line('Email'); ?>" class="form-email form-control" id="form-email" value="<?= $data->Email ?>" required>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($_POST['pass'])) { ?>
                                        <div class="form-group row">
                                            <div class="text-danger"><?php echo form_error('pass'); ?></div>
                                            <label class="sr-only col-sm-6" for="form-pass"><?= $this->lang->line('Password'); ?></label>
                                            <div class="form-group col-sm-6">
                                                <input style="width:200%" type="password" name="pass" value="<?= $_POST['pass'] ?>" placeholder="<?= $this->lang->line('Password'); ?>" class="form-last-name form-control" id="form-pass">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <div class="text-danger"><?php echo form_error('pass'); ?></div>
                                            <label class="sr-only col-sm-6" for="pass">Password</label>
                                            <div class="form-group col-sm-6">
                                                <input style="width:200%" id="pass" type="password" name="pass" placeholder="<?= $this->lang->line('Password'); ?>" class="form-last-name form-control">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($_POST['passconf'])) { ?>
                                        <div class="form-group row">
                                            <div class="text-danger"><?php echo form_error('passconf'); ?></div>
                                            <label class="sr-only col-sm-6" for="conf-pass"><?= $this->lang->line('Confirm Password'); ?></label>
                                            <div class="form-group col-sm-6">
                                                <input style="width:200%" type="password" name="passconf" value="<?= $_POST['passconf'] ?>" placeholder="<?= $this->lang->line('Confirm Password'); ?>" class="form-last-name form-control" id="conf-pass">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <div class="text-danger"><?php echo form_error('passconf'); ?></div>
                                            <label class="sr-only col-sm-6" for="passconf"><?= $this->lang->line('Confirm Password'); ?></label>
                                            <div class="form-group col-sm-6">
                                                <input style="width:200%" id="passconf" type="password" name="passconf" placeholder="<?= $this->lang->line('Confirm Password'); ?>" class="form-last-name form-control">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($_POST['bdate'])) { ?>
                                        <div class="form-group">
                                            <div class="input-group date row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                                <div class="text-danger"><?php echo form_error('bdate'); ?></div>
                                                <label class="sr-only col-sm-6" for="bdate"><?= $this->lang->line('Birth Date'); ?></label>
                                                <div class="form-group col-sm-6">
                                                    <input class="form-control" id="bdate" type="text" name="bdate" style="width:238%" value="<?= $_POST['bdate'] ?>" placeholder="<?= $this->lang->line('Birth Date'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group">
                                            <div class="input-group date row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                                <div class="text-danger"><?php echo form_error('bdate'); ?></div>
                                                <label class="sr-only col-sm-6" for="birth_date">Birth Date</label>
                                                <div class="form-group col-sm-6">
                                                    <input class="form-control" id="birth_date" type="text" name="bdate" style="width:238%" placeholder="<?= $this->lang->line('Birth Date'); ?>" value="<?= $data->BirthDate ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($_POST['country'])) { ?>
                                        <div class="form-group row">
                                            <label class="sr-only col-sm-6" for="box">Select a country</label>
                                            <div class="text-danger"><?php echo form_error('country'); ?></div>
                                            <div class="form-group col-sm-6">
                                                <select style="width:200%" id="box" name="country" value="<?= $_POST['country'] ?>">
                                                    <!-- <option value=''></option> -->
                                                </select>
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label class="sr-only col-sm-6" for="box">Select a country</label>
                                            <div class="text-danger"><?php echo form_error('country'); ?></div>
                                            <div class="form-group col-sm-6">
                                                <select style="width:200%" id="box" name="country">
                                                    <!-- <option value=''></option> -->
                                                </select>
                                            </div>

                                        </div>
                                    <?php } ?>
                                    <input name="save" id="save" class="btn btn-success" type="submit" value="<?= $this->lang->line('Save'); ?>">
                                    <?= form_close() ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- statistics tab -->
        <div class="tab-pane container fade" style="width:100%; height:400px;" id="statistics">
            <div>
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
                    <?= $this->lang->line('filter income statistics') ?>
                </button>
            </div>
            <div class="d-flex justify-content-center">

                <div class="collapse" id="collapseExample3">
                    <div class="card card-body">
                        <form id="siform" class="form-horizontal" action="dashboard/income_statistics">
                            <div class="form-group row">
                                <label for="sibox" class="col-sm-6 col-form-label"><?= $this->lang->line('category') ?></label>
                                <div class="col-sm-6">
                                    <select style="width:100%;" id="sibox" name="sicat[]" multiple="multiple" value=""></select>
                                </div>
                            </div>

                            <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <label for="sidate_f" class="col-sm-6 col-form-label"><?= $this->lang->line('date from') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="sidate_f" name="sidate_f" class="form-control">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <label for="sidate_t" class="col-sm-6 col-form-label"><?= $this->lang->line('date to') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="sidate_t" name="sidate_t" class="form-control">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left: 10vw;">
                                <button type="button" id="sibtn-search" class="btn btn-primary my-3"><?= $this->lang->line('Search') ?></button> &nbsp
                                <button type="button" id="sibtn-reset" class="btn btn-secondary my-3"><?= $this->lang->line('Reset') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="istatistics" class="row">

            </div> <br>
            <hr><br>

            <div>
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                    <?= $this->lang->line('filter outcome statistics') ?>
                </button>
            </div>
            <div class="d-flex justify-content-center">

                <div class="collapse" id="collapseExample4">
                    <div class="card card-body">
                        <form id="soform" class="form-horizontal" action="dashboard/outcome_statistics">
                            <div class="form-group row">
                                <label for="sobox" class="col-sm-6 col-form-label"><?= $this->lang->line('category') ?></label>
                                <div class="col-sm-6">
                                    <select style="width:100%;" id="sobox" name="socat[]" multiple="multiple" value=""></select>
                                </div>
                            </div>

                            <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <label for="sodate_f" class="col-sm-6 col-form-label"><?= $this->lang->line('date from') ?> </label>
                                <div class="col-sm-6">
                                    <input type="text" id="sodate_f" name="sodate_f" class="form-control">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="date form-group row" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <label for="sodate_t" class="col-sm-6 col-form-label"><?= $this->lang->line('date to') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="sodate_t" name="sodate_t" class="form-control">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left: 10vw;">
                                <button type="button" id="sobtn-search" class="btn btn-primary my-3"><?= $this->lang->line('Search') ?></button> &nbsp
                                <button type="button" id="sobtn-reset" class="btn btn-secondary my-3"><?= $this->lang->line('Reset') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="ostatistics" class="row">


            </div>
        </div>



    </div>


    <script>
        // sending data through ajax call to the ajax_upload function in the dashboard controller
        $(document).ready(function() {

            $("#upload_form").on('submit', function(e) {
                e.preventDefault();
                if ($('#upload_image').val() == '') {
                    PNotify.error({
                        text: '<?= $this->lang->line('Try Again, Select a valid file') ?>'
                    });
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/ajax_upload'); ?>",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            // $("#uploaded_image").html(data);
                            // $("#profile").html(data);
                            location.reload(true);
                        }
                    })
                }
            })

            //validate upload for income excel sheet
            $("#excel_iform").on('submit', function(e) {
                e.preventDefault();
                if ($('#iupload_excel').val() == '') {
                    PNotify.error({
                        text: '<?= $this->lang->line('Try Again, Select a valid file') ?>'
                    });
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/excel_iupload'); ?>",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(resp) {
                            if (resp == false) {
                                PNotify.error({
                                    text: "record duplicated",
                                    delay: 12000,
                                });
                            } else {
                                PNotify.success({
                                    text: resp,
                                    delay: 12000,
                                });
                            }
                        }

                    })
                    setTimeout(function() {
                        $('#itable').DataTable().draw();
                    }, 1500)
                }

            })

            //validate upload for income excel sheet
            $("#excel_oform").on('submit', function(e) {
                e.preventDefault();
                if ($('#oupload_excel').val() == '') {
                    PNotify.error({
                        text: '<?= $this->lang->line('Try Again, Select a valid file') ?>'
                    });
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/excel_oupload'); ?>",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(resp) {
                            if (resp == false) {
                                PNotify.error({
                                    text: "record duplicated",
                                    delay: 12000,
                                });
                            } else {
                                PNotify.success({
                                    text: resp,
                                    delay: 12000,
                                });
                            }

                        }
                    })
                    setTimeout(function() {
                        $('#otable').DataTable().draw();
                    }, 1500)
                }

            })

            // triggering reset_img function at the dashboard controller to delete profile image
            $("#del").on('click', function() {
                $.ajax({
                    url: "<?= site_url('dashboard/reset_img'); ?>",
                    method: "POST",
                    data: {
                        Photo: "default.png",
                    },

                    success: function(data) {
                        // $("#profile").html(data);
                        location.reload(true);
                    }
                })
            })

            $("#save").on("click", function(e) {
                e.preventDefault();
                if ($('#mail').val() == '' || $('#birth_date').val() == '' || $('#box').val() == '') {
                    PNotify.error({
                        text: '<?= $this->lang->line('Missing Fields, Try Again') ?>'
                    });
                } else if ($('input[name=pass]').val().length != $('input[name=passconf]').val().length) {
                    PNotify.error({
                        text: '<?= $this->lang->line('password not matching') ?>'
                    });
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/edit'); ?>",
                        method: "POST",
                        data: $("#profile-form").serialize(),
                        success: function(data) {
                            if (data) {
                                PNotify.error({
                                    text: data
                                });
                            } else {
                                PNotify.success({
                                    text: '<?= $this->lang->line('User\'s Data Saved Successfully') ?>'
                                });
                            }


                        }
                    })
                }
            })

            // ajax call to send category form data to serverside for processing
            $("#categ_save").on('click', function(e) {
                e.preventDefault();
                if ($('input[name=categ_name]').val() == '' || $('input[name=categ_type]').val() == '') {
                    PNotify.error({
                        text: '<?= $this->lang->line('Missing Fields, Try Again') ?>'
                    })
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/category'); ?>",
                        method: "POST",
                        data: $("#categ_form").serialize(),
                        success: function(data) {
                            PNotify.success({
                                text: '<?= $this->lang->line('Category Data Saved Successfully') ?>'
                            });
                            setTimeout(function() {
                                location.reload(true);
                            }, 3500)

                        }
                    })
                    //refresh page after 4 seconds, from inserting new category
                    setTimeout(function() {
                        location.reload(true);
                    }, 4000)
                }

            })

            // ajax call to send income form data to serverside for processing

            $("#income_save").on('click', function(e) {
                e.preventDefault();
                if ($("#income_comment").val() == "" || $("#d_income").val() == "") {
                    PNotify.error({
                        text: '<?= $this->lang->line('Missing Fields or NOT valid income fields marked in red, Try Again') ?>'
                    });
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/income'); ?>",
                        method: "POST",
                        data: $("#income_form").serialize(),
                        success: function(data) {
                            $("#income_form").find("input[type=text],input[type=number],textarea").val("");
                            PNotify.success({
                                text: '<?= $this->lang->line('Income Data Saved Successfully') ?>'
                            });
                            //insert income subtotal into income table footer
                            $.ajax({
                                url: '<?= site_url('dashboard/income_subtotal') ?>',
                                context: document.body
                            }).done(function(resp) {
                                $('#income_subtotal').html(resp);
                            });
                        }
                    })
                }


            })

            // ajax call to send outcome form data to serverside for processing

            $("#outcome_save").on('click', function(e) {
                e.preventDefault();
                if ($("#outcome_comment").val() == " " || $("#d_outcome").val() == "") {
                    PNotify.error({
                        text: '<?= $this->lang->line('Missing Fields or NOT valid outcome fields marked in red, Select outcome categories') ?>'
                    });
                } else {
                    $.ajax({
                        url: "<?= site_url('dashboard/outcome'); ?>",
                        method: "POST",
                        data: $("#outcome_form").serialize(),
                        success: function(data) {
                            $("#outcome_form").find("input[type=text],input[type=number],textarea").val("");
                            PNotify.success({
                                text: '<?= $this->lang->line('Outcome Data Saved Successfully') ?>'
                            });
                            //insert outcome subtotal into outcome table footer
                            $.ajax({
                                url: '<?= site_url('dashboard/outcome_subtotal') ?>',
                                context: document.body
                            }).done(function(resp) {
                                $('#outcome_subtotal').html(resp);
                            });

                        }
                    })
                }

            })

        })
    </script>

    <script>
        //ajax call for select2 plugin to user_couintry function at RegisterLogn controller

        $(document).ready(function() {
            $('#box').select2({
                placeholder: "Select and Search",
                ajax: {
                    url: '<?= site_url('RegisterLogin/user_country') ?>',
                    type: 'post',
                    dataType: 'json',
                    delay: 250,
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

            //select2 elements begin count from 0
            var $option = $('<option value="<?= $Country[0]->Id ?>"><?= $Country[0]->Name ?></option>');
            $('#box').append($option).trigger('change');
        });
    </script>

    <script>
        $(document.body).on("click", "a[href='#category']", function(event) {
            //category table
            var table = $('#dtable').DataTable({
                dom: 'Bfrtip',
                retrieve: true,
                buttons: ['copy', 'excel', 'csv'],
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                "searching": false,

                // Load data from an Ajax source
                "ajax": {
                    "url": "<?= base_url() . 'dashboard/data_table' ?>",
                    "type": "POST",
                    // "data": function(params) {
                    //     params.name = $('input[name=categ_name]').val();
                    //     params.type = $("input[name=categ_type]").val();
                    // }

                },
                "columns": [{
                        "data": "Name"
                    },
                    {
                        "data": "Type"
                    },
                    {
                        "data": "action"
                    }
                ]

            })

            //redraw table after 2 and a half seconds
            $("#categ_save").on('click', function() {
                setTimeout(function() {
                    table.draw();
                }, 500)
            })

            $("body").on('click', '.delcat', function() {
                setTimeout(function() {
                    table.draw();
                }, 2500)
            })

        });

        if (location.hash == '#category') {
            //category table
            var table = $('#dtable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv'],
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                "searching": false,

                // Load data from an Ajax source
                "ajax": {
                    "url": "<?= base_url() . 'dashboard/data_table' ?>",
                    "type": "POST",
                    // "data": function(params) {
                    //     params.name = $('input[name=categ_name]').val();
                    //     params.type = $("input[name=categ_type]").val();
                    // }

                },
                "columns": [{
                        "data": "Name"
                    },
                    {
                        "data": "Type"
                    },
                    {
                        "data": "action"
                    }
                ]

            })

            //redraw table after 2 and a half seconds
            $("#categ_save").on('click', function() {
                setTimeout(function() {
                    table.draw();
                }, 500)
            })

            $("body").on('click', '.delcat', function() {
                setTimeout(function() {
                    table.draw();
                }, 2500)
            })
        }
    </script>

    <script>
        $(document.body).on("click", "a[href='#income']", function(event) {
            //income table
            var itable = $('#itable').DataTable({
                dom: 'Bfrtip',
                retrieve: true,
                buttons: ['copy', 'csv', 'excel', 'pdf'],
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                "searching": false,

                // Load data from an Ajax source
                "ajax": {
                    "url": "<?= base_url() . 'dashboard/income_table' ?>",
                    "type": "POST",
                    //sending data to be processed in income controller
                    "data": function(params) {
                        params.icat = $("#ibox").val();
                        params.iamount_f = $("#iamount_f").val();
                        params.iamount_t = $("#iamount_t").val();
                        params.idate_f = $("#idate_f").val();
                        params.idate_t = $("#idate_t").val();
                    }

                },
                "columns": [{
                        "data": "Income"
                    },
                    {
                        "data": "Amount"
                    },
                    {
                        "data": "Date"
                    },
                    {
                        "data": "Comment"
                    },
                    {
                        "data": "action"
                    }
                ],

            })

            //income search
            $("#ibtn-search").on('click', function() {

                itable.draw();
                $.ajax({
                    url: '<?= site_url('dashboard/income_subtotal') ?>',
                    data: $("#isform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#income_subtotal').html(resp);
                });

            });

            //income statisics search
            $("#sibtn-search").on('click', function() {

                $.ajax({
                    url: '<?= site_url('dashboard/income_statistics') ?>',
                    data: $("#siform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#istatistics').html(resp);
                });

            });

            //reset button for income datatable search
            $("#ibtn-reset").on('click', function() {
                $("#ibox").val('').trigger('change');
                $("#iamount_f").val("");
                $("#iamount_t").val("");
                $("#idate_f").val("");
                $("#idate_t").val("");

                itable.draw();

            });

            //reset button for income datatable search
            $("#sibtn-reset").on('click', function() {
                $("#sibox").val('').trigger('change');
                $("#siamount_f").val("");
                $("#siamount_t").val("");
                $("#sidate_f").val("");
                $("#sidate_t").val("");
            });

            //redraw table after 2 and a half seconds after income save
            $("#income_save").on('click', function() {
                setTimeout(function() {
                    itable.draw();
                }, 2500)
            })

            //redraw table after 2 and a half seconds after income edit save
            $("body").on('click', '#iedit_save', function() {
                setTimeout(function() {
                    itable.draw();
                }, 2500)
            })

            $("body").on('click', '.delin', function() {
                setTimeout(function() {
                    itable.draw();
                }, 2500)
            })

        });

        if (location.hash == '#income') {
            //income table
            var itable = $('#itable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf'],
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                "searching": false,

                // Load data from an Ajax source
                "ajax": {
                    "url": "<?= base_url() . 'dashboard/income_table' ?>",
                    "type": "POST",
                    //sending data to be processed in income controller
                    "data": function(params) {
                        params.icat = $("#ibox").val();
                        params.iamount_f = $("#iamount_f").val();
                        params.iamount_t = $("#iamount_t").val();
                        params.idate_f = $("#idate_f").val();
                        params.idate_t = $("#idate_t").val();
                    }

                },
                "columns": [{
                        "data": "Income"
                    },
                    {
                        "data": "Amount"
                    },
                    {
                        "data": "Date"
                    },
                    {
                        "data": "Comment"
                    },
                    {
                        "data": "action"
                    }
                ],

            })

            //income search
            $("#ibtn-search").on('click', function() {

                itable.draw();
                $.ajax({
                    url: '<?= site_url('dashboard/income_subtotal') ?>',
                    data: $("#isform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#income_subtotal').html(resp);
                });

            });

            //income statisics search
            $("#sibtn-search").on('click', function() {

                $.ajax({
                    url: '<?= site_url('dashboard/income_statistics') ?>',
                    data: $("#siform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#istatistics').html(resp);
                });

            });

            //reset button for income datatable search
            $("#ibtn-reset").on('click', function() {
                $("#ibox").val('').trigger('change');
                $("#iamount_f").val("");
                $("#iamount_t").val("");
                $("#idate_f").val("");
                $("#idate_t").val("");

                itable.draw();

            });

            //reset button for income datatable search
            $("#sibtn-reset").on('click', function() {
                $("#sibox").val('').trigger('change');
                $("#siamount_f").val("");
                $("#siamount_t").val("");
                $("#sidate_f").val("");
                $("#sidate_t").val("");
            });

            //redraw table after 2 and a half seconds after income save
            $("#income_save").on('click', function() {
                setTimeout(function() {
                    itable.draw();
                }, 2500)
            })

            //redraw table after 2 and a half seconds after income edit save
            $("body").on('click', '#iedit_save', function() {
                setTimeout(function() {
                    itable.draw();
                }, 2500)
            })

            $("body").on('click', '.delin', function() {
                setTimeout(function() {
                    itable.draw();
                }, 2500)
            })
        }
    </script>


    <script>
        $(document.body).on("click", "a[href='#outcome']", function(event) {

            //outcome table
            var otable = $('#otable').DataTable({
                dom: 'Bfrtip',
                retrieve: true,
                buttons: ['copy', 'csv', 'excel', 'pdf'],
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                "searching": false,

                // Load data from an Ajax source
                "ajax": {
                    "url": "<?= base_url() . 'dashboard/outcome_table' ?>",
                    "type": "POST",
                    "data": function(params) {
                        params.ocat = $("#obox").val();
                        params.oamount_f = $("#oamount_f").val();
                        params.oamount_t = $("#oamount_t").val();
                        params.odate_f = $("#odate_f").val();
                        params.odate_t = $("#odate_t").val();
                    }

                },
                "columns": [{
                        "data": "Outcome"
                    },
                    {
                        "data": "Amount"
                    },
                    {
                        "data": "Date"
                    },
                    {
                        "data": "Comment"
                    },
                    {
                        "data": "action"
                    }
                ],

            })

            $("#obtn-search").on('click', function() {
                otable.draw();
                $.ajax({
                    url: '<?= site_url('dashboard/outcome_subtotal') ?>',
                    data: $("#osform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#outcome_subtotal').html(resp);
                });
            });

            $("#obtn-reset").on('click', function() {
                $("#obox").val('').trigger('change');
                $("#oamount_f").val("");
                $("#oamount_t").val("");
                $("#odate_f").val("");
                $("#odate_t").val("");
                otable.draw();
            });

            //outcome statisics search
            $("#sobtn-search").on('click', function() {

                $.ajax({
                    url: '<?= site_url('dashboard/outcome_statistics') ?>',
                    data: $("#soform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#ostatistics').html(resp);
                });

            });

            //reset button for income datatable search
            $("#sobtn-reset").on('click', function() {
                $("#sobox").val('').trigger('change');
                $("#soamount_f").val("");
                $("#soamount_t").val("");
                $("#sodate_f").val("");
                $("#sodate_t").val("");
            });

            //redraw table after 2 and a half seconds after outcome save
            $("#outcome_save").on('click', function() {
                setTimeout(function() {
                    otable.draw();
                }, 2500)
            })

            //redraw table after 2 and a half seconds after outcome edit save
            $("body").on('click', '#oedit_save', function() {
                setTimeout(function() {
                    otable.draw();
                }, 2500)
            })

            $("body").on('click', '.delout', function() {
                setTimeout(function() {
                    otable.draw();
                }, 2500)
            })


        });

        if (location.hash == '#outcome') {
            //outcome table
            var otable = $('#otable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf'],
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                "searching": false,

                // Load data from an Ajax source
                "ajax": {
                    "url": "<?= base_url() . 'dashboard/outcome_table' ?>",
                    "type": "POST",
                    "data": function(params) {
                        params.ocat = $("#obox").val();
                        params.oamount_f = $("#oamount_f").val();
                        params.oamount_t = $("#oamount_t").val();
                        params.odate_f = $("#odate_f").val();
                        params.odate_t = $("#odate_t").val();
                    }

                },
                "columns": [{
                        "data": "Outcome"
                    },
                    {
                        "data": "Amount"
                    },
                    {
                        "data": "Date"
                    },
                    {
                        "data": "Comment"
                    },
                    {
                        "data": "action"
                    }
                ],

            })

            $("#obtn-search").on('click', function() {
                otable.draw();
                $.ajax({
                    url: '<?= site_url('dashboard/outcome_subtotal') ?>',
                    data: $("#osform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#outcome_subtotal').html(resp);
                });
            });

            $("#obtn-reset").on('click', function() {
                $("#obox").val('').trigger('change');
                $("#oamount_f").val("");
                $("#oamount_t").val("");
                $("#odate_f").val("");
                $("#odate_t").val("");
                otable.draw();
            });

            //outcome statisics search
            $("#sobtn-search").on('click', function() {

                $.ajax({
                    url: '<?= site_url('dashboard/outcome_statistics') ?>',
                    data: $("#soform").serialize(),
                    context: document.body
                }).done(function(resp) {
                    $('#ostatistics').html(resp);
                });

            });

            //reset button for income datatable search
            $("#sobtn-reset").on('click', function() {
                $("#sobox").val('').trigger('change');
                $("#soamount_f").val("");
                $("#soamount_t").val("");
                $("#sodate_f").val("");
                $("#sodate_t").val("");
            });

            //redraw table after 2 and a half seconds after outcome save
            $("#outcome_save").on('click', function() {
                setTimeout(function() {
                    otable.draw();
                }, 2500)
            })

            //redraw table after 2 and a half seconds after outcome edit save
            $("body").on('click', '#oedit_save', function() {
                setTimeout(function() {
                    otable.draw();
                }, 2500)
            })

            $("body").on('click', '.delout', function() {
                setTimeout(function() {
                    otable.draw();
                }, 2500)
            })
        }
    </script>

    <script>
        $(document).ready(function() {

            //delete category if not used by neither income nor outcome
            $('body').on('click', '.delcat', function(e) {

                Swal.fire({
                    title: '<?= $this->lang->line('Are you sure?') ?>',
                    text: '<?= $this->lang->line('You won\'t be able to revert this!') ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?= $this->lang->line('Yes, delete it!') ?>',
                }).then((result) => {
                    if (result.value) {
                        del_id = $(e.target).attr("id");
                        $.post("<?= base_url() . 'dashboard/delete_category/' ?>" + del_id, {
                            'del_id': del_id,

                        }, function(resp) {

                            if (resp) {
                                PNotify.error({
                                    text: resp
                                });
                            } else {
                                PNotify.success({
                                    text: '<?= $this->lang->line('Category Deleted Successfully') ?>'
                                });
                            }
                        })
                    } else {
                        PNotify.info({
                            text: '<?= $this->lang->line('Deletion Process Canceled') ?>'
                        });
                    }
                })

            })

            //delete income transaction if not used by neither income nor outcome
            $('body').on('click', '.delin', function(e) {

                Swal.fire({
                    title: '<?= $this->lang->line('Are you sure?') ?>',
                    text: '<?= $this->lang->line('You won\'t be able to revert this!') ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?= $this->lang->line('Yes, delete it!') ?>'
                }).then((result) => {
                    if (result.value) {
                        del_tid = $(e.target).attr("id");
                        $.post("<?= base_url() . 'dashboard/delete_transaction/' ?>" + del_tid, {
                            'del_tid': del_tid,

                        }, function(data) {

                            PNotify.success({
                                text: '<?= $this->lang->line('Income Transaction Deleted successfully') ?>'
                            });

                            $.ajax({
                                url: '<?= site_url('dashboard/income_subtotal') ?>',
                                context: document.body
                            }).done(function(resp) {
                                $('#income_subtotal').html(resp);
                            });
                        })
                    } else {
                        PNotify.info({
                            text: '<?= $this->lang->line('Deletion Process Canceled') ?>'
                        });
                    }
                })
            })

            //delete outcome transaction if not used by neither income nor outcome
            $('body').on('click', '.delout', function(e) {

                Swal.fire({
                    title: '<?= $this->lang->line('Are you sure?') ?>',
                    text: '<?= $this->lang->line('You won\'t be able to revert this!') ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?= $this->lang->line('Yes, delete it!') ?>'
                }).then((result) => {
                    if (result.value) {
                        del_tid = $(e.target).attr("id");
                        $.post("<?= base_url() . 'dashboard/delete_transaction/' ?>" + del_tid, {
                            'del_tid': del_tid,

                        }, function(data) {

                            PNotify.success({
                                text: '<?= $this->lang->line('Outcome Transaction Deleted successfully') ?>'
                            });

                            $.ajax({
                                url: '<?= site_url('dashboard/outcome_subtotal') ?>',
                                context: document.body
                            }).done(function(resp) {
                                $('#outcome_subtotal').html(resp);
                            });
                        })
                    } else {
                        PNotify.info({
                            text: '<?= $this->lang->line('Deletion Process Canceled') ?>'
                        });
                    }
                })

            })


            //using event delegation handler by passing the delegated target element as 2nd key param
            $('body').on('click', '.edit', function(e) {
                id = $(e.target).attr("id");
                $.post("<?= base_url() . 'dashboard/get_category/' ?>" + id, {
                    'id': id,

                }, function(resp) {
                    $('#editModal .modal-body').html(resp);
                    $('#editModal').modal('show');
                    // $("#edit_categ_id").val(id);
                })
            })

            //edit income data
            $('body').on('click', '.iedit', function(e) {
                iid = $(e.target).attr("id");
                $("input[name=income_id]").val(iid);
                $.post("<?= base_url() . 'dashboard/get_income/' ?>" + iid, {
                    'iid': iid,
                }, function(resp) {
                    $('#ieditModal .modal-body').html(resp);
                    $('#ieditModal').modal('show');
                })
            })

            //edit outcome data
            $('body').on('click', '.oedit', function(e) {
                oid = $(e.target).attr("id");
                $("input[name=outcome_id]").val(oid);
                $.post("<?= base_url() . 'dashboard/get_outcome/' ?>" + oid, {
                    'oid': oid
                }, function(resp) {
                    $('#oeditModal .modal-body').html(resp);
                    $('#oeditModal').modal('show');
                })
            })

        });
    </script>

    <script>
        //select2 for categories income search fields
        $(document).ready(function() {
            $('#ibox, #sibox').select2({
                placeholder: "Select and Search",
                tags: "true",
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

        });
    </script>

    <script>
        //select2 for categories outcome search fields
        $(document).ready(function() {
            $('#obox, #sobox').select2({
                placeholder: "Select and Search",
                tags: "true",
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

        });
    </script>

    <script>
        $(document.body).on("click", "a[href='#income']", function(event) {
            //insert income subtotal into income table footer

            $.ajax({
                url: '<?= site_url('dashboard/income_subtotal') ?>',
                context: document.body
            }).done(function(resp) {
                $('#income_subtotal').html(resp);
            });

        })

        $(document.body).on("click", "a[href='#outcome']", function(event) {
            //insert outcome subtotal into outcome table footer

            $.ajax({
                url: '<?= site_url('dashboard/outcome_subtotal') ?>',
                context: document.body
            }).done(function(resp) {
                $('#outcome_subtotal').html(resp);
            });
        })

        if (location.hash == '#income') {
            $.ajax({
                url: '<?= site_url('dashboard/income_subtotal') ?>',
                context: document.body
            }).done(function(resp) {
                $('#income_subtotal').html(resp);
            });

        }

        if (location.hash == '#outcome') {

            //insert outcome subtotal into outcome table footer
            $.ajax({
                url: '<?= site_url('dashboard/outcome_subtotal') ?>',
                context: document.body
            }).done(function(resp) {
                $('#outcome_subtotal').html(resp);
            });
        }
    </script>

    <!-- <script>
        //Highcharts demo sample
        document.addEventListener('DOMContentLoaded', function() {
            var myChart = Highcharts.chart('statistics-data', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Fruit Consumption'
                },
                // xAxis: {
                //     categories: ['Apples', 'Bananas', 'Oranges']
                // },
                // yAxis: {
                //     title: {
                //         text: 'Fruit eaten'
                //     }
                // },
                series: [{
                    name: 'Jane',
                    data: [1, 0, 4]
                }, {
                    name: 'John',
                    data: [5, 7, 3]
                }]

            });
        });
    </script> -->

    <!-- =========================================================================== -->
    <!-- income statistics part -->
    <script>
        //load data for income in statistics tab when tab is clicked

        $(document.body).on("click", "a[href='#statistics']", function(event) {
            $.ajax({
                url: '<?= site_url('dashboard/income_statistics') ?>',
                context: document.body
            }).done(function(resp) {
                $('#istatistics').html(resp);
            });
        });
        //load data for income in statistics when its an active after reload

        if (location.hash == '#statistics') {
            $.ajax({
                url: '<?= site_url('dashboard/income_statistics') ?>',
                context: document.body
            }).done(function(resp) {
                $('#istatistics').html(resp);
            });
        }
    </script>


    <!-- =================================================================================== -->

    <!-- outcome statistics part -->

    <script>
        //load data for outcome in statistics tab when tab is clicked
        $(document.body).on("click", "a[href='#statistics']", function(event) {
            //insert outcome subtotal into income table footer
            $.ajax({
                url: '<?= site_url('dashboard/outcome_statistics') ?>',
                context: document.body
            }).done(function(resp) {
                $('#ostatistics').html(resp);
            });
            //load data for outcome in statistics when its an active after reload

            if (location.hash == '#statistics') {
                $.ajax({
                    url: '<?= site_url('dashboard/income_statistics') ?>',
                    context: document.body
                }).done(function(resp) {
                    $('#istatistics').html(resp);
                });
            }

        })
    </script>


    <script>
        //fix active tabs when page reloads 
        $(document).ready(function() {
            if (location.hash) {
                $("a[href='" + location.hash + "']").tab("show");
            }
            $(document.body).on("click", "a[data-toggle='pill']", function(event) {
                location.hash = this.getAttribute("href");
            });
        });
        $(window).on("popstate", function() {
            var anchor = location.hash || $("a[data-toggle='pill']").first().attr("href");
            $("a[href='" + anchor + "']").tab("show");
        });
    </script>




</body>

</html>