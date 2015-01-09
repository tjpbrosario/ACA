<?php

  define ("DEBUG", true);
      // estabelecer ligação

	session_start();
	if (isset($_SESSION['login'])) {
	
	echo "Pageviews = ". $_SESSION['login']; //retrieve data
	
	if ($_SESSION['login']!=0) {
	echo "Pageviews = ". $_SESSION['login']; //retrieve data
	//header ("Location: login3.php");
echo ("Entrou");



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$Alim = $_POST['Alimento'];
	$Qty = $_POST['Quantidade'];
	
}
echo "Qty: ".$Qty." ";
	  
    function estabelecerLigacaoMySQL
    ($servidor="localhost", $user="admin", $schema="getao_dispensa", $porto=3333)
    {   
	  	$sal = "uisdhmftcklszrguilrhgmdklfhjvmlsdfkjcghmsdkjfhmsdkj";
	  	$pass="admin";
	  	$pwd= sha1($sal.$pass);

        $bd = mysqli_connect($servidor, $user, $pass, $schema, $porto); //obj "mysqli" ou false se falhar
        $codigoDeErroDaUltimaOpDeConnect = mysqli_connect_errno(); //int
        $mensagemDeErroDaUltimaOpDeConnect = mysqli_connect_error(); //string
        
        echo "Código de erro obtido= ".$codigoDeErroDaUltimaOpDeConnect;
        
        $sucesso = $bd!==false;
        $sucesso = $mensagemDeErroDaUltimaOpDeConnect==="";
        $sucesso = $codigoDeErroDaUltimaOpDeConnect===0;
        
        if ($sucesso){
            //tenho um ponteiro para o serviço    
            if (DEBUG){
                $msg="<h1>Sucesso no estabelecimento da ligação!</h1>";
                echo $msg;
            }//if
            return $bd;
        }//if
        else{
            if (DEBUG){
                $msg = "<h1>Fracasso no estabelecimento da ligação:";
                $msg.=" código de erro = $codigoDeErroDaUltimaOpDeConnect ";
                $msg.=" mensagem erro = $mensagemDeErroDaUltimaOpDeConnect";
                $msg.="</h1>";
                echo $msg;    
            }//if
            
        }//else
        
        return false;
    }//estabelecerLigacaoMySQL
	
	
	function inserirAlimentoNaTabela ($nome, $quantidade, $bd){
	
        $objetoBdOk = $bd!==false;
		$nomeOk= strlen($nome)>0;
		$quantidadeOk= is_int (strlen($quantidade));
        $ok =  $objetoBdOk && $nomeOk &&  $quantidadeOk;
        echo "Quantidade original ".$quantidade;
		echo "<br>";
		echo "object BD ".$objetoBdOk;
		echo "<br>";
		echo "Nome ".$nomeOk;
		echo "<br>";
		echo "Quantidade ".$quantidadeOk;
		echo "<br>";
		
        if ($ok)
        {
            $sqlParaInsert = "INSERT INTO `getao_dispensa`.`alimentos` (`nome`, `quantidade`) VALUES ('$nome', $quantidade);";
            echo($sqlParaInsert);
			$retorno = $bd->query($sqlParaInsert); //boolean
            $e = mysqli_errno($bd);
            $eM = mysqli_error($bd);
            
            if (DEBUG) echo "@inserirAlimentoNaTabela : erro=$e ; mensagem=$eM<br>";
            
            if ($e===0){
                if (DEBUG) echo "<h1> Alimento inserido correctamente </h1>";
                return true;
            }
            else{
                return false;
            }
        }
        else
        {
            $msg="@inserirFotoNaTabela sem objeto bd válido<br>";
            if (DEBUG) echo $msg;
        }
        
        return false;
    }//inserirAlimentosNaTabela


function consultarAlimentos ($bd){
        if ($bd !== false){
            $html="<table border='1' >
				  <tr>
				    <td>Nome</td>
				    <td>Quantidade</td>
				  </tr>";
		
			$SQL = "SELECT * from `getao_dispensa`.`alimentos`;";

            $Registos = $bd->query ($SQL);
            //var_dump ($retorno);
            $nRegistos = $Registos->num_rows;
            
            //como aceder a cada registo concreto=
            for ($i=0; $i<$nRegistos; $i++){
                $r = $Registos->fetch_assoc(); // {'id'=>2, 'photoId'=>777, 'url'=>"url1, 'user'=>4321, 'dataDl'=>"2014-01-01-1-1-1"}
                
                $nome=$r['nome'];
                $quantidade = $r['quantidade'];
                
				//$dados = "Nome= $nome ; Quantidade= $quantidade <br>";
                $dados = "<tr><td> $nome</td> <td>$quantidade</td></tr>";
                
				$html=$html.$dados;
            }//for
            return $html."</table>";
            
        }//if
        else{
            $msg="@Não existem Alimentos inseridos<br>";
            if (DEBUG) echo $msg;
        }                                              
        
        return false;
  	
 
 
 
 
 
 
 
 /*
 
 
 
        $objetoBdOk = $bd!==false;
		echo "<br>";
		echo "object BD ".$objetoBdOk;
		echo "<br>";
		
        if ($objetoBdOk)
        {
            $sqlParaInsert = "SELECT * from `getao_dispensa`.`alimentos`;";
            echo($sqlParaInsert);
			$dados[] = $bd->query($sqlParaInsert); //boolean
            $e = mysqli_errno($bd);
            $eM = mysqli_error($bd);
            
            if (DEBUG) echo "@mostrarAlimentoNaTabela : erro=$e ; mensagem=$eM<br>";
            
            if ($e===0){
                if (DEBUG) 
				echo "<h1> Alimento inserido correctamente </h1>";
                	
					echo string($dados[]);
					
					//for ($x=0;$x=$dados; $x++){
						
					//}	
				return true;
            }
            else{
                return false;
            }
        }
        else
        {
            $msg="@inserirFotoNaTabela sem objeto bd válido<br>";
            if (DEBUG) echo $msg;
        }
        
        return false;*/
		
    }//consultarAlimentos


inserirAlimentoNaTabela($Alim,$Qty,estabelecerLigacaoMySQL());
echo consultarAlimentos(estabelecerLigacaoMySQL());



 }
 }
 else{
 	
 echo("<h1><a href=\"http://localhost:8080/ProjectoACA/login.html\" >Por favor registe-se na pagina inicial<a></h1>"); 
}
?>