class Login {

  static init(){
    if (window.localStorage.getItem("token")){
      window.location="index.html";
    }else{
      $('body').show();
    }
  }

  static show_register_form(){
    $("#login-form-container").addClass("hidden");
    $("#register-form-container").removeClass("hidden");
  }

  static show_login_form(){
    $("#login-form-container").removeClass("hidden");
    $("#register-form-container").addClass("hidden");
    $("#forgot-form-container").addClass("hidden");
  }

  static register(){
    $("#register-link").prop('disabled',true);
    RestClient.post("api/students/register", AUtils.form2json("#register-form"), function(data){
      $("#register-form-container").addClass("hidden");
      $("#form-alert").removeClass("hidden")
      $("#form-alert .alert").html(data.message);
      Login.show_login_form();
    });
  }

  static login(){
    $("#login-link").prop('disabled',true);
    RestClient.post("api/students/login", AUtils.form2json("#login-form"), function( data ) {
      window.localStorage.setItem("token", data.token);
      window.location = "index.html";
    }, function(jqXHR, textStatus, errorThrown){
      $("#login-link").prop('disabled',false);
      toastr.error(error.responseJSON.message);
    });
  }
 
}
