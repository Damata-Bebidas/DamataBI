<footer class="rodape bg-gradiente-roda">
    <div class="social-icons">
        <a href="https://www.facebook.com/pages/Damata-Bebidas/168898176499272"><i class="fab fa-facebook"></i></a>
        <a href="https://www.linkedin.com/in/marcus-gabriel-32bb49223/">
            <i class="fab fa-linkedin"></i></a>
        <a href="suporte.php"><i class="fa fa-envelope"></i></a>
    </div>
    <div class="copyright">
        Damata <?php echo date("Y"); ?> &COPY;<br/><small>Desenvolvido por Marcus Gabriel</small><br>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
    $(".btn-menu").click(function(){
        $(".menu").show(); //abre
    });
    $(".btn-close").click(function(){
        $(".menu").hide();//fechar
    });
</script>
</div>
</body>
</html>
<!-- Bootstrap -->
<script type="text/javascript" src='_bootstrap4.5.0/js/jquery-3.5.1.min.js'></script>
<script type="text/javascript" src='_bootstrap4.5.0/js/bootstrap.min.js'></script>
<!-- Padrão para LGPD #1A0C5F,#2e1b5a -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
    window.addEventListener("load", function(){
    window.cookieconsent.initialise({
                    "palette": {
                        "popup": {
                            "background": "#1A0C5F",
                            "text": "#f1f1f1"
                        },
                        "button": {
                            "background": "#ababab"
                        }
                    },
                    "content": {
                        "message": "Este site usa cookies para garantir que você obtenha a melhor experiência.",
                        "link": "Leia mais",
                        "dismiss": "Aceito!",
                        "href": "http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm"
                    }
                }
            )
        }
    );
</script>
