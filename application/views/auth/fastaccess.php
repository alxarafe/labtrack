<?php echo form_open('/'); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title"><?= $title ?></h1>
                <div class="account-wall">
                    <?php
                    if (isset($message)) echo $message;
                    echo form_error('username'); ?>
                    <input name="username" type="text" class="form-control" value="<?php echo set_value('username') ?>"
                           placeholder="<?php echo lang('form_username') ?>" required autofocus>
                    <button class="btn btn-lg btn-primary btn-block"
                            type="submit"><?php echo lang('form_submit') ?></button>
                </div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>