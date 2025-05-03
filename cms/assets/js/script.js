let urlLocation = window.location.pathname;
let domain = window.location.hostname;

$(document).ready(function () {

  /**
   * Animaciones de los círculos en la pantalla de login
   */
  function redCircle() {
    let x = Math.random() * 300 - 150;
    let y = Math.random() * 300 - 150;

    gsap.to("#redCircle", {
      x: x,
      y: y,
      duration: 6,
      ease: "sine.inOut",
      onComplete: redCircle 
    });
  }

  function purpleCircle() {
    let x = Math.random() * 300 - 150;
    let y = Math.random() * 300 - 150;

    gsap.to("#purpleCircle", {
      x: x,
      y: y,
      duration: 6,
      ease: "sine.inOut",
      onComplete: purpleCircle 
    });
  }

  function blueCircle() {
    let x = Math.random() * 300 - 150;
    let y = Math.random() * 300 - 150;

    gsap.to("#blueCircle", {
      x: x,
      y: y,
      duration: 6,
      ease: "sine.inOut",
      onComplete: blueCircle 
    });
  }

  if(urlLocation === "/login" || urlLocation === "/"){
    redCircle();
    purpleCircle();
    blueCircle();
  }

  // $("#home").click(function(){
  //   $("#content-frame").load("../../main.php");
  //   history.pushState({}, "", "/")
  // });

  // $("#files").click(function(){
  //   $("#content-frame").load("../../fichas.php");
  //   history.pushState({}, "", "/fichas")
  // });


  /**
   * Revisión de datos al hacer login
   */
  $("#submitLogin").click(function(e){
    e.preventDefault();

    $("#email").removeClass("is-invalid");
    $("#pass").removeClass("is-invalid");
    $("#loginForm").next().remove();

    const $user = $("#email").val();
    const $pass = $("#pass").val();

    if (!$user || !$pass) {
      Swal.fire({
        icon: "error",
        title: "Campos incompletos",
        text: "Por favor rellene los campos de email y contraseña",
      });
      return;
    }

    if(!emailCheck($user)){
      Swal.fire({
        icon: "error",
        title: "Email inválido",
        text: "Por favor introduzca un email válido",
      });
      return;
    }
    
    $.ajax({
      url: "/cms/includes/login_check.php",
      method: "POST",
      data: $("#loginForm").serialize(),
      success: function(res){
        if(res.success){
          window.location.href = `/index`;
        } else{
          $("#email").addClass("is-invalid");
          $("#pass").addClass("is-invalid");
          $("#loginForm").after("<p class='mb-4 text-danger'>" + res.message + "</p>");
        }
      }
    });
    
  });

  // $(".menu-option").click(function(){
  //   $(".activo").removeClass("activo");
  //   $(this).addClass("activo");
  // });
});


function emailCheck(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

$(document).ready(function(){
  $("#avatar-file").on("change", function(){
    let file = this.files[0];
    if(!file){
      return;
    }

    let formData = new FormData();
    formData.append("archivo", file);
    
    $.ajax({
      url: "/cms/includes/upload-avatar.php",
      method: "POST",
      processData: false,
      contentType: false,
      data: formData,
      success: function(res){
        if(res === "200"){
          $("#avatar").attr();
        }
      }
    })

  })
  const avatar = document.getElementById("avatar-file").files[0];
})