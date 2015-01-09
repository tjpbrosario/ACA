<?php
    include "utf8.php";
    session_start();
	if (isset($_SESSION['login'])) {
	
	echo "Pageviews = ". $_SESSION['login']; //retrieve data
	
	if ($_SESSION['login']!=0) {
	echo "Pageviews = ". $_SESSION['login']; //retrieve data
	//header ("Location: login3.php");
echo ("Entrou");
	
	
    $nome;
    $mensagem;
    
    define ("GUESTBOOK", "LivroVisitas.log");
    
    function estaPreenchido ($input){
        if (is_string($input)){
            $input=trim($input);
            return strlen($input)>0;
        }    
        
        return isset($input);
    }//estaPreenchido

    function receberDados(){
        global $nome; global $mensagem;
        
        $nome=estaPreenchido ($_POST['nome'])? $_POST['nome'] : "John anonymous";
        
        $estaPreenchida=estaPreenchido;
        
        $mensagem=$estaPreenchida ($_POST['mensagem'])? $_POST['mensagem'] : "Uma pessoa reservada.";    
        
        /*
        $GLOBALS['nome']=$_POST['nome'];
        $GLOBALS['mensagem']=$_POST['nome'];
        */
    }//receberDados
    
    function receberDadosAgnostico(){
        foreach ($_REQUEST as $endereco => $valor){
            $GLOBALS[$$endereco]=$valor;
        }//foreach
    }//receberDadosAgnostico
    
    function sanitizarDados ($dados){
        $ret = str_replace (PHP_EOL, "<br>", $dados);
        return $ret;
    }
    
    function registarDados(){
        //global $nome; global $mensagem;
        $fo=fopen (GUESTBOOK, 'a');
        
        if ($fo!==false){
            //é possível aceder à base de dados
            $nome=$GLOBALS['nome'];
            $mensagem=$GLOBALS['mensagem'];
            $linha="$nome\t$mensagem";
            
            flock ($fo, LOCK_EX);
        
            $linhaAdaptada = sanitizarDados ($linha).PHP_EOL;
            
            fputs ($fo, $linhaAdaptada);
            
            flock ($fo, LOCK_UN);
            
            fclose ($fo);
            return true;    
        }
        else{
            //não foi possível atualizar a base de dados
            return false;
        }
    }//registarDados
    
    function feedbackDasOpsFeitas($sucessoNoRegisto){
        //var_dump ($GLOBALS);
        $m="<h1>Obrigado por assinar o meu Guestbook!</h1>";
        $m.="<h2>Recebi as seguintes contribuições:</h2>";
        $m.="Nome: ".$GLOBALS['nome'];
        $m.="<br>";
        $m.="Mensagem: ".$GLOBALS['mensagem'];
        
        $m.="<hr>";
        
        $m.=$sucessoNoRegisto?
            "<mark>Dados registados OK!</mark>"
            :
            "<mark>Erro ao registar dados. Lamento.</mark>";
            
        echo $m;
    }//feedbackDasOpsFeitas
    
    receberDados();
    
    $sucesso=registarDados();
    
    feedbackDasOpsFeitas($sucesso);  
	
	echo'<br> <a href="ver_tudo.php">Ver todo o conteudo do livro de visitas</a>';
	
}
 }
 else{
 	
 echo("<h1><a href=\"http://localhost:8080/ProjectoACA/login.html\" >Por favor registe-se na pagina inicial<a></h1>"); 
}


	  
?>
