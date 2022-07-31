function name_blur()
{

    var name = $('#name').val().length;
    var alpha = /^[A-Za-z]+$/;
    if (name == 0)
    {
        $('#for_nm_errmsg').html('Plz Enter Name').css('color', 'red');
        return false;

    }
    else if (!alpha.test($('#name').val()))
    {
        $('#for_nm_errmsg').html('Plz Enter Only Characters!!!').css('color', 'red');
        return false;
    }
    else
    {
        $('#for_nm_errmsg').html('');
        return true;
    }


}
function sr_name_blur()
{
    var sr_name = $('#sname').val().length;
    var alpha = /^[A-Za-z]+$/;
    if (sr_name == 0)
    {
        $('#for_srnm_errmsg').html('Plz Enter Surname').css('color', 'red');
        return false;

    }
    else if (!alpha.test($('#sname').val()))
    {
        $('#for_srnm_errmsg').html('Plz Enter Only Characters!!!').css('color', 'red');
        return false;
    }
    else
    {
        $('#for_srnm_errmsg').html('');
        return true;
    }
}

function email_blur() {

    var emailval = $('#user_email_address').val().length;
    var echeck = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    if (emailval == 0)
    {
        $('#for_email_errmsg').html('Plz Enter Email!!!').css('color', 'red');
        return false;
    }
    else if (!echeck.test($('#user_email_address').val()))
    {
        $('#for_email_errmsg').html('<img src="./img/cancel2.jpg" height="10" width="10"/> Plz Enter valid Email!!!').css('color', 'red');
        return false;

    }
    else
    {
        $('#for_email_errmsg').html('<img src="./img/tick.png" height="10" width="10"/> Ok Valid Email').css('color', 'green');
        return true;

    }


}
function user_name_blur()
{

    var u_name = $('#user_name').val().length;
    var alpha = /^[A-Za-z]+$/;
    if (u_name == 0)
    {
        $('#for_unm_errmsg').html('Plz Enter User Name').css('color', 'red');
        return false;

    }
    else
    {
        if (!alpha.test($('#user_name').val()))
        {
            $('#for_unm_errmsg').html('Plz Enter Only Characters!!').css('color', 'red');
            return false;
        }
        else
        {

            var chk_unm = $('#user_name').val();
            $.ajax({
                type: "POST",
                url: "check.php",
                data: {unm: chk_unm},
                dataType: 'HTML',
                success: function(data)
                {
                    $flag = 0;
                    if (data == 'Vaild Username')
                    {

                        $('#for_unm_errmsg').html('<img src="./img/tick.png" height="10" width="10"/><b>Valid User Name</b>').css("color", "green");
                        $flag = 0;


                    }
                    else
                    {
                        $('#for_unm_errmsg').html('<img src="./img/cancel2.jpg" height="10" width="10"/> User Name Already Exist Try Another!!!!').css('color', 'red');
                        $flag = 1;

                    }
                }
            });
            if ($flag == 1)
            {
                return false;
            } else if ($flag == 0)
            {
                return true;
            }

        }

    }



}
function password_blur()
{
    var pwd = $('#password').val().length;
    if (pwd == 0)
    {
        $('#for_pwd_errmsg').html('Plz Enter Password!!!').css('color', 'red');
        return false;

    }
    else
    {
        $('#for_pwd_errmsg').html('');
        return true;
    }
}
function terms()
{
    if ($('#terms').is(':checked')) {

        $('#for_terms_errmsg').html('');
        return true;
    }
    else {
        $('#for_terms_errmsg').html('Plz Check Terms & Conditionds').css('color', 'red');
        return false;
    }
}

/*function unm_availibility()
 {
 $flag = 0;
 var chk_unm = $('#user_name').val();
 $.ajax({
 type: "POST",
 url: "check.php",
 data: {unm: chk_unm},
 dataType: 'HTML',
 success: function(data)
 {
 if (data == 'Vaild Username')
 {
 $('#for_unm_errmsg').html('<img src="./img/tick.png"/><b>Valid Email</b>').css("color", "green");
 $flag = 0;
 
 }
 else
 {
 $('#for_unm_errmsg').html('<img src="./img/cancel2.jpg" height="10" width="10"/> User Name Already Exist Try Another!!!!').css('color', 'red');
 $flag = 1;
 
 }
 }
 });
 if ($flag == 1)
 {
 alert($flag);
 return false;
 } else {
 alert($flag);
 return true;
 }
 
 }*/
function get_job_id(id)
{
    var jb_id = $(id).closest('tr').attr('id');
    $.ajax({
        type: "POST",
        url: 'complete_status.php',
        data: {"fnc": "when_click_complete", id: jb_id},
        success: function(data)
        {
            alert(data);
        }
    });
}
function problem_link(prblm_jobid)
{
    var p_job_id = $(prblm_jobid).closest('tr').attr('id');
    $.ajax({
        type: "POST",
        url: 'complete_status.php',
        data: {"fnc": "when_click_problem", p_id: p_job_id},
        success: function(data)
        {
            alert(data);
        }
    });
}
function update_status(upjb_id)
{
    var up_jb_id = $(upjb_id).closest('tr').attr('id');
    var sts_val = $(upjb_id).val();
    $.ajax({
        type: "POST",
        url: 'complete_status.php',
        data: {"fnc": "for_update_status", up_jb_id: up_jb_id, stts: sts_val},
        success: function(data)
        {
            if (data = 'update status successfully')
            {
                alert('Status aggiornato con successo!');
				if(sts_val == "Completed" || sts_val == "Deleted" || sts_val == "Canceled") {
					$('.job_download_' + up_jb_id).attr('disabled', 'disabled');
					$('.job_delete_' + up_jb_id).attr('disabled', 'disabled');
					$('.' + up_jb_id).attr('disabled', 'disabled');
				}
            }
            else
            {
                alert('Si e\' verificato un durante l\'aggiornmento dello status! Riprova piu\' tardi' );
            }
        }
    });

}
