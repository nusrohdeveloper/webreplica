$( document ).ready(function() {

      $(document).ready(function () {
         $('#email').bind('copy paste', function (e) {
            e.preventDefault();
         });
       });
 $('#username').keypress(function (e) {
       var txt = String.fromCharCode(e.which);
       if (!txt.match(/^[A-Za-z0-9]+$/)) {
           return false;
       }
   });
  $("#username").keyup(function(e){
     var str = $.trim( $(this).val() );
     if( str != "" ) {
       var regx = /^[A-Za-z0-9]+$/;
       if (!regx.test(str)) {
         $(".input-error-2").html("Hanya Huruf dan Nombor sahaja");
         return false;
       }
     }
     else {
        //empty value -- do something here
     }
 });

 $('#username').on('keypress', function(e) {
         if (e.which == 32)
             return false;
     });
 $("#username").on('keyup',function(){
     this.value = this.value.toLowerCase();
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
 $("#phone").on('keypress',function(){
     if($(this).val().length==11){
         //alert("No. IDP tidak kurang 6 huruf & tidak lebih 7 huruf");
         $(this).focus();
         return false;
        }
 });
 $("#phone").on('blur',function(){
     if($(this).val().length<10){
   //alert("No. IDP tidak kurang 6 huruf & tidak lebih 7 huruf");
         $(this).focus();
         return false;
        }
 });

 $("#no_ic").on('keypress',function(){
     if($(this).val().length==12){
         //alert("No. IDP tidak kurang 6 huruf & tidak lebih 7 huruf");
         $(this).focus();
         return false;
        }
 });
 $("#ic_no").on('blur',function(){
     if($(this).val().length<12){
   //alert("No. IDP tidak kurang 6 huruf & tidak lebih 7 huruf");
         $(this).focus();
         return false;
        }
 });
 function checkAvailabilityEmail() {
    var test;
    var testing = 0;
    var email = $("#email");
    var email_value = $("#email").val();

    var format_email ="<small>*Format email</small>"

    if(email_value.length < 0 || email_value.length > 50)
    {
    // alert("Format phone: Huruf atau Gabungan Huruf & Nombor.");
    // $("#user-availability-status").html(indicator);
      test = "<i class='fa fa-times' id='email-not-available' style='color:red'></i>";
      $("#email-availability-status").html(test);
      // $("#phone").setCustomValidity("bl bal bla");

      // return 1;
      // return false;
    }
 function checkAvailability() {
   var indicator;
   var flag;
   var username_value = $("#username").val();
   if(username_value != '')
   {
     $("#question-icon").hide();
     jQuery.ajax({
     url: "check_availability.php",
     data:'username='+$("#username").val(),
     type: "POST",
     success:function(data){
       if(data == 1){
         $('#username').parent().parent().addClass('has-error');
         indicator = "<i class='fa fa-times' id='username-not-available' style='color:red'></i>";
         flag = 1;
       }else{
         $('#username').parent().parent().removeClass('has-error');
         indicator = "<i class='fa fa-check' id='username-available' style='color:green'></i>";
         flag = 0;
       }
       $("#user-availability-status").html(indicator);
       $("#loaderIcon").hide();
       return flag;
     },
     error:function (){}
     });
   }else {
     $('#username').parent().parent().addClass('has-error');
     return 1;
   }
 }
 function checkAvailabilityEmail() {
   var test;
   var testing;
   var email_value = $("#email").val();
   if(email_value != '')
   {
     $("#question-icon").hide();
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

  $(document).ready(function(){
    <?php
      echo " var visited  = ". json_encode(isset($_POST['simpan_pengguna'])).";";
  ?>
  if (!visited) {
    $('#modal_notis').modal('show');
  }
 });
 });
