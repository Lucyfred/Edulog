let urlLocation = window.location.pathname;
let domain = window.location.protocol + "//" + window.location.hostname;

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
            onComplete: redCircle,
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
            onComplete: purpleCircle,
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
            onComplete: blueCircle,
        });
    }

    if (urlLocation === "/login" || urlLocation === "/" || urlLocation === "/datos") {
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
    $("#submitLogin").click(function (e) {
        e.preventDefault();

        $("#email").removeClass("is-invalid");
        $("#passLogin").removeClass("is-invalid");
        $("#loginForm").next().remove();

        const $user = $("#email").val();
        const $pass = $("#passLogin").val();

        if (!$user || !$pass) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene los campos de email y contraseña",
            });
            return;
        }

        if (!emailCheck($user)) {
            Swal.fire({
                icon: "error",
                title: "Email inválido",
                text: "Por favor introduzca un email válido",
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/ajax/login_check.php",
            method: "POST",
            data: $("#loginForm").serialize(),
            success: function (res) {
                if (res.success) {
                    window.location.href = `/index`;
                } else {
                    $("#email").addClass("is-invalid");
                    $("#passLogin").addClass("is-invalid");
                    $("#loginForm").after("<p class='mb-4 text-danger'>" + res.message + "</p>");
                }
            },
        });
    });
});

function emailCheck(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

$(document).ready(function () {
    $("#avatar-file").on("change", function () {
        let file = this.files[0];
        let $url = $("#avatar").attr("src");
        let $urlMod = $url.replace("avatar-settings", "avatar" + $("#id_user").val());

        if (!file) {
            return;
        }

        let formData = new FormData();
        formData.append("archivo", file);

        $.ajax({
            url: "/cms/includes/ajax/upload-avatar.php",
            method: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (res) {
                if (res.code === "200") {
                    $url = domain + res.url;
                    $("#avatar").attr("src", $url.split("?")[0] + "?v=" + new Date().getTime());
                    $("#avatar-sm").attr("src", $url.split("?")[0] + "?v=" + new Date().getTime());
                }
            },
        });
    });
    const avatar = document.getElementById("avatar-file").files[0];
});

$(document).ready(function () {
    let $name = $("#nombre_usuario").val();
    let $email = $("#email_usuario").val();

    $("#btn-edit-user").on("click", function () {
        $("#nombre_usuario").attr("disabled", false);
        $("#nombre_usuario").addClass("input-green");
        $("#email_usuario").attr("disabled", false);
        $("#email_usuario").addClass("input-green");
        $("#div-edit-user").addClass("d-none");
        $("#div-accept-user").removeClass("d-none");
        $("#div-cancel-user").removeClass("d-none");
    });

    $("#btn-accept-user").on("click", function () {
        let $nombre = $("#nombre_usuario").val();
        let $email = $("#email_usuario").val();

        if ($nombre.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo nombre",
            });
            return;
        }

        if ($email.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo email",
            });
            return;
        }

        if (!emailCheck($email)) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "El formato del email introducido no es correcto",
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/ajax/update_user_data.php",
            method: "POST",
            data: $("#form-user-data").serialize(),
            success: function (res) {
                if (res.code === "200") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    $("#nombre_usuario").attr("disabled", true);
                    $("#nombre_usuario").val($nombre);
                    $("#nombre_usuario").removeClass("input-green");
                    $("#email_usuario").attr("disabled", true);
                    $("#email_usuario").val($email);
                    $("#email_usuario").removeClass("input-green");
                    $("#div-edit-user").removeClass("d-none");
                    $("#div-accept-user").addClass("d-none");
                    $("#div-cancel-user").addClass("d-none");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: res.message,
                    });
                }
            },
        });
    });

    $("#btn-cancel-user").on("click", function () {
        $("#nombre_usuario").attr("disabled", true);
        $("#nombre_usuario").val($name);
        $("#nombre_usuario").removeClass("input-green");
        $("#email_usuario").attr("disabled", true);
        $("#email_usuario").val($email);
        $("#email_usuario").removeClass("input-green");
        $("#div-edit-user").removeClass("d-none");
        $("#div-accept-user").addClass("d-none");
        $("#div-cancel-user").addClass("d-none");
    });
});

$(document).ready(function () {
    let $name = $("#nombre_centro").val();
    let $email = $("#tutor_centro").val();

    $("#btn-edit-centro").on("click", function () {
        $("#nombre_centro").attr("disabled", false);
        $("#nombre_centro").addClass("input-green");
        $("#tutor_centro").attr("disabled", false);
        $("#tutor_centro").addClass("input-green");
        $("#div-edit-centro").addClass("d-none");
        $("#div-accept-centro").removeClass("d-none");
        $("#div-cancel-centro").removeClass("d-none");
    });

    $("#btn-accept-centro").on("click", function () {
        let $nombre = $("#nombre_centro").val();
        let $tutor = $("#tutor_centro").val();

        if ($nombre.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo nombre",
            });
            return;
        }

        if ($tutor.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo tutor",
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/ajax/update_center_data.php",
            method: "POST",
            data: $("#form-center-data").serialize(),
            success: function (res) {
                if (res.code === "200") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    $("#nombre_centro").attr("disabled", true);
                    $("#nombre_centro").val($nombre);
                    $("#nombre_centro").removeClass("input-green");
                    $("#tutor_centro").attr("disabled", true);
                    $("#tutor_centro").val($tutor);
                    $("#tutor_centro").removeClass("input-green");
                    $("#div-edit-centro").removeClass("d-none");
                    $("#div-accept-centro").addClass("d-none");
                    $("#div-cancel-centro").addClass("d-none");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: res.message,
                    });
                }
            },
        });
    });

    $("#btn-cancel-centro").on("click", function () {
        $("#nombre_centro").attr("disabled", true);
        $("#nombre_centro").val($name);
        $("#nombre_centro").removeClass("input-green");
        $("#tutor_centro").attr("disabled", true);
        $("#tutor_centro").val($email);
        $("#tutor_centro").removeClass("input-green");
        $("#div-edit-centro").removeClass("d-none");
        $("#div-accept-centro").addClass("d-none");
        $("#div-cancel-centro").addClass("d-none");
    });
});

$(document).ready(function () {
    let $name = $("#nombre_lab").val();
    let $tutor = $("#tutor_lab").val();

    $("#btn-edit-lab").on("click", function () {
        $("#nombre_lab").attr("disabled", false);
        $("#nombre_lab").addClass("input-green");
        $("#tutor_lab").attr("disabled", false);
        $("#tutor_lab").addClass("input-green");
        $("#div-edit-lab").addClass("d-none");
        $("#div-accept-lab").removeClass("d-none");
        $("#div-cancel-lab").removeClass("d-none");
    });

    $("#btn-accept-lab").on("click", function () {
        let $nombre = $("#nombre_lab").val();
        let $tutor = $("#tutor_lab").val();

        if ($nombre.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo nombre",
            });
            return;
        }

        if ($tutor.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo tutor",
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/ajax/update_lab_data.php",
            method: "POST",
            data: $("#form-lab-data").serialize(),
            success: function (res) {
                if (res.code === "200") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    $("#nombre_lab").attr("disabled", true);
                    $("#nombre_lab").val($nombre);
                    $("#nombre_lab").removeClass("input-green");
                    $("#tutor_lab").attr("disabled", true);
                    $("#tutor_lab").val($tutor);
                    $("#tutor_lab").removeClass("input-green");
                    $("#div-edit-lab").removeClass("d-none");
                    $("#div-accept-lab").addClass("d-none");
                    $("#div-cancel-lab").addClass("d-none");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: res.message,
                    });
                }
            },
        });
    });

    $("#btn-cancel-lab").on("click", function () {
        $("#nombre_lab").attr("disabled", true);
        $("#nombre_lab").val($name);
        $("#nombre_lab").removeClass("input-green");
        $("#tutor_lab").attr("disabled", true);
        $("#tutor_lab").val($tutor);
        $("#tutor_lab").removeClass("input-green");
        $("#div-edit-lab").removeClass("d-none");
        $("#div-accept-lab").addClass("d-none");
        $("#div-cancel-lab").addClass("d-none");
    });
});

function fechaNormal(fecha) {
    const partes = fecha.split("-");
    if (partes.length !== 3) return fecha; // protección simple
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

$(document).ready(function () {
    const $fechaInput = $("#fecha");

    $fechaInput.on("change", function () {
        const date = new Date(this.value);
        const day = date.getDay();

        if (day !== 1) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: "Solo puedes seleccionar los lunes",
                showConfirmButton: false,
                timer: 3000,
            });
            this.value = "";
        }
    });

    $("#btn-create").on("click", function () {
        let $fecha = $("#fecha").val();
        let $semana = $("#num_semana").val();

        if (!$fecha) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor, seleccione una fecha",
            });
            return;
        }

        if (!$semana) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor, rellene el campo semana número",
            });
            return;
        }

        if (!Number.isInteger(Number($semana))) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "El campo semana solo puede ser numérico.",
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/crear_ficha_semana.php",
            method: "POST",
            data: $("#form-create").serialize(),
            success: function (res) {
                if (res.code === "200") {
                    sessionStorage.setItem("swalMessage", res.message);
                    sessionStorage.setItem("swalType", "success");
                    location.reload();
                } else {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            },
        });
    });
});

$(document).on("click", ".trash-ficha", function () {
    let $id = $(this).closest(".card").find(".f-id").val();

    if ($id == 0 || $id == "") {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "Ocurrió un error al intentar borrar",
            showConfirmButton: false,
            timer: 3000,
        });
        return;
    }

    let confirmacion = confirm("¿Seguro que quieres eliminar la ficha seleccionada?");

    if (confirmacion) {
        $.ajax({
            url: "/cms/includes/func/borrar_ficha.php",
            method: "POST",
            data: { id: $id },
            success: function (res) {
                if (res.code === "200") {
                    sessionStorage.setItem("swalMessage", res.message);
                    sessionStorage.setItem("swalType", "success");
                    location.reload();
                } else {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            },
        });
    }
});

$(document).on("click", ".edit-ficha", function () {
    let $id = $(this).closest(".card").find(".f-id").val();

    if ($id == 0 || $id == "") {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "Ocurrió un error al intentar borrar",
            showConfirmButton: false,
            timer: 3000,
        });
        return;
    }

    $.ajax({
        url: "/cms/includes/func/recuperar_datos.php",
        method: "POST",
        data: { id: $id },
        success: function (res) {
            res.forEach((element) => {
                let dia = element.dia;
                $(`#textarea-${dia}`).val(element.actividad);
                $(`#horas-${dia}`).val(element.horas);
            });
            $("#form-editar").prepend(`<input type="hidden" class="mf-id id-edit" value="${$id}"></input>`);
        },
    });
});

$("#modal-editar").on("hidden.bs.modal", function () {
    $(this).find("#form-editar")[0].reset();
    $(this).find(".id-edit").remove();
});

$(document).on("click", "#btn-save", function () {
    let $id = $(this).closest("#form-editar").find(".mf-id").val();
    let $actLunes = $("#textarea-lunes").val();
    let $hLunes = parseInt($("#horas-lunes").val());
    let $actMartes = $("#textarea-martes").val();
    let $hMartes = $("#horas-martes").val();
    let $actMiercoles = $("#textarea-miercoles").val();
    let $hMiercoles = $("#horas-miercoles").val();
    let $actJueves = $("#textarea-jueves").val();
    let $hJueves = $("#horas-jueves").val();
    let $actViernes = $("#textarea-viernes").val();
    let $hViernes = $("#horas-viernes").val();

    if ($id == 0 || $id == "") {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "Ocurrió un error al intentar borrar",
            showConfirmButton: false,
            timer: 3000,
        });
        return;
    }

    if (
        ($hLunes !== "" && $hLunes <= 0) ||
        ($hMartes !== "" && $hMartes <= 0) ||
        ($hMiercoles !== "" && $hMiercoles <= 0) ||
        ($hJueves !== "" && $hJueves <= 0) ||
        ($hViernes !== "" && $hViernes <= 0)
    ) {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "El campo horas no puede ser inferior a 1 hora",
            showConfirmButton: false,
            timer: 3000,
        });
        return;
    }

    if ($hLunes > 8 || $hMartes > 8 || $hMiercoles > 8 || $hJueves > 8 || $hViernes > 8) {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "El campo horas no puede ser superior a 8 horas",
            showConfirmButton: false,
            timer: 3000,
        });
        return;
    }

    $.ajax({
        url: "/cms/includes/func/guardar_datos_ficha.php",
        method: "POST",
        data: $("#form-editar").serialize() + "&id=" + $id,
        success: function (res) {
            if (res.code === "200") {
                sessionStorage.setItem("swalMessage", res.message);
                sessionStorage.setItem("swalType", "success");
                location.reload();
            } else {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        },
    });
});

$(document).ready(function () {
    const message = sessionStorage.getItem("swalMessage");
    const type = sessionStorage.getItem("swalType");

    if (message) {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 3000,
        });

        sessionStorage.removeItem("swalMessage");
        sessionStorage.removeItem("swalType");
    }
});

$(document).on("click", ".btn-imprimir", function () {
    let $id = $(this).closest(".card").find(".f-id").val();
    const url = `/cms/includes/generar_ficha.php?fi=${$id}`;
    window.open(url, "_blank");
});

$(document).ready(function () {
    $("#modal-editar-password").on("shown.bs.modal", function(){
        $("#pass").focus();
    })

    $("#pass").on("keydown", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            $("#pass2").focus();
        }
    })

    $("#pass2").on("keydown", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            $("#btn-edit-password").focus().click();
        }
    })

    $("#btn-edit-password").on("click", function () {
        let $pass = $("#pass").val();
        let $pass2 = $("#pass2").val();

        if ($pass !== $pass2) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: "Las contraseñas no coinciden",
                showConfirmButton: false,
                timer: 3000,
            });
            return;
        }

        if ($pass == "" || $pass2 == "") {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: "Los campos contraseña no pueden estar vacíos",
                showConfirmButton: false,
                timer: 3000,
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/func/edit_pass.php",
            method: "POST",
            data: {
                pass: $pass,
            },
            success: function (res) {
                if (res.code === "200") {
                    sessionStorage.setItem("swalMessage", res.message);
                    sessionStorage.setItem("swalType", "success");
                    location.reload();
                } else {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            },
        });
    });
});

$(document).ready(function(){
    $("#usuarios").on("click", function(e){
        e.preventDefault();
        const $submenu = $("#menu-usuarios");
        if($submenu.hasClass("d-none")){
            $submenu.removeClass("d-none").css("display", "none").fadeIn(300);
        } else{
            $submenu.addClass("d-none").css("display", "none").fadeOut(300);
        }
    })
})