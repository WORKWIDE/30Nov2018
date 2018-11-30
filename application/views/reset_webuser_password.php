<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/ico" sizes="16x16"> 
        <title><?php echo TITLE; ?> | Login </title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/icheck/flat/green.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
          <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <!--[if lt IE 9]>
              <script src="../assets/js/ie8-responsive-file-warning.js"></script>
              <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
              <![endif]-->

        <script>
            $(document).ready(function () {
                $("#login_error").css("display", "none");
            <?php if ($this->session->flashdata('error')) { ?>

                                $('#login_error').html('<?php echo $this->session->flashdata('error'); ?>').css("display", "block");
                                setTimeout(function () {
                                    $('#login_error').fadeOut('fast');
                                }, 3000);
                                //$("#login_error").css("display", "block");

            <?php } ?>
            });
        </script>
    </head>
    <style>
        .logoimage{
            /*border: 1px solid #ddd;*/
            /*border-radius: 2px;*/
            padding: 1px;
/*            width: 70px;*/
            height: 70px;
        }
     </style>
    <body style="background:#F7F7F7;">

        <div class="">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>

            <div id="wrapper">
                <div id="login" class="animate form">
                    <section class="login_content">
                        <?php echo form_open('resetpassword/' . $code,array('id' => 'change_password_form', 'class' => 'change_password_form')); ?> 
                            <h1>Change Password </h1>
                            <div>
                                <label> New Password</label>
                                <?php echo form_input($new_password);?>
                                <div id="errorpassword"> </div>
                            <div class="errorTxtnew"></div>

                            </div>
                            <div>
                                 <label>Confirm New Password</label>
                            	 <?php echo form_input($new_password_confirm);?>
                                  <div class="errorconfirm"></div>
		                           
                            </div>
                             <?php echo form_input($user_id);?>
                            <?php echo form_hidden($csrf); ?>
                            <div id="login_error" style="color:red; padding-bottom: 10px; font-weight: 10px;">

                            </div>
                            <div>
                                <button class="btn btn-default submit">Submit</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div class="clearfix"></div>
                                
                                <div>
                                    <h1><img src="<?php echo base_url(); ?>assets/images/WorkWide.png" class="logoimage" > </h1>
                                    <p><?php echo FOOTER; ?></p>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>

<style type="text/css">
    .error{
        color: red; 
    }
</style>
<script type="text/javascript">
 $.validator.addMethod("pwcheck", function(value) {
   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
       && /[a-z]/.test(value) // has a lowercase letter
       && /\d/.test(value) // has a digit
}, "add atleast one upper,lower,special character, one number");


    $("#change_password_form").validate({
    rules: {
        new: {
            required: true,           
            maxlength: 18,
            pwcheck:true,
        },
        new_confirm: {
            required: true,
            maxlength: 18,
            equalTo: "#new"
        }
    },
    messages: {
        new: {
            required: "Please enter a password",
            maxlength: "Enter maximum 18 character",
        },
         new_confirm: {
            required: "Please enter a password",
            maxlength: "Enter maximum 18 character",
            equalTo:"Password Does Not Match"
        }
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});
</script>

