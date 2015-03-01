<main>
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>خوش آمدید به این سایت</h3>
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-4">
                            <figure class="feature">
                                <span class="icon-question-answer"></span>
                                <figcaption>
                                    سوالات خود را با استاد در میان بگذارید
                                    سوالات خود را با استاد در میان بگذارید
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-md-4">
                            <figure class="feature">
                                <i class="icon-new-releases"></i>
                                <figcaption>
                                    سوالات خود را با استاد در میان بگذارید
                                    سوالات خود را با استاد در میان بگذارید
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-md-4">
                            <figure class="feature">
                                <span class="icon-file-download"></span>
                                <figcaption>
                                    سوالات خود را با استاد در میان بگذارید
                                    سوالات خود را با استاد در میان بگذارید
                                </figcaption>
                            </figure>
                        </div>

                    </div>
                </div>
                <div role="tabpanel">

                    <!-- Nav tabs -->
                    <ul id="log-reg" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#login"
                                                   aria-controls="profile" role="tab" data-toggle="tab">ورود به سایت</a></li>
                        <li role="presentation" ><a href="#register"
                                                                  aria-controls="home" role="tab" data-toggle="tab">ثبت نام در سایت</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane row active" id="login">
                            <form method="post" action="<?php echo site_url('/member/dologin');?>" class="col-md-6">
                               <div style="color: red;border: #000 solid  2px;"><?php echo $loginMsg;?></div>
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input type="text" class="form-control" id="email" placeholder="ایمیل را وارد کنید" name="login_user">
                                </div>
                                <div class="form-group">
                                    <label for="password">گذر واژه</label>
                                    <input type="password" class="form-control" id="pass" placeholder="گذرواژه را وارد کنید" name="login_pass">
                                </div>
                        <div class="checkbox">
                            <label for="remembering" dir="ltr">
                                <input type="checkbox" id="remembering" name="login_rem">مرا بخاطر بسپار
                            </label>
                        </div>
                            <button type="submit" class="btn btn-default" id="login-btn">ورود</button>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane  row" id="register">
                           <div style="color: red;border: #000 solid  2px;">
                                <?php echo validation_errors(); ?>
                                <?php echo $defTab; ?>
                            </div>
                            <form method="post" action="<?php echo site_url('/member/index');?>" class="col-md-6">
                                <div class="form-group">
                                    <label for="username">نام و نام خانوادگی</label>
                                    <input type="text" name="reg_name" class="form-control" id="username" placeholder="نام کاربری را وارد کنید"
                                           value="<?php echo set_value('reg_name'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input type="text" name="reg_email" class="form-control" id="email" placeholder="ایمیل را وارد کنید"
                                        value="<?php echo set_value('reg_email'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="pass">گذر واژه</label>
                                    <input type="password" name = "reg_password" class="form-control" id="pass" placeholder="گذرواژه را وارد کنید">
                                </div>
                                <div class="form-group">
                                    <label for="pass">تکرار گذر واژه</label>
                                    <input type="password" name = "reg_password_conf" class="form-control" id="pass_conf" placeholder="گذرواژه را تکرار کنید">
                                </div>
                                <div class="form-group">
                                    <label for="pass">دانشگاه</label>
                                    <select name = "reg_university" class="form-control">
                                        <?php
                                        foreach ($universities as $key => $value) 
                                        {
                                            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';

                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group" id="captcha_display">
                                    <script type="text/javascript">
                                        
                                        function createCaptcha()
                                        {
                                            $.get("<?php echo site_url('captcha/') ?>",'',function (data)
                                            {
                                                $('#captcha_display').html(data);
                                            });
                                            
                                        }
                                        
                                        $(document).ready(function()
                                        {
                                            createCaptcha();
                                        });
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label for="pass">کد امنیتی</label>
                                    <input type="text" name = "captcha" class="form-control" id="captcha" placeholder="">
                                </div>
                                <input type="submit" name="submit" value="ثبت نام" class="btn btn-default" id="register-btn">
                            </form>
                            <div class="info">
                            <section>
                            <h3>ٰروند ثبت نام شما در سیستم</h3>
                                <p>
                                    یکسری اطلاعات در مورد ثبت نام در اینجا قرار گیرد و دانشجو را با فرایند عضویت او در سیستم آشنا کند.
                                </p>
                            </section>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</main>