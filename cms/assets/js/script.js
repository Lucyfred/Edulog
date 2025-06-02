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

/**
 * Revisa si el formato del email es válido
 * @param {string} email - Email a revisar
 * @returns 
 */
function emailCheck(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

$(document).ready(function () {
    /**
     * Maneja el evento de cambio en el input de archivo
     * - Obtiene el archivo
     * - Crea un formdata y lo envía al ajax
     * - Si es correcto, la imagen se actualiza
     */
    $("#avatar-file").on("change", function () {
        let file = this.files[0];
        let $url = $("#avatar").attr("src");

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
            /**
             * Si es correcto, cambiar la url de las fotos, haciéndolas únicas
             * @param {{ code: string, url: string, message: string}} res 
             */
            success: function (res) {
                if (res.code === "200") {
                    $url = domain + res.url;
                    $("#avatar").attr("src", $url.split("?")[0] + "?v=" + new Date().getTime());
                    $("#avatar-sm").attr("src", $url.split("?")[0] + "?v=" + new Date().getTime());
                } else{
                    Swal.fire({
                        icon: "error",
                        title: res.message,
                    });
                }
            },
        });
    });
});

$(document).ready(function () {
    let $name = $("#nombre_usuario").val();
    let $email = $("#email_usuario").val();

    /**
     * Evento de escucha, al dar click modifica las clases y atributos de algunos elementos
     */
    $("#btn-edit-user").on("click", function () {
        $("#nombre_usuario").attr("disabled", false);
        $("#nombre_usuario").addClass("input-green");
        $("#email_usuario").attr("disabled", false);
        $("#email_usuario").addClass("input-green");
        $("#div-edit-user").addClass("d-none");
        $("#div-accept-user").removeClass("d-none");
        $("#div-cancel-user").removeClass("d-none");
    });

    /**
     * Evento de escucha, al dar click revisa varios datos y manda un ajax
     */
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
            /**
             * Si es correcto, modifica los datos y deshabilita los inputs
             * @param {{ message: string, code: string }} res 
             */
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

    /**
     * Evento de escucha, al dar click modifica las clases y atributos de algunos elementos
     */
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

    /**
     * Evento de escucha, al dar click modifica las clases y atributos de algunos elementos
     */
    $("#btn-edit-centro").on("click", function () {
        $("#nombre_centro").attr("disabled", false);
        $("#nombre_centro").addClass("input-green");
        $("#tutor_centro").attr("disabled", false);
        $("#tutor_centro").addClass("input-green");
        $("#fp").attr("disabled", false);
        $("#fp").addClass("input-green");
        $("#div-edit-centro").addClass("d-none");
        $("#div-accept-centro").removeClass("d-none");
        $("#div-cancel-centro").removeClass("d-none");
    });

    /**
     * Evento de escucha, al dar click revisa los datos y realiza un ajax
     */
    $("#btn-accept-centro").on("click", function () {
        let $nombre = $("#nombre_centro").val();
        let $tutor = $("#tutor_centro").val();
        let $fp = $("#fp").val();

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

        if ($fp.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Campos incompletos",
                text: "Por favor rellene el campo ciclo formativo",
            });
            return;
        }

        $.ajax({
            url: "/cms/includes/ajax/update_center_data.php",
            method: "POST",
            data: $("#form-center-data").serialize(),
            /**
             * Si es correcto, mostrará el mensaje y modificará las clases y atributos de algunos elementos
             * Si no, dará el error
             * @param {{ message: string, code: string }} res 
             */
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
                    $("#fp").attr("disabled", true);
                    $("#fp").val($fp);
                    $("#fp").removeClass("input-green");
                    $("#div-edit-centro").removeClass("d-none");
                    $("#div-accept-centro").addClass("d-none");
                    $("#div-cancel-centro").addClass("d-none");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: res.message,
                    });
                }
            },
        });
    });

    /**
     * Evento de escucha, al dar click modifica las clases y atributos de algunos elementos
     */
    $("#btn-cancel-centro").on("click", function () {
        $("#nombre_centro").attr("disabled", true);
        $("#nombre_centro").val($name);
        $("#nombre_centro").removeClass("input-green");
        $("#tutor_centro").attr("disabled", true);
        $("#tutor_centro").val($email);
        $("#tutor_centro").removeClass("input-green");
        $("#fp").attr("disabled", true);
        $("#fp").val($fp);
        $("#fp").removeClass("input-green");
        $("#div-edit-centro").removeClass("d-none");
        $("#div-accept-centro").addClass("d-none");
        $("#div-cancel-centro").addClass("d-none");
    });
});

$(document).ready(function () {
    let $name = $("#nombre_lab").val();
    let $tutor = $("#tutor_lab").val();

    /**
     * Evento de escucha, al dar click modifica las clases y atributos de algunos elementos
     */
    $("#btn-edit-lab").on("click", function () {
        $("#nombre_lab").attr("disabled", false);
        $("#nombre_lab").addClass("input-green");
        $("#tutor_lab").attr("disabled", false);
        $("#tutor_lab").addClass("input-green");
        $("#div-edit-lab").addClass("d-none");
        $("#div-accept-lab").removeClass("d-none");
        $("#div-cancel-lab").removeClass("d-none");
    });

    /**
     * Evento de escucha, al dar click revisa los datos y realiza un ajax
     */
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
            /**
             * Si es correcto, muestra un mensaje y modifica las clases y atributos de algunos elementos
             * Si no, muestra el error
             * @param {{ message: string, code: string }} res 
             */
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

    /**
     * Evento de escucha, al dar click modifica las clases y atributos de algunos elementos
     */
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

/**
 * Convierte la fecha del formato que usa SQL a formato europeo
 * @param {string} fecha 
 * @returns {string} fecha modificada
 */
function fechaNormal(fecha) {
    const partes = fecha.split("-");
    if (partes.length !== 3) return fecha;
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

$(document).ready(function () {

    /**
     * Evento de escucha, al dar click revisa la fecha seleccionada, si no es lunes, dará error
     */
    $("#fecha").on("change", function () {
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

    /**
     * Evento de escucha, al dar click revisa los valores y manda un ajax
     */
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
            url: "/cms/includes/ajax/crear_ficha_semana.php",
            method: "POST",
            data: $("#form-create").serialize(),
            /**
             * Si es correcto, guarda el mensaje en la sessionStorage, recarga la web y mostrará el mensaje
             * Si no, dará error
             * @param {{ message: string, code: string }} res 
             */
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

/**
 * Evento de escucha, al dar click revisa los valores y manda un ajax
 */
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
            url: "/cms/includes/ajax/borrar_ficha.php",
            method: "POST",
            data: { id: $id },
            /**
             * Si es correcto, guarda el mensaje en la sessionStorage, recarga la web y mostrará el mensaje
             * Si no, dará error
             * @param {{ message: string, code: string }} res 
             */
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

/**
 * Evento de escucha, al dar click revisa los valores y manda un ajax
 */
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
        url: "/cms/includes/ajax/recuperar_datos.php",
        method: "POST",
        data: { id: $id },
        /**
         * Si es correcto, recorrerá todo el array mostrando los datos
         * @param {Array} res 
         */
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

/**
 * Evento de escucha, cuando se oculte el modal, reseteará el formulario y eliminará el elemento con clase id_edit
 */
$("#modal-editar").on("hidden.bs.modal", function () {
    $(this).find("#form-editar")[0].reset();
    $(this).find(".id-edit").remove();
});

/**
 * Evento de escucha, al dar click revisa los valores y manda un ajax
 */
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
        url: "/cms/includes/ajax/guardar_datos_ficha.php",
        method: "POST",
        data: $("#form-editar").serialize() + "&id=" + $id,
        /**
         * Si es correcto, guarda el mensaje en la sessionStorage, recarga la web y mostrará el mensaje
         * Si no, dará error
         * @param {{ message: string, code: string }} res 
         */
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

/**
 * Cuando carga la web, revisa si hay mensajes en el sessionStorage, si es así los muestra y luego los elimina
 */
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

/**
 * Evento de escucha, al dar click obtiene el id y abre una pestaña nueva con el pdf de la ficha
 */
$(document).on("click", ".btn-imprimir", function () {
    let $id = $(this).closest(".card").find(".f-id").val();
    const url = `/cms/includes/generar_ficha.php?fi=${$id}`;
    window.open(url, "_blank");
});

$(document).ready(function () {
    /**
     * Evento de escucha, al mostrar el modal, hace focus en el campo de pass
     */
    $("#modal-editar-password").on("shown.bs.modal", function(){
        $("#pass").focus();
    })

    /**
     * Evento de escucha, al dar enter pasa al siguiente campo
     */
    $("#pass").on("keydown", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            $("#pass2").focus();
        }
    })

    /**
     * Evento de escucha, al dar enter hace click en el botón de aceptar
     */
    $("#pass2").on("keydown", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            $("#btn-edit-password").focus().click();
        }
    })

    /**
     * Evento de escucha, al dar click en el botón revisa los valores y manda un ajax
     */
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
            url: "/cms/includes/ajax/edit_pass.php",
            method: "POST",
            data: {
                pass: $pass,
            },
            /**
             * Si es correcto, guarda el mensaje en la sessionStorage, recarga la web y mostrará el mensaje
             * Si no, dará error
             * @param {{ message: string, code: string }} res 
             */
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
    /**
     * Evento de escucha, al dar click modifica la clase del elemento
     */
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