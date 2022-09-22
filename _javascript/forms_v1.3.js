function validarAlterarSenha (){
    if(document.formAlterarSenha.Senha.value === ""){
        alert("Campo Senha não foi preenchido!!!");
        document.formAlterarSenha.Senha.focus();
        return false;
    }
    if(document.formAlterarSenha.Senha2.value === ""){
        alert("Campo Confirma Senha 2 não foi preenchido!!!");
        document.formAlterarSenha.Senha2.focus();
        return false;
    }
    var senha1,senha2;
    senha1 = document.getElementById("Senha").value;
    senha2 = document.getElementById("Senha2").value;
    
    if(senha1 !== senha2) {
        alert("Senhas digitadas estão diferentes!!!");
        document.formAlterarSenha.Senha.focus();
        document.formAlterarSenha.Senha2.focus();
        return false;
    }
    var qtd1 = document.formAlterarSenha.Senha.value;
    var qtd2 = document.formAlterarSenha.Senha2.value;
    if(qtd1<8 || qtd2<8){
        alert("Senha tem ser maior que 8 Digitos!!!");
        return false;
    }
}
function mostrarArea(){
    document.getElementById("new").className = "show";
}

function ObterBrowserUtilizado() {
    var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    
    var isFirefox = typeof InstallTrigger !== 'undefined';
    var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    
    var isChrome = !!window.chrome && !isOpera;              
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    if (isOpera) {
        return "Opera"; //valor que será retornado
    }
    else if (isFirefox) {
        return Firefox; //valor que será retornado
    }
    else if (isChrome) {
        return "Google Chrome"; //valor que será retornado
    }
    else if (isSafari) {
        return "Safari"; //valor que será retornado
    }
    else if (isIE) {
        return "Internet Explorer"; //valor que será retornado
    }
    else {
        return "Outro"; //valor que será retornado
    }
}

function ObterTela(){
    //pega a largura da resolução da tela
    var width = screen.width;
    //pega a altura da resolução da tela
    var height = screen.height;
    //verifica se a resolução dará uma boa visão do site
    if (width >= 800 || height >= 600)
        //alert("A resolução da tela do seu monitor é " + width + "x" + height + ". Para visualizar o site é recomendado uma resolução de no mínimo 1024x768.");
        return true;
    else
        //alert("A resolução da tela do seu monitor é " + width + "x" + height + ".");
        return false;

}
function InverterData(data){
    var datatxt = data.replace(/-/g,"");//tirar -
    var qtd = datatxt.length; 
    var ano = datatxt.substring(0,qtd -4);
    var mes = datatxt.substring(4,qtd -2);
    var dia = datatxt.substring(6,qtd);
    if (datatxt!="") {
        var datafinal = dia + "/"+ mes + "/" + ano;    
    }else{
        var datafinal = "";
    }
    return datafinal;
}
function lentSucess() {
    alert('Planejamento da LENT Salvo com sucesso!!!');
}
function provaSucess(){
    alert('Prova Salva com sucesso!!!');
}
function portariaSucess() {
    alert('Registro Salvo com Sucesso!!!');
}
function alterado() {
    alert('Dados alterados com sucesso!!!');
}
function acesso(){
    alert("Erro ao acessar o Sistema!\nVocê precisa está logado!");
}
function nlogin() {
    alert('Usuário ou senha inválidos!');
}
function recupera(){
    alert('Sua senha agora = Data de Nascimento');
}
function sucessTreinamento() {
    alert('Lançamento da Lista LENT Salvo com sucesso!!!');
}
function UpFoto() {
    alert('Foto foi salva com sucesso');
}
function pesquisaOK(){
    alert('Pesquisa Salva com Sucesso!!!');
}
function censoOK(){
    alert('Dados Salvo com Sucesso!!!');
}
function validaCheck(){
    if(document.formcheck.qt0.value == ""){
        alert("Questão Nº1 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt1.value == ""){
        alert("Questão Nº2 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt2.value == ""){
        alert("Questão Nº3 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt3.value == ""){
        alert("Questão Nº4 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt4.value == ""){
        alert("Questão Nº5 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt5.value == ""){
        alert("Questão Nº6 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt6.value == ""){
        alert("Questão Nº7 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt7.value == ""){
        alert("Questão Nº8 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt8.value == ""){
        alert("Questão Nº9 Não foi preenchida...");
        return false;
    }
    if(document.formcheck.qt9.value == ""){
        alert("Questão Nº10 Não foi preenchida...");
        return false;
    }
}

function validaCheckConfig(){
    if(document.formcheckConfig.instrutor.value == ""){
        alert("Campo Instrutor Não preenchido...");
        return false;
    }
    if(document.formcheckConfig.qt0.value == "" || document.formcheckConfig.qtA0.value == "" 
        || document.formcheckConfig.qtB0.value == "" || document.formcheckConfig.qtC0.value == "" 
        || document.formcheckConfig.qtD0.value == "" || document.formcheckConfig.gab0.value == ""){
        alert("Questão Nº1 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt1.value == "" || document.formcheckConfig.qtA1.value == "" 
        || document.formcheckConfig.qtB1.value == "" || document.formcheckConfig.qtC1.value == "" 
        || document.formcheckConfig.qtD1.value == "" || document.formcheckConfig.gab1.value == ""){
        alert("Questão Nº2 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt2.value == "" || document.formcheckConfig.qtA2.value == "" 
        || document.formcheckConfig.qtB2.value == "" || document.formcheckConfig.qtC2.value == "" 
        || document.formcheckConfig.qtD2.value == "" || document.formcheckConfig.gab2.value == ""){
        alert("Questão Nº3 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt3.value == "" || document.formcheckConfig.qtA3.value == "" 
        || document.formcheckConfig.qtB3.value == "" || document.formcheckConfig.qtC3.value == "" 
        || document.formcheckConfig.qtD3.value == "" || document.formcheckConfig.gab3.value == ""){
        alert("Questão Nº4 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt4.value == "" || document.formcheckConfig.qtA4.value == "" 
        || document.formcheckConfig.qtB4.value == "" || document.formcheckConfig.qtC4.value == "" 
        || document.formcheckConfig.qtD4.value == "" || document.formcheckConfig.gab4.value == ""){
        alert("Questão Nº5 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt5.value == "" || document.formcheckConfig.qtA5.value == "" 
        || document.formcheckConfig.qtB5.value == "" || document.formcheckConfig.qtC5.value == "" 
        || document.formcheckConfig.qtD5.value == "" || document.formcheckConfig.gab5.value == ""){
        alert("Questão Nº6 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt6.value == "" || document.formcheckConfig.qtA6.value == "" 
        || document.formcheckConfig.qtB6.value == "" || document.formcheckConfig.qtC6.value == "" 
        || document.formcheckConfig.qtD6.value == "" || document.formcheckConfig.gab6.value == ""){
        alert("Questão Nº7 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt7.value == "" || document.formcheckConfig.qtA7.value == "" 
        || document.formcheckConfig.qtB7.value == "" || document.formcheckConfig.qtC7.value == "" 
        || document.formcheckConfig.qtD7.value == "" || document.formcheckConfig.gab7.value == ""){
        alert("Questão Nº8 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt8.value == "" || document.formcheckConfig.qtA8.value == "" 
        || document.formcheckConfig.qtB8.value == "" || document.formcheckConfig.qtC8.value == "" 
        || document.formcheckConfig.qtD8.value == "" || document.formcheckConfig.gab8.value == ""){
        alert("Questão Nº9 Não foi preenchida...");
        return false;
    }

    if(document.formcheckConfig.qt9.value == "" || document.formcheckConfig.qtA9.value == "" 
        || document.formcheckConfig.qtB9.value == "" || document.formcheckConfig.qtC9.value == "" 
        || document.formcheckConfig.qtD9.value == "" || document.formcheckConfig.gab9.value == ""){
        alert("Questão Nº10 Não foi preenchida...");
        return false;
    }
}

function validaEntrevista(){
    var campos = ['Tipo','data','Motivo','Acao','Inicio','Fim'];
    for (var i = 0; i < campos.length; i++) {
        let campo = document.getElementById(campos[i]).value;
        if(campo == ""){
            alert("Campo " + campos[i] + " não foi preenchido!!!");
            setor = document.getElementById(campos[i]).focus();
            return false;
        }
    }

    var camposCheck = ['SemJustificativa1', 'SemJustificativa2','ComunicarPrevia1', 'ComunicarPrevia2','JustificativaCompativel1', 'JustificativaCompativel2','AcatadaPelaEmpresa1', 'AcatadaPelaEmpresa2','DiaDescontado1', 'DiaDescontado2','FolgaAlinhada1', 'FolgaAlinhada2'];
    var total = camposCheck.length;
    for (var i = 0; i < total; i++) {
        let campo1 = document.getElementById(camposCheck[i]).checked;
        let campo2 = document.getElementById(camposCheck[(i + 1)]).checked;
        
        if((!campo1) && (!campo2) && (i%2==0)){
            alert("Campo " + camposCheck[i].substr(0, ( camposCheck[i].length - 1 )) + " não foi preenchido!!!");
            setor = document.getElementById(camposCheck[i]).focus();
            return false;
        }
    }
}

function validaPenalidades(){
    var campos = ['data','Motivo','Tipo','Aplicador'];
    for (var i = 0; i < campos.length; i++) {
        let campo = document.getElementById(campos[i]).value;
        if(campo.trim() == ""){
            alert("Campo " + campos[i] + " não foi preenchido!!!");
            setor = document.getElementById(campos[i]).focus();
            return false;
        }
    }
}