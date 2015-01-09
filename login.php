<?php
    include "utf8.php";
   	session_start();
	$_SESSION['login'] = ""; 
	
$uname = "";
$pword = "";
$errorMessage = "";

  define ("DEBUG", true);
      // estabelecer ligação
  /*  function estabelecerLigacaoMySQL
    ($servidor="localhost", $user="admin", $pwd="admin" , $schema="getao_dispensa", $porto=3333)
    {   
        $bd = mysqli_connect($servidor, $user, $pwd, $schema, $porto); //obj "mysqli" ou false se falhar
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
	






*/

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	echo $uname;
	echo "<br>";
	echo $pword; 
	$sal = "uisdhmftcklszrguilrhgmdklfhjvmlsdfkjcghmsdkjfhmsdkj";
	
	$servidor="localhost";
	$schema="getao_dispensa";
	$porto=3333;
	
	try{
		
				
	$bd = mysqli_connect($servidor, $uname, $pword, $schema, $porto);
	}
	catch(Exception $e){
		echo "Exceção pega: ",  $e->getMessage(), "\n";
	}
	
	
	
	$codigoDeErroDaUltimaOpDeConnect = mysqli_connect_errno(); //int
    $mensagemDeErroDaUltimaOpDeConnect = mysqli_connect_error(); //string
    echo "<br>";
    echo "Código de erro obtido= ".$codigoDeErroDaUltimaOpDeConnect;
    echo "<br>";
    $sucesso = $bd!==false;
    $sucesso = $mensagemDeErroDaUltimaOpDeConnect==="";
    $sucesso = $codigoDeErroDaUltimaOpDeConnect===0;
    
    if ($sucesso){
        //tenho um ponteiro para o serviço    
        if (DEBUG){
            $msg="<h1>Sucesso no estabelecimento da ligação!</h1>";
			
            //echo $msg;
			
			
		 //cria variavel de sessão com login valido
			
				session_start();
				$_SESSION['login'] = "1";
				header ("Location: Adicinar_Alimento.php");
		}// If sucesso
		else {
		header("Cache: no-cache"); 
			$errorMessage = "Utilizador ou password errada :-)";
			//header ("Location: index.php");
			session_start();
			$_SESSION['login'] = "";
			header ("Location: index.php");
			
		
		}
	
			
			
			$sha = sha1($sal.$pword);
	echo "<br>";
	//echo $sha;
	$SQL = "SELECT * FROM `getao_dispensa`.`login` WHERE `user` = '$uname' AND `pass` = '$sha'";
	//echo "<br>";
	//echo $SQL;
	//echo "<br>";
	
	
	//echo "<br>";
	
				
	$result = $bd->query($SQL); //boolean
        

	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

	        $e = mysqli_errno($bd);
            $eM = mysqli_error($bd);
            
           if ($e===0){
                if (DEBUG) echo "Login Correcto";
				session_start();
				$_SESSION['login'] = "1";
				header ("Location: Menu.php");
                
				return true;
            }
            else{
				session_start();
				$_SESSION['login'] = "";
				header ("Location: login.php");
				header("Cache: no-cache"); 
				$errorMessage = "Utilizador ou password errada :-)";
				
                return false;
			
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
			
		
		
	
       
}
	
	
	
	
	
    define ("BD_PASSWORDS", "passwords.dat");

    $sal = "uisdhmftcklszrguilrhgmdklfhjvmlsdfkjcghmsdkjfhmsdkj";
    
    function fazRegisto ($username, $password){
        global $sal;
        $u=$username;
        
        //$p=$password; //em aberto
        //$p = sha1 ($password); //ok1
        $pRobusta = sha1 ($sal.$password); //ok2
        
        $fh=fopen(BD_PASSWORDS, 'a');
        if ($fh!==false){
            flock ($fh, LOCK_EX);
            
            $tsv = "$u\t$pRobusta".PHP_EOL;
            fputs ($fh, $tsv);
            
            flock ($fh, LOCK_UN);
            fclose ($fh);
            
            return true;
        }//if
        
        return false;
    }//fazRegisto
               
    function estaPreenchido ($frase){
        if (is_string($frase)){
            $frase=trim($frase);
            return strlen($frase)>0;
        }//if
        
        return false;
    }//estaPreenchido
    
    function receberDados(){
        $ret=array ('username'=>"", 'password'=>"");
        
        $username = estaPreenchido ($_REQUEST['username'])?
            $_REQUEST['username']
            :
            "";
            
        $password = estaPreenchido ($_REQUEST['password'])?
            $_REQUEST['password']
            :
            "";
        
        $ret = array ('username'=>$username, 'password'=>$password);
        return $ret;
    }//receberDados
    
    function carregarBD (){
        $ret = array();
        
        $fh=fopen (BD_PASSWORDS, 'r');
        if ($fh!==false){
            flock ($fh, LOCK_SH);
            
            while (!feof ($fh)){
                $partesDoRegisto = fgetcsv ($fh, 2048, "\t");
                $quantasPartes = count($partesDoRegisto);
                if ($quantasPartes === 2){
                    $u = $partesDoRegisto [0];
                    $p = $partesDoRegisto [1];
                    $registo = array ('username'=>$u , 'password'=> $p);
                    $ret[]=$registo;
                }//if
            }//while
            
            flock ($fh, LOCK_UN);
            fclose ($fh);
        }//if
        
        return $ret;
    }//carregarBD
    
    function procurarNaBD ($parUP, $bd){
        global $sal;
        $cautela1 = is_array ($parUP);
        $cautela2 = is_array ($bd);
        
        if ($cautela1 && $cautela2){
             $cautela3 = count($parUP)===2; //há 2 elementos no par username/password
             $cautela4 = count ($bd)>0; //há registos?
             
             if ($cautela3 && $cautela4){
                foreach ($bd as $registo){
                    $u = $registo['username'];
                    $p = $registo['password'];
                    
                    $matchUsername = $u === $parUP['username'];
                    //$matchPassword = $p === $parUP['password'];
                    
                    $passwordEscritaPeloUtilizador = $parUP['password'];
                    $passwordQueVouCompararComRegisto =
                    sha1 ($sal.$passwordEscritaPeloUtilizador);
                    
                    //var_dump ($passwordQueVouCompararComRegisto);
                    
                    $matchPassword = $p === $passwordQueVouCompararComRegisto;
                    
                    $match = $matchUsername && $matchPassword; 
                    
                    if ($match) return
                            array('sucessoNoLogin' => true, 'username'=>$u, 'password'=>$p);
                }//foreach
             }//if
        }//if
        return array ('sucessoNoLogin'=>false, 'username'=>"", 'password'=>"");
    }//procurarNaBD
    
    //procurarNaBD (array('username'=>'Artur', 'password'=>'1234'), carregarBD());
    
    function responder ($r){
        if ($r['sucessoNoLogin'])
            echo "<h1>Ok, podes entrar</h1>";
        else
            echo "<h1>Sorry, ficas à porta</h1>";
    }//responder
    
    fazRegisto ("Artur", "1234"); //registo forçado só para termos um registo sério na BD
    
    $dados = receberDados();
    //var_dump ($dados); //tested ok
    
    $bd = carregarBD();
    //var_dump ($bd); //tested ok
    
    $resposta = procurarNaBD($dados, $bd);
    //var_dump ($resposta); //tested ok
    
    responder($resposta);
    
?>
