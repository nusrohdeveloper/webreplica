<script type="text/javascript">

var img_width;
var img_height;
$( "#pengguna_form" ).submit(function( event ) {
    return validateForm();
    event.preventDefault();
  });
$( "#pembeli_form" ).submit(function( event ) {
    return validateFormPembeli();
    event.preventDefault();
  });
$( "#welcome_form" ).submit(function( event ) {
    return validateFormProspek();
    event.preventDefault();
  });
$("#poskod").on('blur',function(){
   if($(this).val().length<5){
       $(this).focus();
       return false;
      }
});
$("#username").on('blur',function(){
var min_chars = 3;

 //result texts
 var kosong = "<i class='fa fa-question' style='color:#ff8f00' ></i>";
 var loading_icon = "<i class='fa fa-spinner fa-pulse fa-fw' id='loaderIcon'></i>";
 var characters_error = 'Username mesti sekurangnya 3 huruf.';
 var checking_html = 'Checking...'
  if($('#username').val().length == 0){
       //if it's bellow the minimum show characters_error text '
       $('#user-availability-status').html(kosong);
   }else if($('#username').val().length < min_chars){
       //if it's bellow the minimum show characters_error text '
       $('#user-availability-status').html(kosong);
   }else{
       //else show the cheking_text and run the function to check
       $('#user-availability-status').html(loading_icon);
       checkAvailability();
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

function validateFormAdmin(modal, form)
{
  modal = modal ||"#add_pengguna_modal";
  form = form || "pengguna_form";

  var errorFlag = 0;
  inputs = [ "username", "nama", "no_tel" , "no_ic" , "email" , "idp"  ];
  var i = 0;
  while (inputs[i]){
    errorFlag += checkNull(inputs[i], form);
    i++;
  }

  errorFlag += checkAvailability();
  errorFlag += checkAvailabilityClassError();
  errorFlag += checkInputLength('pengguna_form','idp', 6);
  errorFlag += checkImage();
  if (errorFlag > 0){
    $( modal ).effect( "shake", {times:1}, 200 );
    return false;
  }
}
function validateForm(modal, form)
{
  modal = modal ||"#add_pengguna_modal";
  form = form || "pengguna_form";

  var errorFlag = 0;
  inputs = [ "username", "nama", "no_tel" , "no_ic" , "email" , "idp", "idp2"  ];
  var i = 0;
  while (inputs[i]){
    errorFlag += checkNull(inputs[i], form);
    i++;
  }

  errorFlag += checkAvailability();
  errorFlag += checkAvailabilityClassError();
  errorFlag += checkInputLength('pengguna_form','idp', 6);
  errorFlag += checkInputLength('pengguna_form','idp2', 6);
  errorFlag += checkPasswordMatch();
  errorFlag += checkImage();
  if (errorFlag > 0){
    $( modal ).effect( "shake", {times:1}, 200 );
    return false;
  }
}
function validateFormPembeli(modal, form)
{
  modal = modal ||"#pembeli_form_container";
  form = form || "pembeli_form";

  var errorFlag = 0;
  inputs = [ "nama", "no_tel_prospek" , "email_prospek" , "alamat1" , "poskod" , "daerah" , "negeri", "pakej" ];
  var i = 0;
  while (inputs[i]){
    errorFlag += checkNull(inputs[i], form);
    i++;
  }
  if (errorFlag > 0){
    $( modal ).effect( "shake", {times:1}, 200 );
    return false;
  }
}
function validateFormProspek(modal, form)
{
  modal = modal ||"#welcome_form_container";
  form = form || "welcome_form";

  var errorFlag = 0;
  inputs = [ "nama_prospek", "whatsapp" , "email_prospek" ];
  var i = 0;
  while (inputs[i]){
    errorFlag += checkNull(inputs[i], form);
    i++;
  }
  if($('#whatsapp').val().length < 10){
    addError(form, 'whatsapp');
    errorFlag += 1;
  }

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
function checkAvailability() {
  var indicator;
  var flag = 0;
  var username = $("#username");
  var username_value = $("#username").val();
  var format_username ="<small>*Format username: Huruf atau Gabungan Huruf & Nombor dan tidak kurang 4 huruf dan tidak lebih 15 huruf</small>"

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

$(document).ready( function() { $("#idp, #idp2").keyup(checkPasswordMatch);  } );

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
    alert("Sila pilih dan muat turun gambar.");
    return 1;

  }else if(imgsize > imgsizelimit){
    alert('Saiz fail gambar tidak melebihi 500kb.');
    return 1;
  }else{
    return 0;
  }
}

function checkPasswordMatch() {
    var form = "pengguna_form";
    var idp = $("#idp").val();
    var idp2 = $("#idp2").val();

    if( idp == idp2 && idp != "" && idp2 != "" && (idp.length >= 6 && idp.length <= 7 ||   idp2.length >= 6 && idp2.length <= 7)){
      //  alert('sama laa');
       removeError(form, "idp");
       addSuccess(form, "idp");
       removeError(form, "idp2");
       addSuccess(form, "idp2");
       return 0;
     }
     else if (idp == "" && idp2 == "" || idp != "" && idp2 == "" || idp == "" && idp2 != "" || idp != "" && idp2 != "" || idp != idp2 || (idp == idp2  && idp.length < 6 || idp2.length < 6 ||  idp.length > 7 || idp2.length > 7) )
      {
        $('#idp').parent().parent().removeClass('has-success');
        $('#idp2').parent().parent().removeClass('has-success');
        addError(form, "idp");
        addError(form, "idp2");
        return 1;
      }
  }

</script>
