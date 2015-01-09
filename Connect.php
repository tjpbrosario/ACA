<?php
  define ("DEBUG", true);
      // estabelecer liga��o
    function estabelecerLigacaoMySQL
    ($servidor="localhost", $user="admin", $pwd="admin" , $schema="getao_dispensa", $porto=3333)
    {   
        $bd = mysqli_connect($servidor, $user, $pwd, $schema, $porto); //obj "mysqli" ou false se falhar
        $codigoDeErroDaUltimaOpDeConnect = mysqli_connect_errno(); //int
        $mensagemDeErroDaUltimaOpDeConnect = mysqli_connect_error(); //string
        
        echo "C�digo de erro obtido= ".$codigoDeErroDaUltimaOpDeConnect;
        
        $sucesso = $bd!==false;
        $sucesso = $mensagemDeErroDaUltimaOpDeConnect==="";
        $sucesso = $codigoDeErroDaUltimaOpDeConnect===0;
        
        if ($sucesso){
            //tenho um ponteiro para o servi�o    
            if (DEBUG){
                $msg="<h1>Sucesso no estabelecimento da liga��o!</h1>";
                echo $msg;
            }//if
            return $bd;
        }//if
        else{
            if (DEBUG){
                $msg = "<h1>Fracasso no estabelecimento da liga��o:";
                $msg.=" c�digo de erro = $codigoDeErroDaUltimaOpDeConnect ";
                $msg.=" mensagem erro = $mensagemDeErroDaUltimaOpDeConnect";
                $msg.="</h1>";
                echo $msg;    
            }//if
            
        }//else
        
        return false;
    }//estabelecerLigacaoMySQL
  
  estabelecerLigacaoMySQL();
  
  
?>