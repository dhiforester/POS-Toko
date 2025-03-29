<?php 
    include "../../_Config/ConnectionDirect.php";

    if(isset($_POST["query"])){
      $output = '';
      $key = "%".$_POST["query"]."%";
      $query = "SELECT DISTINCT kategori FROM obat WHERE kategori LIKE ? LIMIT 10";
      $dewan1 = $db1->prepare($query);
      $dewan1->bind_param('s', $key);
      $dewan1->execute();
      $res1 = $dewan1->get_result();
      if(!empty($_POST["query"])){
        $output = '<ul class="list-group" style="height: 150px; overflow-y: scroll;">';
        if($res1->num_rows > 0){
          while ($row = $res1->fetch_assoc()) {
            $output .= '<li tabindex="0" class="list-group-item list-group-item-action" id="ListKategori"><a>'.$row["kategori"].'</a></li>';  
          }
          $output .= '</ul>';
          echo $output;
        } else {
          $output .= '';  
          $output .= '</ul>';
          echo $output;
        }  
        
      }
    }
?>