$(document).ready(function() {

    //Variables iniciales
    var errorHabitacion = document.getElementById("errorMSGHabitacion");
    errorHabitacion.hidden = true;

    var errorVoucher = document.getElementById("errorMSGVoucher");
    errorVoucher.hidden = true;

    var errorRazonVisita = document.getElementById("errorMSGRazonVisita");
    errorRazonVisita.hidden = true;

    var errorNombre = document.getElementById("errorMSGNombre");
    errorNombre.hidden = true;

    var errorApellidos = document.getElementById("errorMSGApellidos");
    errorApellidos.hidden = true;

    var errorCheck= document.getElementById("errorMSGCheck");
    errorCheck.hidden = true;
    
    // Recoleccion sistema Operativo
    var OSName="Otro";
    if (navigator.appVersion.indexOf("Win")!=-1){ OSName="Windows" }
    if (navigator.appVersion.indexOf("Mac")!=-1){ OSName="MacOS" }
    if (navigator.appVersion.indexOf("X11")!=-1){ OSName="UNIX" }
    if (navigator.appVersion.indexOf("Linux")!=-1){ OSName="Linux" }
    if (navigator.appVersion.indexOf("Android")!=-1){ OSName="Android" }
    $("#os").val(OSName);
    
    //Submit evento
    $('#submit').click(function(e){
        e.preventDefault();

        submitButton = document.getElementById('submit');
        submitButton.disabled = true;

        var nombre = $("#nombre").val();
        var apellidos = $("#apellidos").val();
        var num_habitacion = $("#num_habitacion").val();
        var razon_visita = $("#razon_visita").val();
        var voucher = $("#voucher").val();
        var os =  $("#os").val();
        var lang =  $("#lang").val();
        var check = document.getElementById("gridCheck").checked;

        $.ajax({
            type: "POST",
            url: "../controladores/formulario_controller.php",
            dataType: "json",
            data: {
                nombre:nombre, 
                apellidos:apellidos, 
                num_habitacion:num_habitacion, 
                razon_visita:razon_visita,
                voucher:voucher,
                os: os,
                check: check,
                lang: lang
            },
            success : function(data) {
                console.log(data)
                if (data.code == "200"){
                    window.location = '../vistas/banner.php';
                } else {
                    submitButton.disabled = false;
                    if (data.errorHabitacion) {
                        setErrorHabitacion(data);
                    }
                    if (data.errorVoucher) {
                        setErrorVoucher(data);
                    }
                    if (data.errorRazonVisita) {
                        setErrorRazonVisita(data);
                    }
                    if (data.errorNombre) {
                        setErrorNombre(data);
                    }
                    if (data.errorApellidos) {
                        setErrorApellidos(data);
                    }
                    if (data.errorCheck) {
                        setErrorCheck(data);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' ' + errorThrown);
            }
        });
    });
    
})


function setErrorHabitacion(data) {
    var spanErrorHabitacion = document.getElementById("errorMSGHabitacion");
    spanErrorHabitacion.textContent = data.errorMSGHabitacion;
    spanErrorHabitacion.hidden = false;
    var formGroupHabitacion = document.getElementById("form_group_habitacion");
    formGroupHabitacion.classList.add("input_error");
}

function setErrorVoucher(data) {
    var spanErrorVoucher = document.getElementById("errorMSGVoucher");
    spanErrorVoucher.hidden = false;
    spanErrorVoucher.textContent = data.errorMSGVoucher;
    var formGroupVoucher = document.getElementById("form_group_voucher");
    formGroupVoucher.classList.add("input_error");
}

function setErrorRazonVisita(data) {
    var spanErrorRazonVisita = document.getElementById("errorMSGRazonVisita");
    spanErrorRazonVisita.hidden = false;
    spanErrorRazonVisita.textContent = data.errorMSGRazonVisita;
    var formGroupRazonVisita = document.getElementById("form_group_razon");
    var formGroupRazonVisita1 = document.getElementById("razon_visita");
    formGroupRazonVisita.classList.add("input_error");
    formGroupRazonVisita1.style.backgroundColor="#fb9a9aba";
    formGroupRazonVisita1.style.color="white";
}

function setErrorNombre(data) {
    var spanErrorNomnbre = document.getElementById("errorMSGNombre");
    spanErrorNomnbre.hidden = false;
    spanErrorNomnbre.textContent = data.errorMSGNombre;
    var formGroupNombre = document.getElementById("form_group_nombre");
    formGroupNombre.classList.add("input_error");
}

function setErrorApellidos(data) {
    var spanErrorApellidos = document.getElementById("errorMSGApellidos");
    spanErrorApellidos.hidden = false;
    spanErrorApellidos.textContent = data.errorMSGApellidos;
    var formGroupApellidos = document.getElementById("form_group_apellidos");
    formGroupApellidos.classList.add("input_error");
}

function setErrorCheck(data) {
    var spanErrorCheck = document.getElementById("errorMSGCheck");
    spanErrorCheck.hidden = false;
    spanErrorCheck.textContent = data.errorMSGCheck;
    var formGroupCheck = document.getElementById("form_group_check");
    formGroupCheck.classList.add("input_error");
}


function quitErrorHabitacion() {    
    var formGroupHabitacion = document.getElementById("form_group_habitacion");
    if (formGroupHabitacion.classList.contains("input_error")) {
        formGroupHabitacion.classList.remove("input_error");
        var inputHabitacion = document.getElementById("num_habitacion");
        inputHabitacion.value = "";
        var spanErrorHabitacion = document.getElementById("errorMSGHabitacion");
        if(spanErrorHabitacion != null) {
            spanErrorHabitacion.textContent = "";
            spanErrorHabitacion.hidden = true;
        }        
    }   
    
}

function quitErrorVoucher() {
    var formGroupVoucher = document.getElementById("form_group_voucher");
    if (formGroupVoucher.classList.contains("input_error")) {
        formGroupVoucher.classList.remove("input_error");
        var inputVoucher= document.getElementById("voucher");
        inputVoucher.value = "";
        var spanErrorVoucher = document.getElementById("errorMSGVoucher");
        if(spanErrorVoucher != null) {
            spanErrorVoucher.hidden = true;
            spanErrorVoucher.textContent = "";
        }  
    }
}

function quitErrorRazonVisita() {
    var formGroupVoucher = document.getElementById("form_group_razon");
    var formGroupVoucher1 = document.getElementById("razon_visita");
    formGroupVoucher1.style.backgroundColor="white";
    formGroupVoucher1.style.color="#495057";
    if (formGroupVoucher.classList.contains("input_error")) {
        formGroupVoucher.classList.remove("input_error");
        var inputVoucher= document.getElementById("razon_visita");
        inputVoucher.value = "";
        var spanErrorVoucher = document.getElementById("errorMSGRazonVisita");
        if(spanErrorVoucher != null) {
            spanErrorVoucher.hidden = true;
            spanErrorVoucher.textContent = "";
        }  
    }
}


function quitErrorNombre() {
    var formGroupNombre = document.getElementById("form_group_nombre");
    if (formGroupNombre.classList.contains("input_error")) {
        formGroupNombre.classList.remove("input_error");
        var inputNombre= document.getElementById("nombre");
        inputNombre.value = "";
        var spanErrorNombre = document.getElementById("errorMSGNombre");
        if(spanErrorNombre != null) {
            spanErrorNombre.hidden = true;
            spanErrorNombre.textContent = "";
        }  
    }
}


function quitErrorApellidos() {
    var formGroupApellidos = document.getElementById("form_group_apellidos");
    if (formGroupApellidos.classList.contains("input_error")) {
        formGroupApellidos.classList.remove("input_error");
        var inputApellidos= document.getElementById("apellidos");
        inputApellidos.value = "";
        var spanErrorApellidos = document.getElementById("errorMSGApellidos");
        if(spanErrorApellidos != null) {
            spanErrorApellidos.hidden = true;
            spanErrorApellidos.textContent = "";
        }  
    }
}

function quitErrorCheck() {
    var formGroupCheck = document.getElementById("form_group_check");
    if (formGroupCheck.classList.contains("input_error")) {
        formGroupCheck.classList.remove("input_error");       
        var spanErrorCheck = document.getElementById("errorMSGCheck");
        if(spanErrorCheck != null) {
            spanErrorCheck.hidden = true;
            spanErrorCheck.textContent = "";
        }  
    }  
}

function restaurarInputHabitacion() {
    quitErrorHabitacion();
}

function restaurarInputVoucher() {
    quitErrorVoucher();
}
function restaurarInputRazonVisita() {
    quitErrorRazonVisita();
}

function restaurarInputNombre() {
    quitErrorNombre();
}

function restaurarInputApellidos() {
    quitErrorApellidos();
}

function restaurarInputCheck() {
    quitErrorCheck();
}

function maxLengthCheck(object)
{
    if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength)
};

function validate() {
    var element = document.getElementById('nombre');
    element.value = element.value.replace(/[^a-zA-Z0\s]+/, '');
};

function validateApellidos() {
    var element = document.getElementById('apellidos');
    element.value = element.value.replace(/[^a-zA-Z0\s]+/, '');
};



