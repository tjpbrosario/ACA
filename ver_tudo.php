<?php
    include "utf8.php";
    
    define ("GUESTBOOK", "LivroVisitas.log");
    
    function lerEMostrarGB (){
        $fh=fopen (GUESTBOOK, "r");
        
        if ($fh!==false){
            echo "<h1>Guestbook atual:</h1>";
            
           while (!feof($fh)){
               $linha=fgets($fh);
               
               $linha=trim($linha);
               
               if ($linha!=="")
                echo $linha."<hr>";
           }//while
           fclose ($fh);
           
           return true; 
        }//
        else{
            echo "<h2>Erro: Não foi possível ler o Guestbook!</h2>";
            return false;
        }
    }//lerEMostrarGB
    
    lerEMostrarGB();
	
?>
