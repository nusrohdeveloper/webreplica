  var img_width;
  var img_height;
  // $( "#pengguna_form" ).submit(function( event ) {
  //     return validateForm();
  //     event.preventDefault();
  //   });
  // $( "#pembeli_form" ).submit(function( event ) {
  //     return validateFormPembeli();
  //     event.preventDefault();
  //   });
  // $( "#welcome_form" ).submit(function( event ) {
  //     return validateFormProspek();
  //     event.preventDefault();
  //   });
  // $("#poskod").on('blur',function(){
  //    if($(this).val().length<5){
  //        $(this).focus();
  //        return false;
  //       }
  // });


       $('#username').on('keypress', function(e) {
           if (e.which == 32)
               return false;
       });

       $("#username").on('keyup',function(){
       this.value = this.value.toLowerCase();
       });



       $("#ic_no").on('keypress',function(){
       if($(this).val().length==12){
           $(this).focus();
           return false;
          }
       });
       $("#no_ic").on('blur',function(){
       if($(this).val().length<12){
           $(this).focus();
           return false;
          }
       });
       $("#city").on('blur',function(){
       if(!isNaN($(this).val())){
           $(this).focus();
           return false;
          }
       });
       $("#phone").on('keypress',function(e){
        var deleteKeyCode = 8;
        var backspaceKeyCode = 46;
       if($(this).val().length==11 && e.which != 46 ){
           $(this).focus();
           return false;
          }
       });
       $("#phone").on('blur',function(){
       if($(this).val().length<10){
           $(this).focus();
           return false;
          }
       });
       $('#username').keypress(function (e) {
         var txt = String.fromCharCode(e.which);
         if (!txt.match(/^[A-Za-z0-9]+$/)) {
             return false;
         }
       });
       $('#phone').on('keydown',function(e){
          var deleteKeyCode = 8;
          var backspaceKeyCode = 46;
          var tabKeyCode = 9;
          if ((e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105) || (e.which>=37 && e.which<=40)  || e.which === deleteKeyCode || e.which === backspaceKeyCode || e.which === tabKeyCode)
          {
              $(this).removeClass('error');
              return true;
          }
          else
          {
              $(this).addClass('error');
              return false;
          }
      });
       $("#username").keyup(function(e){
       var str = $.trim( $(this).val() );
       if( str != "" ) {
         var regx = /^[A-Za-z0-9]+$/;
         if (!regx.test(str)) {
           $(".input-error-2").html("Only letters and numbers only");
           return false;
         }
       }
       else {
          //empty value -- do something here
       }
       });

>>>>>>> marketing
  $("#username").on('blur',function(){
  var min_chars = 3;

   //result texts

   var empty = "<i class='fa fa-question' style='color:#ff8f00' ></i>";
   var loading_icon = "<i class='fa fa-spinner fa-pulse fa-fw' id='loaderIcon'></i>";
   var characters_error = 'Username: must be at least 3 letters.';
   var checking_html = 'Checking...'
    if($('#username').val().length == 0){
         //if it's bellow the minimum show characters_error text '
         $('#user-availability-status').html(empty);
     }else if($('#username').val().length < min_chars){
         //if it's bellow the minimum show characters_error text '
         $('#user-availability-status').html(characters_error);
     }else{
         //else show the cheking_text and run the function to check
         $('#user-availability-status').html(loading_icon);
         checkAvailability();
     }
  });

  $("#email").on('blur',function(){
  var min_chars = 3;

   //result texts
   var empty = "<i class='fa fa-question' style='color:#ff8f00' ></i>";
   var loading_icon = "<i class='fa fa-spinner fa-pulse fa-fw' id='loaderIcon'></i>";
   var characters_error = 'E-Mail: someone@example.com';
   var checking_html = 'Checking...'
   var email_value= $('#email').val();

    if($('#email').val().length == 0){
         //if it's bellow the minimum show characters_error text '
         $('#email-availability-status').html(empty);
     }else if(!email_value.match(/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/)){
         //if it's bellow the minimum show characters_error text '
         $('#email-availability-status').html(characters_error);
     }else{
         //else show the cheking_text and run the function to check
         $('#email-availability-status').html(loading_icon);
         checkEmailAvailability();

     }
  });


  var _URL = window.URL || window.webkitURL;

  $("#avatar").change(function(e) {

      var image, file;

      if ((file = this.files[0])) {

          image = new Image();

          image.onload = function() {
            img_width = this.width;
            img_height = this.heigt;
          };

          image.src = _URL.createObjectURL(file);


      }

  });


  function addError(forms, param)
  {
    if(forms != '' || forms != undefined || forms != null )
    {
      document.forms[forms][param].parentElement.className += " has-error";
    }
    else {
       document.getElementById(param).parentElement.className += " has-error";
    }
  }
  function addSuccess(forms, param)
  {
    if(forms != '' || forms != undefined || forms == null )
    {
      document.forms[forms][param].parentElement.className += " has-success";
    }
    else {
       document.getElementById(param).parentElement.className += " has-success";
    }
  }

  function removeError(forms, param)
  {
    if(forms != '' || forms != undefined || forms == null )
    {
      document.forms[forms][param].parentElement.classList.remove("has-error");
    }
    else {
       document.getElementById(param).parentElement.classList.remove("has-error");
    }
    // document.getElementById(param).parentElement.classList.remove("has-error");
  }

  function checkNull(param, forms)
  {
    var opsError = 0;
    value_input = document.forms[forms][param].value;
    if (value_input == null || value_input == "" )
    {
      addError(forms, param)
      return opsError += 1;
    }
    else
    {
      removeError(forms, param)
      return opsError;
    }
  }

  function checkInputLength(form, param, length) {
    value_length = document.forms[form][param].value.length;
    if(length == value_length || length+1 == value_length){
      removeError(form, param)
      return 0;
    }else{
      addError(form, param)
      return 1;
    }
  }

  function validateForm(modal, form)
  {

    modal = modal ||"#user_form_container";
    form = form || "user_form";

    var errorFlag = 0;
    inputs = [ "username", "name", "phone" , "email" ];

    var i = 0;
    while (inputs[i]){
      errorFlag += checkNull(inputs[i], form);
      i++;
    }

    errorFlag += checkAvailability();
    errorFlag += checkAvailabilityClassError();

    errorFlag += checkPasswordMatch();
    errorFlag += checkImage();
    if (errorFlag > 0){
      $( modal ).effect( "shake", {times:1}, 200 );
      return false;
    }
  }
  function checkAvailabilityClassError() {
    var flag = 0;
    var username = $("#username");
    if( $('#username').parent().parent().hasClass('has-error') ){
      flag = 1;
    }
    return flag;
}
    // function checkAvailabilityEmail() {
    //    var test;
    //    var testing = 0;
    //    var email = $("#email");
    //    var email_value = $("#email").val();
    //
    //    var format_email ="<small>*Format email</small>"
    //
    //    test = "<i class='fa fa-times' id='email-not-available' style='color:red'></i>";
    //    $("#email-availability-status").html(test);
    //    if(email_value.length < 5 || email_value.length > 50)
    //    {
    //    // alert("Format phone: Huruf atau Gabungan Huruf & Nombor.");
    //    // $("#user-availability-status").html(indicator);
    //      test = "<i class='fa fa-times' id='email-not-available' style='color:red'></i>";
    //      $("#email-availability-status").html(test);
    //      // $("#phone").setCustomValidity("bl bal bla");
    //
    //      // return 1;
    //      // return false;
    //    }
    //  }
     function checkAvailabilityEmail() {
       var test;
       var testing;
       var email_value = $("#email").val();
       if(email_value != '')
       {
         $("#question-icon-email").hide();
         jQuery.ajax({
         url: "check_email.php",
         data:'email='+$("#email").val(),
         type: "POST",
         success:function(data){
           if(data == 1){
             $('#email').parent().parent().addClass('has-error');
             test = "<i class='fa fa-times' id='email-not-available' style='color:red'></i>";
             testing = 1;
           }else{
             $('#email').parent().parent().removeClass('has-error');
             test = "<i class='fa fa-check' id='email-available' style='color:green'></i>";
             testing = 0;
           }
           $("#email-availability-status").html(test);
           $("#loaderIcon").hide();
           return testing;
         },
         error:function (){}
         });
       }else {
         $('#email').parent().parent().addClass('has-error');
         return 1;
       }
     }

  }
  function checkAvailability() {
    var indicator;
    var flag = 0;
    var username = $("#username");
    var username_value = $("#username").val();

    var format_username ="<small>*Username: Letter or combination of letters and numbers and not less than 4 characters and not more than 15 characters</small>"


    if(!isNaN(username_value) || username_value.length < 5 || username_value.length > 15)
    {
    // alert("Format username: Huruf atau Gabungan Huruf & Nombor.");
    // $("#user-availability-status").html(indicator);
      indicator = "<i class='fa fa-times' id='username-not-available' style='color:red'></i>";
      $("#user-availability-status").html(indicator);
      // $("#username").setCustomValidity("bl bal bla");

      // return 1;
      // return false;
    }
  	if(username_value != '' && isNaN(username_value) && username_value.length >= 5 && username_value.length <= 15  )
    {
      $("#question-icon").hide();
    	jQuery.ajax({
    	url: "check_availability.php",
    	data:'username='+username_value,
    	type: "POST",
    	success:function(data){
        if(data == 1){
          username.parent().parent().addClass('has-error');
          indicator = "<i class='fa fa-times' id='username-not-available' style='color:red'></i>";
          username.focus();
          flag = parseInt(data);
        }else{
          username.parent().parent().removeClass('has-error');
          username.parent().removeClass('has-error');
          indicator = "<i class='fa fa-check' id='username-available' style='color:green'></i>";
          flag = parseInt(data);
        }
        $("#user-availability-status").html(indicator);
    		$("#loaderIcon").hide();
        flag = parseInt(data);
    	},
    	error:function (){}
    	});
      $("#if-error").hide();
      return flag;
    }else {
      username.parent().parent().addClass('has-error');
      username.focus();
      $("#if-error").html(format_username);
      $("#if-error").show();

      return 1;
    }
  }


  function checkEmailAvailability() {
    var indicator;
    var flag = 999;
    var email = $("#email");
    var email_value = $("#email").val();
    var format_email ="<small>*E-Mail: someone@example.com"

    if(!isNaN(email_value))
    {
      indicator = "<i class='fa fa-times' id='not-available' style='color:red'></i>";
      $("#email-availability-status").html(indicator);
    }
    if(email_value != '' && isNaN(email_value))
    {
      $("#question-icon").hide();
      jQuery.ajax({
      url: "check_emailavailability.php",
      data:'email='+email_value,
      type: "POST",
      success:function(data){
        if(data == 1){
          email.parent().parent().addClass('has-error');
          indicator = "<i class='fa fa-times' id='email-not-available' style='color:red'></i>";
          email.focus();
          flag = parseInt(data);
        }else{
          email.parent().parent().removeClass('has-error');
          email.parent().removeClass('has-error');
          indicator = "<i class='fa fa-check' id='email-available' style='color:green'></i>";
          flag = parseInt(data);
        }
        $("#email-availability-status").html(indicator);
        $("#loaderIcon").hide();
        flag = parseInt(data);
      },
      error:function (){}
      });
      $("#if-error").hide();
      return flag;
    }else {
      email.parent().parent().addClass('has-error');
      email.focus();
      $("#if-error").html(format_email);
      $("#if-error").show();

      return 1;
    }
  }


  // $(document).ready(function () {
  //   $("#idp, #idp2").keyup(checkPasswordMatch);
  // })

  function checkImage() {
    var image = document.getElementById("avatar");
    if(image.value)
    {
      var img = image.files[0].size;
      var imgsize=img/1024;
      var imgsizelimit = 500;
    }
    if (!image.value) {
      event.preventDefault();

      alert("Please select and download images.");
      return 1;

    }else if(imgsize > imgsizelimit){
      alert('The image file size does not exceed 500KB.');

      return 1;
    }else{
      return 0;
    }
  }
