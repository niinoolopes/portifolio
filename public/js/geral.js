if (document.getElementById("BANCO_ID")) {
    document
        .getElementById("BANCO_ID")
        .addEventListener("change", function (event) {
            var i = event.target.selectedIndex;
            var option = event.target.querySelectorAll("option")[i];
            var src = option.getAttribute("data-logo");
            var img = document.getElementById("input-bank-img");

            if (src) {
                img.setAttribute("src", `${PATH}/${src}`);
            } else {
                img.setAttribute("src", pedido_logo_default);
            }
        });
}

if (document.querySelector("[change-logo]")) {
    $("[change-logo]").on("change", function (e) {
        var data = e.target.getAttribute("change-logo");

        // console.log(document.querySelector("[img-logo]").files[0].path);
        document.querySelector(`[label-logo="${data}"]`).classList.add('d-none')
    });
}

if (document.querySelector('#form-cadastro')) {
    document.querySelector('#form-cadastro').addEventListener('submit', function (form) {
        form.preventDefault();

        if (document.querySelector('#COMPROVANTE').value == '') {
            if (confirm('Deseja fazer o cadastro sem o comprovante?')) {
                form.target.submit()
            }
        } else {
            form.target.submit()
        }
    })
}

if (document.getElementById("tab-usuarios")) {
    $("#tab-usuarios a").on("click", function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
}

if (document.querySelector("[show-senha]")) {
    $("[show-senha]").on("click", function (e) {
        var data = e.target.getAttribute("show-senha");

        var type = document
            .querySelector(`[input-senha="${data}"]`)
            .getAttribute("type");

        if (type == "password") {
            console.log("password");
            document.querySelector(`[input-senha="${data}"]`).setAttribute("type", "text");
            e.target.classList.remove('fa-eye-slash')
            e.target.classList.add('fa-eye')
        }

        if (type == "text") {
            console.log("text");
            document.querySelector(`[input-senha="${data}"]`).setAttribute("type", "password");
            e.target.classList.remove('fa-eye')
            e.target.classList.add('fa-eye-slash')
        }
    });
}

if (document.querySelector("[input-status]")) {
    $("[input-status]").on("change", function (e) {
        var data = e.target.getAttribute("input-status");
        var input = document.querySelector(`[input-status="${data}"]`)
        var text = input.getAttribute("data-text")
        var status = input.checked

        if (status)
            document.querySelector(`[label-status="${data}"]`).innerHTML = input.getAttribute("data-text-ativo");

        if (!status)
            document.querySelector(`[label-status="${data}"]`).innerHTML = input.getAttribute("data-text-inativo");
    });
}

if (document.getElementById("filtro")) {
    document.getElementById("filtro").addEventListener('change', function ({ target }) {
        var input = document.getElementById("conteudo")
        var val = target.value

        if (val == 'numero-atendimento') {
            input.setAttribute('type', 'text')
        } else if (val == 'empresa') {
            input.setAttribute('type', 'text')
        } else if (val == 'valor') {
            input.value = ""
            input.setAttribute('type', 'number')
            input.setAttribute('step', '0.01')
        } else {
            input.value = ""
            input.removeAttribute('step')
        }
    })
}


if (document.querySelectorAll(".cancelar-pedido").length > 0) {
    document.querySelectorAll(".cancelar-pedido").forEach(item => {
        item.addEventListener('click', function () {

            document.querySelector('[data-target="#modalPedidoCancelar"]').click()

            const form = document.querySelector('#form-cancelar-pedido')
            form.setAttribute('href', item.getAttribute('href'))
            form.setAttribute('acao', item.getAttribute('acao'))
            form.setAttribute('pedido_id', item.getAttribute('pedido_id'))

            // if (confirm("Ao excluir irá apagar permanente, você confirma?")){
            //     window.location.href = item.getAttribute('src')
            // }
        })
    })
}


if (document.querySelectorAll(".deletar-pedido").length > 0) {
    document.querySelectorAll(".deletar-pedido").forEach(item => {
        item.addEventListener('click', function () {
            if (confirm("Ao excluir irá apagar permanente, você confirma?")) {
                window.location.href = item.getAttribute('src')
            }
        })
    })
}


if (document.querySelector('#form-cancelar-pedido')) {
    document.querySelector('#form-cancelar-pedido')
        .addEventListener('submit', function (event) {
            event.preventDefault()

            var motivos = Array.from(document.querySelectorAll('[name="exampleRadios"]'))
            var motivo_id = motivos.filter(e => e.checked)[0].value

            event.target.getAttribute('href')

            var href = event.target.getAttribute('href')
            var acao = event.target.getAttribute('acao')
            var pedido_id = event.target.getAttribute('pedido_id')

            window.location.href = `${href}/pedido/${acao}/${pedido_id}/${motivo_id}`

        })
}
