<?php
    include "../../_Config/Connection.php";
    $no = 1;
    //KONDISI PENGATURAN MASING FILTER
    if(!empty($_POST['CariMember'])){
        $keyword= $_POST['CariMember'];
    }else{
        $keyword= $_POST['CariMember'];
    }
    //KONDISI PENGATURAN MASING FILTER
    $query = mysqli_query($conn, "SELECT*FROM member WHERE kategori='Konsumen' AND nama like '%$keyword%' OR nik like '%$keyword%' ORDER BY nama DESC LIMIT 50");
    while ($data = mysqli_fetch_array($query)) {
        $id_member = $data['id_member'];
        $nama= $data['nama'];
        $nik = $data['nik'];
        $point = $data['point'];
        echo '<tr>';
        echo '  <td align="center">';
        echo '      <input type="radio" checked name="id_member" value="'.$id_member.'">';
        echo '  </td>';
        echo '  <td align="left">';
        echo '      '.$nik .'';
        echo '  </td>';
        echo '  <td align="left">';
        echo '      '.$nama .'';
        echo '  </td>';
        echo '  <td align="left">';
        echo '      '.$point .'';
        echo '  </td>';
        echo '</tr>';
    }
?>