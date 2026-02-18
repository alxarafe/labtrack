<?php echo form_open('auth/reset'); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title"><?php echo lang('auth_password_lost') ?></h1>
                <div class="account-wall">
                    <img class="profile-img"
                         src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                         alt="">
                    <form class="form-signin">
                        <?php
                        if (isset($message)) {
                            echo $message;
                        }
                        echo form_error('mail_name'); ?>
                        <input name="mail_name" type="text" class="form-control"
                               value="<?php echo set_value('username') ?>"
                               placeholder="<?php echo lang('form_user_or_email') ?>" required autofocus>
                        <button class="btn btn-lg btn-primary btn-block"
                                type="submit"><?php echo lang('form_recover') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>