<?php
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/Connection.php";
    //Tipe Document
    echo "<!DOCTYPE html>";
    echo '<html lang="en">';
    //Komponen Head disimpan pada _Partial/Head.php
    include "_Partial/Head.php";
    //Komponen Body
    echo "  <body>";
    //Container scroller
    echo '      <div class="container-scroller">';
    //komponen Navbar disimpan di  _Partial/Navbar.php
    include "_Partial/Navbar.php";
    //Container Fluid
    echo '          <div class="container-fluid page-body-wrapper">';
    //komponen Sidebar disimpan di  _Partial/Sidebar.php
    echo '              <nav class="sidebar sidebar-offcanvas" id="MenuKanan">';
    echo '              </nav>';
    echo '              <div class="main-panel">';
    echo '                  <div class="content-wrapper" id="Halaman">';
    echo '                  </div>';
    echo '              </div>';
    echo '          </div>';
    //komponen Footer disimpan di  _Partial/Footer.php
    include "_Partial/Footer.php";
    echo '      </div>';
    include "_Partial/Modal.php";
    include "_Partial/ScriptJs.php";
    echo "  </body>";
    echo "</html>";
?>