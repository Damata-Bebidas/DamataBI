function validaCadastro(){
    if(document.portaria.cpf.value == ""){
        alert("Campo CPF não foi preenchido!!!");
        document.portaria.cpf.focus();
        return false;
    }
    var cpf = document.getElementById("cpf").value;
    if(validaCPF(cpf)){
    }else{
	    alert("CPF Invalido!!!");
        document.portaria.getElementById("cpf").focus();
	    return false;
    }
    var email1,email2;
    email1 = document.getElementById("cMail").value;
    email2 = document.getElementById("cCMail2").value;
    if(email1 != email2) {
        alert("o E-mail's digitados estão diferente um do outro!!!");
        document.formCadastro.tMail.focus();
        return false;
    }
}
function validaCPF(cpf){
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
          return false;
    for (i = 0; i < cpf.length - 1; i++)
          if (cpf.charAt(i) != cpf.charAt(i + 1)){
                digitos_iguais = 0;
                break;}
    if (!digitos_iguais){
          numeros = cpf.substring(0,9);
          digitos = cpf.substring(9);
          soma = 0;
          for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0))
                return false;
          numeros = cpf.substring(0,10);
          soma = 0;
          for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(1))
                return false;
	        return true;
          }
    else
        return false;
  }

  function validaLogin(){
    if(document.formLogin.login.value == ""){
        alert("Campo E-mail não foi preenchido!!!");
        document.formLogin.login.focus();
        return false;
    }
    if(document.formLogin.senha.value == ""){
        alert("Campo Senha não foi preenchido!!!");
        document.formLogin.senha.focus();
        return false;
    }
    var qtd = document.formLogin.senha.value;
    if(qtd<8){
        alert("Senha tem ser maior que 8 Digitos!!!");
        document.formLogin.senha.focus();
        return false;
    }
  }
  function validaMatricula(){
    matricula = document.portaria.matricula.value;
    if(matricula==""){
        alert("Campo Matricula não foi preenchido!!!");
        return false;
    }
  }
  function validaCenso(){
    var campos = ['setor','idade','tempo','estadocivil','escolaridade',
            'religiao','orientacaosexual','cor',];
    for (var i = 0; i < campos.length; i++) {
        let campo = document.getElementById(campos[i]).value;
        if(campo == "------------------"){
            alert("Campo " + campos[i] + " não foi preenchido!!!");
            setor = document.getElementById(campos[i]).focus();
            return false;
        }
    }
}
function validaPlanoBH(){
    var campos = ['saldo','abatido','data','status',
            'autorizado'];
    for (var i = 0; i < campos.length; i++) {
        let campo = document.getElementById(campos[i]).value;
        if(campo == ""){
            alert("Campo " + campos[i] + " não foi preenchido!!!");
            setor = document.getElementById(campos[i]).focus();
            return false;
        }
    }
    if(!document.getElementById('pagarcomp').checked){
        alert("Campo Pagar ou Compensar não foi preenchido!!!");
        setor = document.getElementById('pagarcomp').focus();
        return false;
    }
}

function validaSimulador(){
    if((!document.getElementById('serasaOK').checked) 
        && (!document.getElementById('serasaPen').checked)){
        alert("Campo Serasa não foi preenchido!!!");
        setor = document.getElementById('serasaOK').focus();
        return false;
    }

    var campos = ['qtd','status'];
    
    for (var i = 0; i < campos.length; i++) {
        let campo = document.getElementById(campos[i]).value;
        if(campo == ""){
            alert("Campo " + campos[i] + " não foi preenchido!!!");
            setor = document.getElementById(campos[i]).focus();
            return false;
        }
    }
    
    if(document.getElementById('motivo').value == "" 
        && document.getElementById('status').value == "REPROVADO"){
        alert("Campo Motivo não foi preenchido!!!");
        setor = document.getElementById('motivo').focus();
        return false;
    }
}

function validaEntrada(){
    let hora;
    console.log(document.getElementById('hora').value);
    if(document.getElementById('hora').value==""){
        alert("Campo Hora não foi preenchido!!!");
        hora = document.getElementById('hora').focus();
        return false;
    }
}

function mostrarDef() {
    let div = document.getElementById("divpcd");
    let conteudo = "<div class='radio'>\n\
        <label for='deficiencia'>13-Se você respondeu que possui deficiência, assinale a deficiência autodeclarada?</label><br/>\n\
        <input type='radio' name='deficiencia' value='A' /> PCD auditivo <br/>\n\
        <input type='radio' name='deficiencia' value='F' checked='checked'/> PCD fisico <br/>\n\
        <input type='radio' name='deficiencia' value='I' /> PCD intelectual <br/>\n\
        <input type='radio' name='deficiencia' value='V' /> PCD visual <br/>\n\
        <input type='radio' name='deficiencia' value='M' /> PCD múltipla <br/>\n\
        <input type='radio' name='deficiencia' value='N'  /> Não possuo deficiência <br/></div>" ;
    document.getElementById("divpcd").innerHTML = conteudo;
}
function esconderDef() {
    let div = document.getElementById("divpcd");
    let conteudo = "<div class='radio'>\n\
        <label for='deficiencia'>13-Se você respondeu que possui deficiência, assinale a deficiência autodeclarada?</label><br/>\n\
        <input type='radio' name='deficiencia' value='A' disabled='disabled' /> PCD auditivo <br/>\n\
        <input type='radio' name='deficiencia' value='F' disabled='disabled'/> PCD fisico <br/>\n\
        <input type='radio' name='deficiencia' value='I' disabled='disabled'/> PCD intelectual <br/>\n\
        <input type='radio' name='deficiencia' value='V' disabled='disabled'/> PCD visual <br/>\n\
        <input type='radio' name='deficiencia' value='M' disabled='disabled'/> PCD múltipla <br/>\n\
        <input type='radio' name='deficiencia' value='N' disabled='disabled' checked='checked'/> Não possuo deficiência <br/></div>" ;
    document.getElementById("divpcd").innerHTML = conteudo;
}