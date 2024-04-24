const checkbox = document.querySelector("#showPass");
const senhaInput = document.querySelector("#senha");

checkbox.addEventListener("change", function () {
  if (this.checked) {
    senhaInput.type = "text"; // Mostra a senha como texto
  } else {
    senhaInput.type = "password"; // Oculta a senha
  }
});


// Evento de envio de formulario
const form = document.querySelector("form");
form.addEventListener("submit", async (event) => {
  event.preventDefault();

  // Declarando variaveis e recebendo valores
  var erros = "";
  const spanErros = document.getElementById("erros");
  spanErros.textContent = "";
  const senha = document.getElementById("senha").value;
  const username = document.getElementById("username").value;

  // Verificando se os inputs estão preenchidos
  if (username === "" || senha === "") {
    erros = "Preecha Todos os Campos";
  }

  // Verifica se não foram encontrados erros
  if (erros === "") {
    // Tipo da requesição
    const type = "login";

    //Envia os dados para a api executar o registro
    fetch("controllers/auth.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username, senha, type }),
    }).then(async (response) => {
      // Verifica se o registro foi feito com sucesso
      const data = await response.json();
      console.log(data);

      // Login valido
      if(data.s == "sucess") {
        window.location.replace("Home");
      }

      // Login invalido
      if(data.s == "erro") {
        spanErros.textContent = data.m;
      }

    });
  } else {
    spanErros.textContent = erros;
  }
});
