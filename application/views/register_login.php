<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transactions System</title>

  <!-- CSS -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
  <link rel="stylesheet" href="<?= site_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= site_url('assets/node_modules/@chenfengyuan/datepicker/dist/datepicker.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/css/select2.min.css' ?>">
  <link rel="stylesheet" href="<?= site_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="<?= site_url('assets/css/form-elements.css'); ?>">
  <link rel="stylesheet" href="<?= site_url('assets/css/style.css'); ?>">

  <!-- Favicon and touch icons -->
  <link rel="shortcut icon" href="assets/ico/favicon.png">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= site_url('assets/ico/apple-touch-icon-144-precomposed.png'); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= site_url('assets/ico/apple-touch-icon-114-precomposed.png'); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= site_url('assets/ico/apple-touch-icon-72-precomposed.png'); ?>">
  <link rel="apple-touch-icon-precomposed" href="<?= site_url('assets/ico/apple-touch-icon-57-precomposed.png'); ?>">

</head>

<body>
  <div class="top-content">

    <div class="inner-bg" style="background-image: url('<?= site_url('assets/img/backgrounds/1.jpg'); ?>')">
      <div class="container">

        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 text">
            <h1><strong>Transactions System</strong> Login &amp; Register Forms</h1>
            <div class="description">
              <p>This is a managing resources system for transactions</p>
            </div>
            <div style="color: greenyellow;">
              <?php if ($this->session->flashdata("register_success")) : ?>
                <?= $this->session->flashdata("register_success"); ?>
              <?php endif ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-5">

            <div class="form-box">
              <div class="form-top">
                <div class="form-top-left">
                  <h3>Login to our system</h3>
                  <p>Enter username and password to log on:</p>
                </div>
                <div class="form-top-right">
                  <i class="fa fa-lock"></i>
                </div>
              </div>
              <!-- ================================================================= -->
              <!--login form -->
              <div class="form-bottom">
                <?php echo form_open('RegisterLogin/login'); ?>
                <div class="form-group">
                  <div class="text-danger" style="color: salmon;"><?php echo form_error('user'); ?></div>
                  <label class="sr-only" for="form-username">Username</label>
                  <input type="text" name="user" placeholder="Username..." class="form-username form-control" id="form-username">
                </div>
                <div class="form-group">
                  <div class="text-danger" style="color: salmon;"><?php echo form_error('password'); ?></div>
                  <label class="sr-only" for="form-password">Password</label>
                  <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
                </div>

                <div class="form-group">
                  <label for="sel1">Select default language:</label>
                  <select name="lang-selection" class="form-control" id="sel1">
                    <option value="english">English</option>
                    <option value="arabic">Arabic</option>
                  </select>
                </div>

                <div><input class="btn btn-secondary" type="submit" value="Sign In" name="submit" /></div>
                <?= form_close() ?>
              </div>
            </div>
          </div>

          <div class="col-sm-1 middle-border"></div>
          <div class="col-sm-1"></div>

          <div class="col-sm-5">

            <div class="form-box">
              <div class="form-top">
                <div class="form-top-left">
                  <h3>Sign up now</h3>
                  <p>Fill in the form below to get instant access:</p>
                </div>
                <div class="form-top-right">
                  <i class="fa fa-pencil"></i>
                </div>
              </div>
              <!-- ================================================================= -->
              <!-- registeration form -->
              <div class="form-bottom">
                <?php echo form_open('RegisterLogin/signup'); ?>
                <?php if (isset($_POST['username'])) { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('username'); ?></div>
                    <label class="sr-only" for="form-first-name">Username</label>
                    <input type="text" name="username" value="<?= $_POST['username'] ?>" placeholder="Username..." class="form-first-name form-control" id="form-first-name">
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('username'); ?></div>
                    <label class="sr-only" for="form-first-name">Username</label>
                    <input type="text" name="username" placeholder="Username..." class="form-first-name form-control" id="form-first-name">
                  </div>
                <?php } ?>

                <?php if (isset($_POST['pass'])) { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('pass'); ?></div>
                    <label class="sr-only" for="form-pass">Password</label>
                    <input type="password" name="pass" value="<?= $_POST['pass'] ?>" placeholder="Password..." class="form-last-name form-control" id="form-pass">
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('pass'); ?></div>
                    <label class="sr-only" for="form-pass">Password</label>
                    <input type="password" name="pass" placeholder="Password..." class="form-last-name form-control" id="form-pass">
                  </div>
                <?php } ?>

                <?php if (isset($_POST['passconf'])) { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('passconf'); ?></div>
                    <label class="sr-only" for="conf-pass">Confirm Password</label>
                    <input type="password" name="passconf" value="<?= $_POST['passconf'] ?>" placeholder="Confirm Password..." class="form-last-name form-control" id="conf-pass">
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('passconf'); ?></div>
                    <label class="sr-only" for="conf-pass">Confirm Password</label>
                    <input type="password" name="passconf" placeholder="Confirm Password..." class="form-last-name form-control" id="conf-pass">
                  </div>
                <?php } ?>

                <?php if (isset($_POST['mail'])) { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('mail'); ?></div>
                    <label class="sr-only" for="form-email">Email</label>
                    <input style="height: 50px;" type="email" name="mail" value="<?= $_POST['mail'] ?>" placeholder="Email..." class="form-email form-control" id="form-email">
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('mail'); ?></div>
                    <label class="sr-only" for="form-email">Email</label>
                    <input style="height: 50px;" type="email" name="mail" placeholder="Email..." class="form-email form-control" id="form-email">
                  </div>
                <?php } ?>

                <?php if (isset($_POST['bdate'])) { ?>
                  <div class="form-group">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                      <div class="text-danger" style="color: salmon;"><?php echo form_error('bdate'); ?></div>
                      <input type="text" name="bdate" data-toggle="datepicker" style="width:100%" value="<?= $_POST['bdate'] ?>" placeholder="Birth Date...">
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                      <div class="text-danger" style="color: salmon;"><?php echo form_error('bdate'); ?></div>
                      <input type="text" name="bdate" data-toggle="datepicker" style="width:100%" placeholder="Birth Date...">
                    </div>
                  </div>
                <?php } ?>

                <?php if (isset($_POST['country'])) { ?>
                  <div class="form-group">
                    <span><strong>Select a Country</strong></span>
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('country'); ?></div>
                    <select style="width:100%" id="cbox" name="country" value="<?= $_POST['country'] ?>">
                      <!-- <option value=''></option> -->
                    </select>
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <span><strong>Select a Country</strong></span>
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('country'); ?></div>
                    <select style="width:100%" id="cbox" name="country" value="">
                      <!-- <option value=''></option> -->
                    </select>
                  </div>
                <?php } ?>

                <?php if (isset($_POST['bio'])) { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('bio'); ?></div>
                    <label class="sr-only" for="form-about-yourself">About yourself</label>
                    <textarea name="bio" value="<?= $_POST['bio'] ?>" placeholder="Write bio about yourself..." class="form-about-yourself form-control" id="form-about-yourself"></textarea>
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <div class="text-danger" style="color: salmon;"><?php echo form_error('bio'); ?></div>
                    <label class="sr-only" for="form-about-yourself">About yourself</label>
                    <textarea name="bio" placeholder="Write bio about yourself..." class="form-about-yourself form-control" id="form-about-yourself"></textarea>
                  </div>
                <?php } ?>

                <div><input class="btn btn-secondary" type="submit" value="Sign me up" name="submit" /></div>
                <!-- </form> -->
                <?php form_close() ?>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- Javascript -->
  <script src="<?= site_url('assets/js/jquery-1.11.1.min.js'); ?>"></script>
  <script src="<?= site_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
  <script src="<?= site_url('assets/js/jquery.backstretch.min.js'); ?>"></script>
  <script src="<?= site_url('assets/js/scripts.js'); ?>"></script>
  <script src="<?= site_url('assets/node_modules/@chenfengyuan/datepicker/dist/datepicker.js'); ?>"></script>
  <script src="<?= base_url() . 'assets/js/select2.min.js' ?>"></script>

  <script>
    $(document).ready(function() {
      $('#cbox').select2({
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

      $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-mm-dd'
      });
    });
  </script>

</body>

</html>